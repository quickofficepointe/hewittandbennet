<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * php artisan migrate:fresh --seed   -> setup + website content + demo data (local only)
     * php artisan db:seed --class=SetupSeeder   -> only the essentials (production)
     */
    public function run(): void
    {
        $this->call(SetupSeeder::class);
        $this->call(LegacyContentSeeder::class);

        if (app()->environment('local', 'testing')) {
            $this->call(DemoDataSeeder::class);
        }
    }
}
