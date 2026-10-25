<?php

namespace Database\Seeders;

use App\Models\AcademicTerm;
use App\Models\ExpenseCategory;
use App\Models\Intake;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Seeder;

/** Reference data every installation needs, plus the first director login. Safe to re-run. */
class SetupSeeder extends Seeder
{
    public function run(): void
    {
        $this->createFirstDirector();

        // Kenyan Employment Act 2007 minimums.
        foreach ([
            ['Annual Leave', 21, true],
            ['Sick Leave', 14, true],
            ['Maternity Leave', 90, true],
            ['Paternity Leave', 14, true],
            ['Compassionate Leave', 5, true],
            ['Unpaid Leave', 30, false],
        ] as [$name, $days, $paid]) {
            LeaveType::firstOrCreate(['name' => $name], ['days_per_year' => $days, 'is_paid' => $paid]);
        }

        foreach (['Rent & Utilities', 'Teaching Materials', 'Clinical Placement', 'Marketing & Advertising', 'Transport', 'Repairs & Maintenance', 'Stationery & Printing', 'Internet & Communication', 'Licences & Accreditation', 'Miscellaneous'] as $category) {
            ExpenseCategory::firstOrCreate(['name' => $category]);
        }

        $year = now()->year;
        if (! AcademicTerm::exists()) {
            foreach ([
                ["Jan - Apr {$year}", "{$year}-01-06", "{$year}-04-17"],
                ["May - Aug {$year}", "{$year}-05-04", "{$year}-08-14"],
                ["Sep - Dec {$year}", "{$year}-09-07", "{$year}-12-11"],
            ] as [$name, $start, $end]) {
                AcademicTerm::create(['name' => $name, 'start_date' => $start, 'end_date' => $end]);
            }
            // Current term = the latest one that has already started (or the first if none has).
            (AcademicTerm::whereDate('start_date', '<=', today())->orderByDesc('start_date')->first() ?? AcademicTerm::orderBy('start_date')->first())
                ->update(['is_current' => true]);
        }

        if (! Intake::exists()) {
            foreach (['January', 'May', 'September'] as $month) {
                Intake::create(['name' => "{$month} {$year}", 'start_date' => date('Y-m-d', strtotime("first monday of {$month} {$year}")), 'is_open' => true]);
            }
        }
    }

    /** Creates the "director" login unless a director account already exists (e.g. on the live site). */
    private function createFirstDirector(): void
    {
        $email = 'director@hewittbennet.co.ke';
        if (User::where('role', User::DIRECTOR)->orWhere('username', 'director')->orWhere('email', $email)->exists()) {
            return;
        }

        $password = env('DIRECTOR_PASSWORD');
        if (! $password && app()->isProduction()) {
            $this->command?->warn('No director account created: set DIRECTOR_PASSWORD in .env and run this seeder again.');

            return;
        }

        User::create([
            'name' => 'College Director',
            'username' => 'director',
            'email' => $email,
            'role' => User::DIRECTOR,
            'password' => $password ?: 'ChangeMe@2026',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
