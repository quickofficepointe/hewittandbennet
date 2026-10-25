<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Brings a database created by the old website/portal code up to the new schema.
 * On a fresh install every step is skipped.
 *
 * - Website tables recorded as migrated but missing are recreated.
 * - Old portal tables whose names the new portal reuses are renamed to legacy_* (data kept).
 * - Columns that were added to already-run migrations are added here.
 */
return new class extends Migration
{
    /** Old table => a column only the new version of that table has. */
    private const CLASHING_TABLES = [
        'students' => 'admission_no',
        'units' => 'learning_outcomes',
        'online_exams' => 'duration_minutes',
    ];

    public function up(): void
    {
        // A migration can be recorded as run while its table is missing (e.g. a table dropped by hand).
        // The older create migrations skip existing tables, so re-running them only fills the gaps.
        foreach (glob(database_path('migrations/20{14,19,23,24,25}_*.php'), GLOB_BRACE) as $file) {
            $this->resolve($file)->up();
        }

        foreach (self::CLASHING_TABLES as $table => $newColumn) {
            if (Schema::hasTable($table) && ! Schema::hasColumn($table, $newColumn)) {
                $legacy = $this->freeLegacyName($table);
                Schema::rename($table, $legacy);
                // MySQL constraint names are unique per database; free them for the new table.
                $this->dropForeignKeys($legacy);
            }
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'phone')) {
                    $table->string('phone')->nullable();
                }
                if (! Schema::hasColumn('users', 'avatar')) {
                    $table->string('avatar')->nullable();
                }
                if (! Schema::hasColumn('users', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
                if (! Schema::hasColumn('users', 'last_login_at')) {
                    $table->timestamp('last_login_at')->nullable();
                }
            });
        }

        if (Schema::hasTable('partners') && DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE partners MODIFY logo VARCHAR(255) NULL, MODIFY description TEXT NULL');
        }
    }

    public function down(): void
    {
        // Renamed legacy tables and added columns are kept; restore from backup if needed.
    }

    /** Instantiates a migration file, whether it returns an anonymous class or declares a named one. */
    private function resolve(string $file): Migration
    {
        // Same naming rule Laravel's migrator uses for named migration classes.
        $class = Str::studly(implode('_', array_slice(explode('_', basename($file, '.php')), 4)));
        if (class_exists($class, false)) {
            return new $class;
        }

        $migration = require $file;

        return is_object($migration) ? $migration : new $class;
    }

    private function dropForeignKeys(string $table): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $names = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->pluck('CONSTRAINT_NAME');

        foreach ($names as $name) {
            DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$name}`");
        }
    }

    private function freeLegacyName(string $table): string
    {
        $name = "legacy_{$table}";
        for ($i = 2; Schema::hasTable($name); $i++) {
            $name = "legacy_{$table}_{$i}";
        }

        return $name;
    }
};
