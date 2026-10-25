<?php

use App\Http\Controllers\Portal\Accounts;
use App\Http\Controllers\Portal\Admin;
use App\Http\Controllers\Portal\AnnouncementController;
use App\Http\Controllers\Portal\DashboardController;
use App\Http\Controllers\Portal\Director;
use App\Http\Controllers\Portal\Hr;
use App\Http\Controllers\Portal\MyHrController;
use App\Http\Controllers\Portal\PayslipController;
use App\Http\Controllers\Portal\ProfileController;
use App\Http\Controllers\Portal\Student;
use App\Http\Controllers\Portal\Trainer;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| College Management System portal
|--------------------------------------------------------------------------
| Roles: director, admin, trainer, student, hr, accountant (see App\Models\User).
| Directors can also open the admin, hr and accountant modules (RoleMiddleware).
*/

Route::prefix('portal')->name('portal.')->middleware(['auth', 'role', 'PreventBackHistory'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');

    Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::middleware('role:admin,director')->group(function () {
        Route::post('announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::delete('announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });

    // Self-service for every employee (leave + payslips).
    Route::middleware('role:director,admin,trainer,hr,accountant')->prefix('my')->name('my.')->group(function () {
        Route::get('leave', [MyHrController::class, 'leave'])->name('leave');
        Route::post('leave', [MyHrController::class, 'applyLeave'])->name('leave.store');
        Route::patch('leave/{leaveRequest}/cancel', [MyHrController::class, 'cancelLeave'])->name('leave.cancel');
        Route::get('payslips', [MyHrController::class, 'payslips'])->name('payslips');
    });
    Route::get('payslips/{payslip}', [PayslipController::class, 'show'])
        ->middleware('role:director,admin,trainer,hr,accountant')->name('payslips.show');

    /* ---------------- Director ---------------- */
    Route::middleware('role:director')->prefix('director')->name('director.')->group(function () {
        Route::get('dashboard', [Director\DashboardController::class, 'index'])->name('dashboard');
        Route::get('reports/academic', [Director\ReportController::class, 'academic'])->name('reports.academic');
        Route::get('reports/finance', [Director\ReportController::class, 'finance'])->name('reports.finance');
        Route::get('reports/hr', [Director\ReportController::class, 'hr'])->name('reports.hr');
        Route::get('approvals/expenses', [Director\ApprovalController::class, 'expenses'])->name('expenses');
        Route::patch('approvals/expenses/{expense}', [Director\ApprovalController::class, 'decideExpense'])->name('expenses.decide');
        Route::get('approvals/payroll', [Director\ApprovalController::class, 'payroll'])->name('payroll');
        Route::patch('approvals/payroll/{payrollRun}', [Director\ApprovalController::class, 'approvePayroll'])->name('payroll.approve');
    });

    /* ---------------- Administrator ---------------- */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', Admin\UserController::class)->except('show');
        Route::patch('users/{user}/toggle', [Admin\UserController::class, 'toggle'])->name('users.toggle');

        Route::resource('students', Admin\StudentController::class);
        Route::post('students/{student}/account', [Admin\StudentController::class, 'createAccount'])->name('students.account');

        Route::get('applications', [Admin\ApplicationController::class, 'index'])->name('applications.index');
        Route::patch('applications/{application}', [Admin\ApplicationController::class, 'update'])->name('applications.update');

        Route::resource('units', Admin\UnitController::class)->except('show');

        Route::get('timetable', [Admin\TimetableController::class, 'index'])->name('timetable.index');
        Route::post('timetable', [Admin\TimetableController::class, 'store'])->name('timetable.store');
        Route::delete('timetable/{entry}', [Admin\TimetableController::class, 'destroy'])->name('timetable.destroy');

        Route::get('setup', [Admin\SetupController::class, 'index'])->name('setup.index');
        Route::post('setup/terms', [Admin\SetupController::class, 'storeTerm'])->name('setup.terms.store');
        Route::patch('setup/terms/{term}/current', [Admin\SetupController::class, 'makeCurrent'])->name('setup.terms.current');
        Route::delete('setup/terms/{term}', [Admin\SetupController::class, 'destroyTerm'])->name('setup.terms.destroy');
        Route::post('setup/intakes', [Admin\SetupController::class, 'storeIntake'])->name('setup.intakes.store');
        Route::patch('setup/intakes/{intake}/toggle', [Admin\SetupController::class, 'toggleIntake'])->name('setup.intakes.toggle');
        Route::delete('setup/intakes/{intake}', [Admin\SetupController::class, 'destroyIntake'])->name('setup.intakes.destroy');
        Route::post('setup/promote', [Admin\SetupController::class, 'promote'])->name('setup.promote');

        Route::get('results', [Admin\ResultController::class, 'index'])->name('results.index');
        Route::get('results/{unit}', [Admin\ResultController::class, 'show'])->name('results.show');

        Route::get('attachments', [Admin\AttachmentRequestController::class, 'index'])->name('attachments.index');
        Route::get('attachments/{attachment}/document', [Admin\AttachmentRequestController::class, 'document'])->name('attachments.document');

        Route::get('contact-messages', [Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::patch('contact-messages/{message}', [Admin\ContactMessageController::class, 'markRead'])->name('contact-messages.read');
        Route::delete('contact-messages/{message}', [Admin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    });

    /* ---------------- Trainer ---------------- */
    Route::middleware('role:trainer')->prefix('trainer')->name('trainer.')->group(function () {
        Route::get('dashboard', [Trainer\DashboardController::class, 'index'])->name('dashboard');
        Route::get('timetable', [Trainer\DashboardController::class, 'timetable'])->name('timetable');

        Route::get('units', [Trainer\UnitController::class, 'index'])->name('units.index');
        Route::get('units/{unit}', [Trainer\UnitController::class, 'show'])->name('units.show');

        Route::get('units/{unit}/attendance', [Trainer\AttendanceController::class, 'edit'])->name('units.attendance');
        Route::post('units/{unit}/attendance', [Trainer\AttendanceController::class, 'store'])->name('units.attendance.store');

        Route::post('units/{unit}/assessments', [Trainer\AssessmentController::class, 'store'])->name('units.assessments.store');
        Route::get('assessments/{assessment}', [Trainer\AssessmentController::class, 'show'])->name('units.assessments.show');
        Route::put('assessments/{assessment}/marks', [Trainer\AssessmentController::class, 'marks'])->name('units.assessments.marks');
        Route::patch('assessments/{assessment}/publish', [Trainer\AssessmentController::class, 'publish'])->name('units.assessments.publish');
        Route::delete('assessments/{assessment}', [Trainer\AssessmentController::class, 'destroy'])->name('units.assessments.destroy');

        Route::post('units/{unit}/materials', [Trainer\MaterialController::class, 'store'])->name('units.materials.store');
        Route::delete('materials/{material}', [Trainer\MaterialController::class, 'destroy'])->name('units.materials.destroy');

        Route::get('exams', [Trainer\ExamController::class, 'index'])->name('exams.index');
        Route::post('exams', [Trainer\ExamController::class, 'store'])->name('exams.store');
        Route::get('exams/{exam}', [Trainer\ExamController::class, 'show'])->name('exams.show');
        Route::patch('exams/{exam}/publish', [Trainer\ExamController::class, 'publish'])->name('exams.publish');
        Route::delete('exams/{exam}', [Trainer\ExamController::class, 'destroy'])->name('exams.destroy');
        Route::post('exams/{exam}/questions', [Trainer\ExamController::class, 'storeQuestion'])->name('exams.questions.store');
        Route::delete('questions/{question}', [Trainer\ExamController::class, 'destroyQuestion'])->name('exams.questions.destroy');
    });

    /* ---------------- Student ---------------- */
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('dashboard', [Student\DashboardController::class, 'index'])->name('dashboard');
        Route::get('units', [Student\StudyController::class, 'units'])->name('units');
        Route::get('units/{unit}', [Student\StudyController::class, 'unit'])->name('units.show');
        Route::get('timetable', [Student\StudyController::class, 'timetable'])->name('timetable');
        Route::get('attendance', [Student\StudyController::class, 'attendance'])->name('attendance');
        Route::get('results', [Student\StudyController::class, 'results'])->name('results');
        Route::get('results/transcript', [Student\StudyController::class, 'transcript'])->name('results.transcript');
        Route::get('fees', [Student\FeeController::class, 'index'])->name('fees');
        Route::get('fees/receipts/{payment}', [Student\FeeController::class, 'receipt'])->name('fees.receipt');

        Route::get('exams', [Student\ExamController::class, 'index'])->name('exams.index');
        Route::get('exams/{exam}', [Student\ExamController::class, 'take'])->name('exams.take');
        Route::post('exams/{exam}', [Student\ExamController::class, 'submit'])->name('exams.submit');
    });

    /* ---------------- Human Resource ---------------- */
    Route::middleware('role:hr')->prefix('hr')->name('hr.')->group(function () {
        Route::get('dashboard', [Hr\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('employees', Hr\EmployeeController::class);
        Route::post('employees/{employee}/account', [Hr\EmployeeController::class, 'createAccount'])->name('employees.account');

        Route::get('leave', [Hr\LeaveController::class, 'index'])->name('leave.index');
        Route::patch('leave/{leaveRequest}', [Hr\LeaveController::class, 'decide'])->name('leave.decide');
        Route::get('leave-types', [Hr\LeaveTypeController::class, 'index'])->name('leave-types.index');
        Route::post('leave-types', [Hr\LeaveTypeController::class, 'store'])->name('leave-types.store');
        Route::put('leave-types/{leaveType}', [Hr\LeaveTypeController::class, 'update'])->name('leave-types.update');
        Route::delete('leave-types/{leaveType}', [Hr\LeaveTypeController::class, 'destroy'])->name('leave-types.destroy');

        Route::get('payroll', [Hr\PayrollController::class, 'index'])->name('payroll.index');
        Route::post('payroll', [Hr\PayrollController::class, 'store'])->name('payroll.store');
        Route::get('payroll/{payrollRun}', [Hr\PayrollController::class, 'show'])->name('payroll.show');
        Route::put('payroll/{payrollRun}', [Hr\PayrollController::class, 'update'])->name('payroll.update');
        Route::delete('payroll/{payrollRun}', [Hr\PayrollController::class, 'destroy'])->name('payroll.destroy');

        Route::resource('vacancies', Hr\VacancyController::class)->except(['show', 'create', 'edit']);
        Route::get('applications', [Hr\JobApplicationController::class, 'index'])->name('applications.index');
        Route::patch('applications/{application}', [Hr\JobApplicationController::class, 'update'])->name('applications.update');
        Route::get('applications/{application}/cv', [Hr\JobApplicationController::class, 'cv'])->name('applications.cv');
    });

    /* ---------------- Accounts ---------------- */
    Route::middleware('role:accountant')->prefix('accounts')->name('accounts.')->group(function () {
        Route::get('dashboard', [Accounts\DashboardController::class, 'index'])->name('dashboard');

        Route::get('payments', [Accounts\PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/create', [Accounts\PaymentController::class, 'create'])->name('payments.create');
        Route::post('payments', [Accounts\PaymentController::class, 'store'])->name('payments.store');
        Route::get('payments/{payment}/receipt', [Accounts\PaymentController::class, 'receipt'])->name('payments.receipt');
        Route::delete('payments/{payment}', [Accounts\PaymentController::class, 'destroy'])->name('payments.destroy');

        Route::get('invoices', [Accounts\InvoiceController::class, 'index'])->name('invoices.index');
        Route::post('invoices', [Accounts\InvoiceController::class, 'store'])->name('invoices.store');
        Route::post('invoices/bulk', [Accounts\InvoiceController::class, 'bulk'])->name('invoices.bulk');
        Route::delete('invoices/{invoice}', [Accounts\InvoiceController::class, 'destroy'])->name('invoices.destroy');

        Route::get('balances', [Accounts\BalanceController::class, 'index'])->name('balances');
        Route::get('balances/{student}', [Accounts\BalanceController::class, 'statement'])->name('balances.statement');

        Route::get('fee-structures', [Accounts\FeeStructureController::class, 'index'])->name('fees.index');
        Route::post('fee-structures', [Accounts\FeeStructureController::class, 'store'])->name('fees.store');
        Route::delete('fee-structures/{item}', [Accounts\FeeStructureController::class, 'destroy'])->name('fees.destroy');

        Route::get('expenses', [Accounts\ExpenseController::class, 'index'])->name('expenses.index');
        Route::post('expenses', [Accounts\ExpenseController::class, 'store'])->name('expenses.store');
        Route::delete('expenses/{expense}', [Accounts\ExpenseController::class, 'destroy'])->name('expenses.destroy');
        Route::post('expense-categories', [Accounts\ExpenseController::class, 'storeCategory'])->name('expenses.categories.store');

        Route::get('payroll', [Accounts\PayrollController::class, 'index'])->name('payroll.index');
        Route::get('payroll/{payrollRun}', [Accounts\PayrollController::class, 'show'])->name('payroll.show');
        Route::patch('payroll/{payrollRun}/paid', [Accounts\PayrollController::class, 'markPaid'])->name('payroll.paid');

        Route::get('reports', [Accounts\ReportController::class, 'index'])->name('reports');
    });
});
