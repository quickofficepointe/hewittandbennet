<?php

namespace Database\Seeders;

use App\Models\AcademicTerm;
use App\Models\Announcement;
use App\Models\Assessment;
use App\Models\AssessmentResult;
use App\Models\Attendance;
use App\Models\Campus;
use App\Models\courses;
use App\Models\department;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\FeeStructureItem;
use App\Models\Intake;
use App\Models\Invoice;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\OnlineExam;
use App\Models\Payment;
use App\Models\PayrollRun;
use App\Models\Payslip;
use App\Models\Student;
use App\Models\TimetableEntry;
use App\Models\Unit;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Sample data so every dashboard can be explored straight away (local/testing only).
 * All demo logins use the password "password".
 */
class DemoDataSeeder extends Seeder
{
    private const PASSWORD = 'password';

    public function run(): void
    {
        if (Student::exists()) {
            return; // never mix demo data into a database that already has real records
        }

        $faker = Faker::create('en_US');
        mt_srand(2026);
        $faker->seed(2026);

        $this->ensureCourses();
        $departments = department::pluck('id');
        $campus = Campus::first();
        $term = AcademicTerm::current();
        $intake = Intake::orderBy('start_date')->first();

        // ---- Staff logins + employee records ----
        $director = User::where('role', User::DIRECTOR)->first();
        $staff = [
            ['admin', 'Grace Wanjiku', User::ADMIN, 'Registrar / Administrator', 85000],
            ['hr', 'Peter Otieno', User::HR, 'Human Resource Officer', 75000],
            ['accounts', 'Mary Njeri', User::ACCOUNTANT, 'Accountant', 80000],
            ['trainer', 'Dr. James Mwangi', User::TRAINER, 'Senior Nursing Trainer', 95000],
            ['trainer2', 'Faith Achieng', User::TRAINER, 'Caregiving Trainer', 60000],
            ['trainer3', 'Samuel Kiprono', User::TRAINER, 'Hospitality Trainer', 55000],
            ['trainer4', 'Lucy Wambui', User::TRAINER, 'German Language Trainer', 65000],
        ];

        $employees = collect();
        $employees->push($this->employee($director, 'Director', 250000, $departments->first(), $campus));
        foreach ($staff as [$username, $name, $role, $designation, $salary]) {
            $user = User::create([
                'name' => $name,
                'username' => $username,
                'email' => "{$username}@hewittbennet.co.ke",
                'phone' => '07'.mt_rand(10000000, 99999999),
                'role' => $role,
                'password' => self::PASSWORD,
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            $employees->push($this->employee($user, $designation, $salary, $departments->random(), $campus));
        }
        // A couple of support staff without portal logins.
        foreach ([['Joseph', 'Kamau', 'Security Officer', 25000], ['Ann', 'Mutua', 'Cleaner', 18000]] as [$first, $last, $designation, $salary]) {
            $employees->push(Employee::create([
                'employee_no' => Employee::nextEmployeeNo(), 'first_name' => $first, 'last_name' => $last,
                'designation' => $designation, 'employment_type' => 'contract', 'date_hired' => now()->subMonths(mt_rand(3, 30)),
                'basic_salary' => $salary, 'campus_id' => $campus?->id, 'status' => 'active', 'phone' => '07'.mt_rand(10000000, 99999999),
            ]));
        }

        $trainers = User::where('role', User::TRAINER)->get();

        // ---- Units, timetable and fee structures for the first four courses ----
        $courses = courses::orderBy('id')->take(4)->get();
        $unitTemplates = [
            ['Communication Skills', "Communicate effectively with clients and colleagues\nApply active listening techniques\nPrepare simple written reports"],
            ['Occupational Health & Safety', "Identify workplace hazards\nApply infection prevention and control measures\nRespond appropriately to emergencies"],
            ['Core Practical Skills', "Demonstrate the core practical skills of the trade\nUse tools and equipment safely\nFollow standard operating procedures"],
            ['Professional Ethics', "Explain the code of conduct of the profession\nApply ethical principles in practice\nMaintain client confidentiality"],
            ['Entrepreneurship', "Identify business opportunities\nPrepare a simple business plan\nKeep basic business records"],
            ['Industrial Attachment Preparation', "Prepare a CV and cover letter\nDemonstrate workplace etiquette\nDocument practical experience in a logbook"],
        ];

        $slot = 0;
        foreach ($courses as $c => $course) {
            $course->update(['total_terms' => max($course->total_terms, 2), 'code' => $course->code ?: 'HB'.str_pad((string) $course->id, 3, '0', STR_PAD_LEFT)]);
            foreach ($unitTemplates as $u => [$name, $outcomes]) {
                $unit = Unit::create([
                    'course_id' => $course->id,
                    'code' => sprintf('%s/%d%02d', $course->code, $u < 3 ? 1 : 2, $u + 1),
                    'name' => $name,
                    'description' => "{$name} for {$course->name} students.",
                    'learning_outcomes' => $outcomes,
                    'term_no' => $u < 3 ? 1 : 2,
                    'hours' => [40, 30, 80, 30, 40, 20][$u],
                    'trainer_id' => $trainers[($c + $u) % $trainers->count()]->id,
                ]);
                // Two lessons per week, spread across days so trainers are not double-booked.
                foreach ([0, 2] as $offset) {
                    $day = (($slot + $offset) % 5) + 1;
                    $hour = 8 + 2 * (intdiv($slot, 5) % 4);
                    TimetableEntry::create([
                        'unit_id' => $unit->id, 'day_of_week' => $day,
                        'start_time' => sprintf('%02d:00', $hour), 'end_time' => sprintf('%02d:00', $hour + 2),
                        'venue' => ['Room 1', 'Room 2', 'Skills Lab', 'Room 3'][$c],
                    ]);
                }
                $slot++;
            }

            $tuition = (float) ($course->school_fees ?: 45000);
            FeeStructureItem::create(['course_id' => $course->id, 'term_no' => null, 'name' => 'Registration', 'amount' => (float) ($course->registration_fees ?: 2000)]);
            FeeStructureItem::create(['course_id' => $course->id, 'term_no' => null, 'name' => 'Uniform', 'amount' => (float) ($course->school_uniform_fee ?: 3500)]);
            foreach ([1, 2] as $termNo) {
                FeeStructureItem::create(['course_id' => $course->id, 'term_no' => $termNo, 'name' => 'Tuition', 'amount' => round($tuition / 2, -2)]);
                FeeStructureItem::create(['course_id' => $course->id, 'term_no' => $termNo, 'name' => 'Exam & Assessment', 'amount' => 2500]);
            }
        }

        // ---- Students, invoices and payments ----
        $accounts = User::where('username', 'accounts')->first();
        foreach (range(1, 48) as $i) {
            $course = $courses[$i % $courses->count()];
            $gender = $i % 3 === 0 ? 'male' : 'female';
            $admitted = Carbon::parse($intake->start_date)->addDays(mt_rand(0, 10));
            $student = Student::create([
                'admission_no' => Student::nextAdmissionNo(),
                'first_name' => $faker->firstName($gender),
                'last_name' => $faker->randomElement(['Wanjiru', 'Ochieng', 'Mutua', 'Kamau', 'Njoroge', 'Achieng', 'Kiptoo', 'Wafula', 'Nduta', 'Omondi', 'Chebet', 'Mwende']),
                'gender' => $gender,
                'phone' => '07'.mt_rand(10000000, 99999999),
                'id_number' => (string) mt_rand(20000000, 39999999),
                'date_of_birth' => now()->subYears(mt_rand(18, 30))->subDays(mt_rand(0, 360)),
                'address' => $faker->randomElement(['Nairobi', 'Thika', 'Buruburu', 'Ruiru', 'Kiambu', 'Machakos']),
                'guardian_name' => $faker->name(),
                'guardian_phone' => '07'.mt_rand(10000000, 99999999),
                'guardian_relationship' => $faker->randomElement(['Parent', 'Guardian', 'Sibling']),
                'course_id' => $course->id,
                'intake_id' => $intake->id,
                'campus_id' => $campus?->id,
                'mode_of_study' => 'Full time',
                'current_term' => 1,
                'admission_date' => $admitted,
                'status' => $i === 47 ? 'deferred' : 'active',
            ]);

            if ($i === 1) {
                $user = User::create([
                    'name' => $student->full_name, 'username' => $student->admission_no, 'email' => 'student@hewittbennet.co.ke',
                    'role' => User::STUDENT, 'password' => self::PASSWORD, 'is_active' => true, 'email_verified_at' => now(),
                ]);
                $student->update(['user_id' => $user->id, 'email' => $user->email]);
            }

            $billed = 0;
            foreach ($course->feeItems()->where(fn ($q) => $q->whereNull('term_no')->orWhere('term_no', 1))->get() as $item) {
                Invoice::create([
                    'invoice_no' => Invoice::nextNumber(), 'student_id' => $student->id, 'academic_term_id' => $term?->id,
                    'description' => $item->name.($item->term_no ? " - Term {$item->term_no}" : ''),
                    'amount' => $item->amount, 'invoice_date' => $admitted, 'due_date' => $admitted->copy()->addDays(30), 'created_by' => $accounts->id,
                ]);
                $billed += $item->amount;
            }

            // Most students have paid something; a few are fully paid, some owe a lot.
            $share = [1, 1, 0.8, 0.6, 0.5, 0.35, 0][$i % 7];
            $remaining = round($billed * $share, -2);
            $paidOn = $admitted->copy();
            while ($remaining > 0) {
                $amount = min($remaining, round(mt_rand(5000, 25000), -2));
                $paidOn = $paidOn->copy()->addDays(mt_rand(5, 30));
                if ($paidOn->isFuture()) {
                    $paidOn = today();
                }
                $method = $faker->randomElement(['mpesa', 'mpesa', 'mpesa', 'bank', 'cash']);
                Payment::create([
                    'receipt_no' => Payment::nextReceiptNo(), 'student_id' => $student->id, 'amount' => $amount, 'method' => $method,
                    'reference' => $method === 'cash' ? null : strtoupper($faker->bothify('??#?##?#??')),
                    'paid_on' => $paidOn, 'received_by' => $accounts->id,
                ]);
                $remaining -= $amount;
            }
        }

        // ---- Attendance and assessments for term 1 units ----
        foreach (Unit::where('term_no', 1)->get() as $unit) {
            $students = $unit->students()->get();
            foreach (range(1, 12) as $daysAgo) {
                $date = today()->subWeekdays($daysAgo);
                if (! $unit->timetable->pluck('day_of_week')->contains($date->dayOfWeekIso)) {
                    continue;
                }
                foreach ($students as $student) {
                    $roll = mt_rand(1, 100);
                    Attendance::create([
                        'unit_id' => $unit->id, 'student_id' => $student->id, 'date' => $date->toDateString(),
                        'status' => $roll <= 82 ? 'present' : ($roll <= 90 ? 'late' : ($roll <= 97 ? 'absent' : 'excused')),
                        'marked_by' => $unit->trainer_id,
                    ]);
                }
            }

            foreach ([['CAT 1', 'cat', 30, 30, true], ['Practical Assessment 1', 'practical', 50, 30, true], ['End of Term Exam', 'exam', 100, 40, false]] as [$title, $type, $max, $weight, $published]) {
                $assessment = Assessment::create([
                    'unit_id' => $unit->id, 'academic_term_id' => $term?->id, 'title' => $title, 'type' => $type,
                    'max_score' => $max, 'weight' => $weight, 'date' => today()->subDays(mt_rand(3, 20)),
                    'published' => $published, 'created_by' => $unit->trainer_id,
                ]);
                if (! $published) {
                    continue; // left for the trainer to mark
                }
                foreach ($students as $student) {
                    AssessmentResult::create([
                        'assessment_id' => $assessment->id, 'student_id' => $student->id,
                        'score' => round(min($max, max(0, $max * (mt_rand(35, 98) / 100))), 1),
                    ]);
                }
            }
        }

        // ---- One open online exam ----
        $examUnit = Unit::where('term_no', 1)->where('course_id', $courses->first()->id)->first();
        $exam = OnlineExam::create([
            'unit_id' => $examUnit->id, 'title' => "{$examUnit->name} - Quiz 1",
            'instructions' => 'Answer all questions. Each question has one correct answer.',
            'duration_minutes' => 15, 'opens_at' => now()->subDay(), 'closes_at' => now()->addWeeks(2),
            'published' => true, 'created_by' => $examUnit->trainer_id,
        ]);
        foreach ([
            ['Which of these is the most effective way to prevent the spread of infection?', ['Wearing a uniform', 'Hand washing', 'Opening windows', 'Using perfume'], 1],
            ['What should you do first when you notice a fire in the workplace?', ['Raise the alarm', 'Finish your task', 'Hide the evidence', 'Call a friend'], 0],
            ['PPE stands for:', ['Personal Protective Equipment', 'Public Patient Education', 'Primary Patient Examination', 'Personal Practice Evaluation'], 0],
            ['Client information should be shared:', ['With anyone who asks', 'On social media', 'Only with authorised people', 'With other clients'], 2],
        ] as [$question, $options, $correct]) {
            $exam->questions()->create(['question' => $question, 'options' => $options, 'correct_option' => $correct, 'marks' => 2]);
        }

        // ---- Expenses ----
        $categories = ExpenseCategory::pluck('id', 'name');
        foreach ([
            ['Rent & Utilities', 'Thika campus rent', 'Landlord Properties Ltd', 120000, 'approved', 40],
            ['Internet & Communication', 'Fibre internet - monthly', 'Safaricom', 9500, 'approved', 25],
            ['Teaching Materials', 'Mannequins for skills lab', 'Medisupplies Kenya', 65000, 'approved', 15],
            ['Marketing & Advertising', 'Facebook & TikTok ads', 'Meta', 20000, 'approved', 10],
            ['Stationery & Printing', 'Exam papers printing', 'Quick Print', 7800, 'pending', 3],
            ['Repairs & Maintenance', 'Plumbing repairs - washrooms', 'Fundi Works', 12500, 'pending', 1],
            ['Transport', 'Clinical placement transport', 'City Shuttle', 18000, 'rejected', 6],
        ] as [$category, $description, $payee, $amount, $status, $daysAgo]) {
            Expense::create([
                'expense_category_id' => $categories[$category], 'description' => $description, 'payee' => $payee,
                'amount' => $amount, 'expense_date' => today()->subDays($daysAgo), 'method' => 'bank',
                'status' => $status, 'recorded_by' => $accounts->id,
                'approved_by' => $status !== 'pending' ? $director->id : null, 'approved_at' => $status !== 'pending' ? now()->subDays(max(0, $daysAgo - 1)) : null,
            ]);
        }

        // ---- Payroll: last month paid, this month awaiting approval ----
        $hr = User::where('username', 'hr')->first();
        foreach ([[now()->subMonth()->format('Y-m'), 'paid'], [now()->format('Y-m'), 'draft']] as [$period, $status]) {
            $run = PayrollRun::create([
                'period' => $period, 'status' => $status, 'prepared_by' => $hr->id,
                'approved_by' => $status === 'paid' ? $director->id : null, 'approved_at' => $status === 'paid' ? now()->subDays(20) : null,
                'paid_by' => $status === 'paid' ? $accounts->id : null, 'paid_at' => $status === 'paid' ? now()->subDays(18) : null,
            ]);
            foreach ($employees as $employee) {
                $run->payslips()->create(['employee_id' => $employee->id] + Payslip::figuresFor($employee));
            }
            $run->recalculateTotals();
        }

        // ---- Leave ----
        $annual = LeaveType::where('name', 'Annual Leave')->first();
        $sick = LeaveType::where('name', 'Sick Leave')->first();
        $trainerEmployee = $employees->first(fn ($e) => $e->user?->username === 'trainer2');
        LeaveRequest::create(['employee_id' => $trainerEmployee->id, 'leave_type_id' => $annual->id, 'start_date' => today()->addWeekdays(10), 'end_date' => today()->addWeekdays(14), 'days' => 5, 'reason' => 'Family function upcountry', 'status' => 'pending']);
        LeaveRequest::create(['employee_id' => $employees[2]->id, 'leave_type_id' => $sick->id, 'start_date' => today()->subDays(20), 'end_date' => today()->subDays(18), 'days' => 3, 'reason' => 'Flu', 'status' => 'approved', 'reviewed_by' => $hr->id, 'reviewed_at' => now()->subDays(21)]);

        // ---- Recruitment ----
        $vacancy = JobVacancy::create([
            'title' => 'Nursing Trainer (Part time)', 'department_id' => $departments->first(), 'location' => 'Thika',
            'employment_type' => 'part_time', 'is_open' => true, 'closing_date' => today()->addMonth(),
            'description' => "We are looking for a passionate nursing trainer to deliver practical and theory sessions to certificate students.",
            'requirements' => "Diploma or Degree in Nursing\nValid NCK licence\nAt least 2 years clinical experience",
        ]);
        JobApplication::create(['job_vacancy_id' => $vacancy->id, 'name' => 'Esther Wairimu', 'email' => 'esther@example.com', 'phone' => '0712345678', 'cover_letter' => 'I am a registered nurse with 4 years of experience...', 'cv_path' => 'job-applications/sample-cv.pdf', 'status' => 'new']);

        // ---- Announcements ----
        Announcement::create(['title' => 'Welcome to the new HBIC portal', 'body' => "All students and staff can now access timetables, results, fee statements and more from one place.\nPlease change your password after your first login.", 'audience' => 'everyone', 'is_pinned' => true, 'posted_by' => $director->id]);
        Announcement::create(['title' => 'End of term exams timetable', 'body' => 'End of term examinations start in three weeks. Ensure your fees are cleared to receive an exam card.', 'audience' => 'students', 'posted_by' => User::where('username', 'admin')->value('id')]);
        Announcement::create(['title' => 'Staff meeting on Friday', 'body' => 'All staff are invited to the monthly staff meeting on Friday at 3pm in the boardroom.', 'audience' => 'staff', 'posted_by' => $director->id]);
    }

    private function employee(User $user, string $designation, float $salary, ?int $departmentId, $campus): Employee
    {
        [$first, $last] = array_pad(explode(' ', str_replace('Dr. ', '', $user->name), 2), 2, '');

        return Employee::create([
            'user_id' => $user->id, 'employee_no' => Employee::nextEmployeeNo(), 'first_name' => $first, 'last_name' => $last,
            'email' => $user->email, 'phone' => $user->phone, 'designation' => $designation, 'department_id' => $departmentId,
            'campus_id' => $campus?->id, 'employment_type' => 'permanent', 'date_hired' => now()->subMonths(mt_rand(6, 48)),
            'basic_salary' => round($salary * 0.8, -2), 'house_allowance' => round($salary * 0.15, -2), 'other_allowances' => round($salary * 0.05, -2),
            'kra_pin' => 'A00'.mt_rand(1000000, 9999999).'Z', 'nssf_no' => (string) mt_rand(100000000, 999999999), 'shif_no' => (string) mt_rand(100000000, 999999999),
            'bank_name' => 'Equity Bank', 'bank_account' => (string) mt_rand(1000000000, 9999999999), 'status' => 'active',
        ]);
    }

    /** Test/blank databases have no website content: create a minimal course catalogue. */
    private function ensureCourses(): void
    {
        if (courses::exists()) {
            return;
        }

        $health = department::create(['name' => 'Department of Health Sciences', 'description' => 'Health and caregiving programmes.']);
        $hospitality = department::create(['name' => 'Hospitality', 'description' => 'Hospitality and catering programmes.']);
        Campus::create(['name' => 'Thika Campus', 'city' => 'Thika', 'is_main' => true]);

        foreach ([
            [$health, 'Certificate in Caregiving', 45000, '6 months'],
            [$health, 'Certified Nursing Assistant', 60000, '8 months'],
            [$hospitality, 'Certificate in Food & Beverage', 40000, '6 months'],
            [$health, 'German Language A1-B2', 70000, '8 months'],
        ] as [$department, $name, $fees, $duration]) {
            courses::create([
                'department_id' => $department->id, 'name' => $name, 'school_fees' => $fees, 'registration_fees' => 2000,
                'duration' => $duration, 'course_description' => "{$name} programme.", 'school_uniform_fee' => 3500, 'total_terms' => 2,
            ]);
        }
    }
}
