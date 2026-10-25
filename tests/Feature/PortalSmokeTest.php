<?php

namespace Tests\Feature;

use App\Models\Assessment;
use App\Models\courseapplication;
use App\Models\Employee;
use App\Models\OnlineExam;
use App\Models\Payment;
use App\Models\PayrollRun;
use App\Models\Payslip;
use App\Models\Student;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Loads every portal page as the role that owns it, using the demo data. */
class PortalSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    private function as(string $username): static
    {
        return $this->actingAs(User::where('username', $username)->firstOrFail());
    }

    private function assertPagesLoad(string $username, array $urls): void
    {
        $this->as($username);
        foreach ($urls as $url) {
            $response = $this->get($url);
            $this->assertSame(200, $response->status(), "GET {$url} as {$username} returned {$response->status()}".
                ($response->status() >= 500 ? ': '.($response->exception?->getMessage() ?? '') : ''));
        }
    }

    public function test_public_pages_load(): void
    {
        foreach (['/', '/courses', '/jobs', '/registration', '/login', '/gallery', '/hewittandbennet/news', '/feesstructure', '/attachment'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_dashboard_redirects_each_role(): void
    {
        foreach (['director' => 'director', 'admin' => 'admin', 'trainer' => 'trainer', 'hr' => 'hr', 'accounts' => 'accounts'] as $username => $segment) {
            $this->as($username)->get('/portal')->assertRedirectContains("/portal/{$segment}/dashboard");
        }
    }

    public function test_login_with_username_and_inactive_block(): void
    {
        $this->post('/login', ['email' => 'admin', 'password' => 'password'])->assertRedirect('/portal');
        $this->post('/logout');

        User::where('username', 'hr')->update(['is_active' => false]);
        $this->post('/login', ['email' => 'hr', 'password' => 'password'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_director_pages(): void
    {
        $run = PayrollRun::where('status', 'draft')->first();
        $this->assertPagesLoad('director', [
            route('portal.director.dashboard'),
            route('portal.director.reports.academic'),
            route('portal.director.reports.finance'),
            route('portal.director.reports.hr'),
            route('portal.director.expenses'),
            route('portal.director.payroll'),
            route('portal.director.payroll', ['run' => $run->id]),
            // Directors can open every staff module.
            route('portal.admin.dashboard'),
            route('portal.hr.dashboard'),
            route('portal.accounts.dashboard'),
            route('portal.announcements.index'),
            route('portal.profile.edit'),
            route('portal.my.leave'),
            route('portal.my.payslips'),
        ]);
    }

    public function test_admin_pages(): void
    {
        $student = Student::first();
        $unit = Unit::first();
        $this->assertPagesLoad('admin', [
            route('portal.admin.dashboard'),
            route('portal.admin.users.index'),
            route('portal.admin.users.create'),
            route('portal.admin.users.edit', User::first()),
            route('portal.admin.students.index'),
            route('portal.admin.students.index', ['q' => 'a', 'status' => 'active']),
            route('portal.admin.students.create'),
            route('portal.admin.students.show', $student),
            route('portal.admin.students.edit', $student),
            route('portal.admin.applications.index'),
            route('portal.admin.units.index'),
            route('portal.admin.units.create'),
            route('portal.admin.units.edit', $unit),
            route('portal.admin.timetable.index'),
            route('portal.admin.setup.index'),
            route('portal.admin.results.index'),
            route('portal.admin.results.show', $unit),
            route('portal.admin.attachments.index'),
            route('portal.announcements.index'),
            // Website content management.
            route('hewitt_banners.index'), route('index.departments'), route('index.cdpert'), route('registrationforms.index'),
            route('newsandevent.index'), route('gallery.index'), route('campuses.index'), route('tiktok-videos.index'),
            route('testimonials.index'), route('index.review'), route('teams.index'), route('partners.show'),
        ]);
    }

    public function test_trainer_pages(): void
    {
        $trainer = User::where('username', 'trainer')->first();
        $unit = Unit::where('trainer_id', $trainer->id)->first();
        $assessment = Assessment::where('unit_id', $unit->id)->first();
        $exam = OnlineExam::first();
        $examOwner = User::find($exam->unit->trainer_id)->username;

        $this->assertPagesLoad('trainer', [
            route('portal.trainer.dashboard'),
            route('portal.trainer.timetable'),
            route('portal.trainer.units.index'),
            route('portal.trainer.units.show', $unit),
            route('portal.trainer.units.attendance', $unit),
            route('portal.trainer.units.assessments.show', $assessment),
            route('portal.trainer.exams.index'),
            route('portal.my.leave'),
            route('portal.my.payslips'),
        ]);
        $this->assertPagesLoad($examOwner, [route('portal.trainer.exams.show', $exam)]);

        // A trainer cannot open another trainer's unit.
        $other = Unit::where('trainer_id', '!=', $trainer->id)->first();
        $this->as('trainer')->get(route('portal.trainer.units.show', $other))->assertForbidden();
    }

    public function test_student_pages_and_exam_flow(): void
    {
        $exam = OnlineExam::first();
        $student = User::where('role', User::STUDENT)->first()->student;
        $student->update(['course_id' => $exam->unit->course_id, 'current_term' => $exam->unit->term_no]);
        $unit = $student->units()->first();
        $payment = $student->payments()->first();

        $urls = [
            route('portal.student.dashboard'),
            route('portal.student.units'),
            route('portal.student.units.show', $unit),
            route('portal.student.timetable'),
            route('portal.student.attendance'),
            route('portal.student.results'),
            route('portal.student.results.transcript'),
            route('portal.student.fees'),
            route('portal.student.exams.index'),
            route('portal.announcements.index'),
            route('portal.profile.edit'),
        ];
        if ($payment) {
            $urls[] = route('portal.student.fees.receipt', $payment);
        }
        $this->assertPagesLoad($student->user->username, $urls);

        $this->get(route('portal.student.exams.take', $exam))->assertOk();
        $answers = $exam->questions->mapWithKeys(fn ($q) => [$q->id => $q->correct_option])->all();
        $this->post(route('portal.student.exams.submit', $exam), ['answers' => $answers])->assertRedirect();
        $this->assertEquals($exam->questions->sum('marks'), $exam->attempts()->first()->score);
        $this->get(route('portal.student.exams.take', $exam))->assertOk()->assertSee('/ '.$exam->questions->sum('marks'));

        // Units from another course are off limits.
        $foreign = Unit::where('course_id', '!=', $student->course_id)->first();
        $this->get(route('portal.student.units.show', $foreign))->assertForbidden();

        // Students are kept out of staff modules.
        $this->get(route('portal.admin.dashboard'))->assertForbidden();
        $this->get(route('portal.accounts.dashboard'))->assertForbidden();
        $this->get(route('hewitt_banners.index'))->assertForbidden();
    }

    public function test_hr_pages(): void
    {
        $employee = Employee::first();
        $run = PayrollRun::first();
        $this->assertPagesLoad('hr', [
            route('portal.hr.dashboard'),
            route('portal.hr.employees.index'),
            route('portal.hr.employees.create'),
            route('portal.hr.employees.show', $employee),
            route('portal.hr.employees.edit', $employee),
            route('portal.hr.leave.index'),
            route('portal.hr.leave.index', ['status' => 'all']),
            route('portal.hr.leave-types.index'),
            route('portal.hr.payroll.index'),
            route('portal.hr.payroll.show', $run),
            route('portal.hr.vacancies.index'),
            route('portal.hr.applications.index'),
            route('portal.payslips.show', Payslip::first()),
        ]);
    }

    public function test_accounts_pages(): void
    {
        $student = Student::first();
        $this->assertPagesLoad('accounts', [
            route('portal.accounts.dashboard'),
            route('portal.accounts.payments.index'),
            route('portal.accounts.payments.create'),
            route('portal.accounts.payments.create', ['q' => 'HBIC']),
            route('portal.accounts.payments.create', ['student' => $student->id]),
            route('portal.accounts.payments.receipt', Payment::first()),
            route('portal.accounts.invoices.index'),
            route('portal.accounts.balances'),
            route('portal.accounts.balances', ['filter' => 'all', 'status' => 'all']),
            route('portal.accounts.balances.statement', $student),
            route('portal.accounts.fees.index'),
            route('portal.accounts.expenses.index'),
            route('portal.accounts.payroll.index'),
            route('portal.accounts.payroll.show', PayrollRun::where('status', 'paid')->first()),
            route('portal.accounts.reports'),
        ]);
    }

    public function test_payment_and_payroll_workflow(): void
    {
        $student = Student::first();
        $before = $student->balance;

        $this->as('accounts')->post(route('portal.accounts.payments.store'), [
            'student_id' => $student->id, 'amount' => 1500, 'method' => 'mpesa', 'reference' => 'TEST123ABC', 'paid_on' => today()->toDateString(),
        ])->assertRedirect();
        $this->assertEquals($before - 1500, $student->fresh()->balance);

        // The same M-Pesa code cannot be captured twice.
        $this->post(route('portal.accounts.payments.store'), [
            'student_id' => $student->id, 'amount' => 1500, 'method' => 'mpesa', 'reference' => 'TEST123ABC', 'paid_on' => today()->toDateString(),
        ])->assertSessionHasErrors('reference');

        // Draft payroll -> director approves -> accounts pays.
        $run = PayrollRun::where('status', 'draft')->first();
        $this->post(route('portal.accounts.payroll.paid', $run))->assertStatus(405);
        $approve = $this->as('director')->patch(route('portal.director.payroll.approve', $run));
        $this->assertSame(302, $approve->status(), (string) $approve->exception?->getMessage());
        $this->as('accounts')->patch(route('portal.accounts.payroll.paid', $run))->assertRedirect();
        $this->assertSame('paid', $run->fresh()->status);
    }

    public function test_admission_from_application_creates_student_login(): void
    {
        $application = courseapplication::create([
            'name' => 'Jane Applicant', 'email' => 'jane@example.com', 'location' => 'Thika', 'phoneNumber' => '0700000001',
            'course_id' => Unit::first()->course_id, 'campus_id' => \App\Models\Campus::first()->id,
            'startMonth' => 'January', 'startYear' => (string) now()->year, 'modeOfLearning' => 'Full time',
        ]);

        $this->as('admin')->get(route('portal.admin.students.create', ['application' => $application->id]))->assertOk()->assertSee('Jane');

        $this->post(route('portal.admin.students.store'), [
            'application_id' => $application->id, 'first_name' => 'Jane', 'last_name' => 'Applicant', 'email' => 'jane@example.com',
            'course_id' => $application->course_id, 'mode_of_study' => 'Full time', 'current_term' => 1,
            'admission_date' => today()->toDateString(), 'status' => 'active', 'create_account' => 1,
        ])->assertRedirect(route('portal.admin.students.index'));

        $student = Student::where('email', 'jane@example.com')->latest('id')->first();
        $this->assertNotNull($student->user);
        $this->assertSame(User::STUDENT, $student->user->role);
        $this->assertSame($student->id, $application->fresh()->student_id);
    }

    public function test_staff_form_workflows(): void
    {
        $trainer = User::where('username', 'trainer')->first();
        $unit = Unit::where('trainer_id', $trainer->id)->where('term_no', 1)->first();
        $students = $unit->students()->pluck('id');

        // Trainer: attendance register, new assessment, marks, publish.
        $this->as('trainer')->post(route('portal.trainer.units.attendance.store', $unit), [
            'date' => today()->toDateString(),
            'status' => $students->mapWithKeys(fn ($id) => [$id => 'present'])->all(),
        ])->assertRedirect();
        $this->assertSame($students->count(), \App\Models\Attendance::where('unit_id', $unit->id)->whereDate('date', today())->count());

        $this->post(route('portal.trainer.units.assessments.store', $unit), ['title' => 'CAT 2', 'type' => 'cat', 'max_score' => 20, 'weight' => 20])->assertRedirect();
        $assessment = Assessment::where('title', 'CAT 2')->firstOrFail();
        $this->put(route('portal.trainer.units.assessments.marks', $assessment), [
            'scores' => $students->mapWithKeys(fn ($id) => [$id => 15])->all(), 'publish' => 1,
        ])->assertRedirect();
        $this->assertTrue($assessment->fresh()->published);
        $this->assertSame($students->count(), $assessment->results()->count());

        // Employee self-service leave -> HR decision.
        $this->post(route('portal.my.leave.store'), [
            'leave_type_id' => \App\Models\LeaveType::where('name', 'Annual Leave')->value('id'),
            'start_date' => today()->addWeek()->startOfWeek()->toDateString(),
            'end_date' => today()->addWeek()->startOfWeek()->addDays(2)->toDateString(),
        ])->assertSessionHasNoErrors();
        $leave = \App\Models\LeaveRequest::latest('id')->first();
        $this->assertSame(3, $leave->days);
        $this->as('hr')->patch(route('portal.hr.leave.decide', $leave), ['decision' => 'approved'])->assertRedirect();
        $this->assertSame('approved', $leave->fresh()->status);

        // HR: new employee with a portal login, then a payroll run for next month.
        $this->post(route('portal.hr.employees.store'), [
            'first_name' => 'New', 'last_name' => 'Trainer', 'designation' => 'Trainer', 'employment_type' => 'contract',
            'date_hired' => today()->toDateString(), 'basic_salary' => 40000, 'status' => 'active', 'portal_role' => User::TRAINER,
        ])->assertRedirect();
        $this->assertNotNull(Employee::where('first_name', 'New')->first()->user);
        $this->post(route('portal.hr.payroll.store'), ['period' => now()->addMonth()->format('Y-m')])->assertRedirect();
        $this->assertTrue(PayrollRun::where('period', now()->addMonth()->format('Y-m'))->first()->payslips()->exists());

        // Admin: unit and timetable.
        $this->as('admin')->post(route('portal.admin.units.store'), [
            'course_id' => $unit->course_id, 'code' => 'TEST/001', 'name' => 'Test Unit', 'term_no' => 1, 'learning_outcomes' => "One\nTwo",
        ])->assertRedirect();
        $newUnit = Unit::where('code', 'TEST/001')->firstOrFail();
        $this->assertSame(['One', 'Two'], $newUnit->outcomes);
        $this->post(route('portal.admin.timetable.store'), ['unit_id' => $newUnit->id, 'day_of_week' => 6, 'start_time' => '08:00', 'end_time' => '10:00', 'venue' => 'Hall'])
            ->assertSessionHas('success');

        // Accounts: bulk billing is idempotent; expense goes to the director.
        $bulk = ['course_id' => $unit->course_id, 'term_no' => 1, 'academic_term_id' => \App\Models\AcademicTerm::current()->id, 'invoice_date' => today()->toDateString()];
        $this->as('accounts')->post(route('portal.accounts.invoices.bulk'), $bulk)->assertRedirect();
        $count = \App\Models\Invoice::count();
        $this->post(route('portal.accounts.invoices.bulk'), $bulk)->assertRedirect();
        $this->assertSame($count, \App\Models\Invoice::count());

        $this->post(route('portal.accounts.expenses.store'), [
            'expense_category_id' => \App\Models\ExpenseCategory::first()->id, 'description' => 'Test expense', 'amount' => 999,
            'expense_date' => today()->toDateString(), 'method' => 'cash',
        ])->assertRedirect();
        $expense = \App\Models\Expense::where('description', 'Test expense')->first();
        $this->as('director')->patch(route('portal.director.expenses.decide', $expense), ['decision' => 'approved'])->assertRedirect();
        $this->assertSame('approved', $expense->fresh()->status);
    }

    public function test_kenya_payroll_deductions(): void
    {
        $d = \App\Support\KenyaPayroll::calculate(100000);
        $this->assertEquals(4320, $d['nssf']);        // 6% of 72,000 cap
        $this->assertEquals(2750, $d['shif']);        // 2.75%
        $this->assertEquals(1500, $d['housing_levy']); // 1.5%
        // Taxable 91,430: 2,400 + 2,083.25 + 17,729.10 = 22,212.35, less 2,400 relief.
        $this->assertEquals(19812.35, $d['paye']);
    }
}
