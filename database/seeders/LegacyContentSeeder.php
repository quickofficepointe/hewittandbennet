<?php

namespace Database\Seeders;

use App\Models\courses;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Restores the public website's departments, courses, campuses, gallery and banners
 * (exported from the previous database) when the tables are empty. MySQL only.
 */
class LegacyContentSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/legacy_content.sql');

        if (courses::exists() || ! is_file($file) || DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared(file_get_contents($file));

        // Give each imported course a short code and a sensible number of terms for the portal.
        courses::all()->each(function ($course) {
            $months = (int) filter_var($course->duration, FILTER_SANITIZE_NUMBER_INT);
            $isYears = str_contains(strtolower((string) $course->duration), 'year');
            $totalMonths = $isYears ? $months * 12 : $months;

            $course->updateQuietly([
                'code' => $course->code ?: 'HB'.str_pad((string) $course->id, 3, '0', STR_PAD_LEFT),
                'total_terms' => max(1, min(12, (int) ceil(($totalMonths ?: 4) / 4))),
            ]);
        });
    }
}
