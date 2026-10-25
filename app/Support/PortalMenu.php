<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Route;

/**
 * Sidebar navigation for each portal role.
 * Each item: [label, route name, Font Awesome icon, route pattern used to highlight it].
 */
class PortalMenu
{
    public static function for(User $user): array
    {
        $sections = match ($user->role) {
            User::DIRECTOR => self::director(),
            User::ADMIN => self::admin(),
            User::TRAINER => self::trainer(),
            User::STUDENT => self::student(),
            User::HR => self::hr(),
            User::ACCOUNTANT => self::accountant(),
            default => [],
        };

        if ($user->isStaff()) {
            $sections['My HR'] = [
                ['Apply for Leave', 'portal.my.leave', 'fa-umbrella-beach', 'portal.my.leave*'],
                ['My Payslips', 'portal.my.payslips', 'fa-file-invoice-dollar', 'portal.my.payslips*'],
            ];
        }

        $sections['Account'] = [
            ['Announcements', 'portal.announcements.index', 'fa-bullhorn', 'portal.announcements.*'],
            ['My Profile', 'portal.profile.edit', 'fa-user-gear', 'portal.profile.*'],
        ];

        // Drop any item whose route is not registered so the menu never renders a broken link.
        return array_filter(array_map(
            fn ($items) => array_values(array_filter($items, fn ($item) => Route::has($item[1]))),
            $sections
        ));
    }

    private static function director(): array
    {
        return [
            'Overview' => [
                ['Executive Dashboard', 'portal.director.dashboard', 'fa-chart-pie', 'portal.director.dashboard'],
                ['Academic Report', 'portal.director.reports.academic', 'fa-graduation-cap', 'portal.director.reports.academic'],
                ['Finance Report', 'portal.director.reports.finance', 'fa-sack-dollar', 'portal.director.reports.finance'],
                ['HR Report', 'portal.director.reports.hr', 'fa-people-group', 'portal.director.reports.hr'],
            ],
            'Approvals' => [
                ['Expense Approvals', 'portal.director.expenses', 'fa-file-signature', 'portal.director.expenses*'],
                ['Payroll Approvals', 'portal.director.payroll', 'fa-money-check-dollar', 'portal.director.payroll*'],
            ],
            'Modules' => [
                ['Administration', 'portal.admin.dashboard', 'fa-building-columns', 'portal.admin.dashboard'],
                ['Students', 'portal.admin.students.index', 'fa-user-graduate', 'portal.admin.students.*'],
                ['Human Resource', 'portal.hr.dashboard', 'fa-id-badge', 'portal.hr.*'],
                ['Accounts', 'portal.accounts.dashboard', 'fa-calculator', 'portal.accounts.*'],
                ['User Accounts', 'portal.admin.users.index', 'fa-users-gear', 'portal.admin.users.*'],
            ],
        ];
    }

    private static function admin(): array
    {
        return [
            'Overview' => [
                ['Dashboard', 'portal.admin.dashboard', 'fa-gauge-high', 'portal.admin.dashboard'],
            ],
            'Admissions' => [
                ['Online Applications', 'portal.admin.applications.index', 'fa-inbox', 'portal.admin.applications.*'],
                ['Registration Forms', 'registrationforms.index', 'fa-file-lines', 'registrationforms.*'],
                ['Students', 'portal.admin.students.index', 'fa-user-graduate', 'portal.admin.students.*'],
            ],
            'Academics' => [
                ['Departments', 'index.departments', 'fa-sitemap', 'index.departments'],
                ['Courses', 'index.cdpert', 'fa-book', 'index.cdpert'],
                ['Units / Modules', 'portal.admin.units.index', 'fa-layer-group', 'portal.admin.units.*'],
                ['Timetable', 'portal.admin.timetable.index', 'fa-calendar-days', 'portal.admin.timetable.*'],
                ['Terms & Intakes', 'portal.admin.setup.index', 'fa-calendar-check', 'portal.admin.setup.*'],
                ['Results Overview', 'portal.admin.results.index', 'fa-square-poll-vertical', 'portal.admin.results.*'],
            ],
            'Administration' => [
                ['User Accounts', 'portal.admin.users.index', 'fa-users-gear', 'portal.admin.users.*'],
            ],
            'Website' => [
                ['Banners', 'hewitt_banners.index', 'fa-images', 'hewitt_banners.*'],
                ['News & Events', 'newsandevent.index', 'fa-newspaper', 'newsandevent.index'],
                ['Gallery', 'gallery.index', 'fa-photo-film', 'gallery.index'],
                ['Campuses', 'campuses.index', 'fa-school', 'campuses.*'],
                ['Team', 'teams.index', 'fa-people-roof', 'teams.*'],
                ['Testimonials', 'testimonials.index', 'fa-comment-dots', 'testimonials.index'],
                ['Reviews', 'index.review', 'fa-star', 'index.review'],
                ['Partners', 'partners.show', 'fa-handshake', 'partners.show'],
                ['TikTok Videos', 'tiktok-videos.index', 'fa-video', 'tiktok-videos.*'],
                ['Attachment Requests', 'portal.admin.attachments.index', 'fa-paperclip', 'portal.admin.attachments.*'],
                ['Contact Messages', 'portal.admin.contact-messages.index', 'fa-envelope', 'portal.admin.contact-messages.*'],
            ],
        ];
    }

    private static function trainer(): array
    {
        return [
            'Teaching' => [
                ['Dashboard', 'portal.trainer.dashboard', 'fa-gauge-high', 'portal.trainer.dashboard'],
                ['My Units', 'portal.trainer.units.index', 'fa-layer-group', 'portal.trainer.units.*'],
                ['Timetable', 'portal.trainer.timetable', 'fa-calendar-days', 'portal.trainer.timetable'],
                ['Online Exams', 'portal.trainer.exams.index', 'fa-laptop-file', 'portal.trainer.exams.*'],
            ],
        ];
    }

    private static function student(): array
    {
        return [
            'My Studies' => [
                ['Dashboard', 'portal.student.dashboard', 'fa-gauge-high', 'portal.student.dashboard'],
                ['My Units', 'portal.student.units', 'fa-layer-group', 'portal.student.units*'],
                ['Timetable', 'portal.student.timetable', 'fa-calendar-days', 'portal.student.timetable'],
                ['Attendance', 'portal.student.attendance', 'fa-clipboard-user', 'portal.student.attendance'],
                ['Results & Transcript', 'portal.student.results', 'fa-award', 'portal.student.results*'],
                ['Online Exams', 'portal.student.exams.index', 'fa-laptop-file', 'portal.student.exams.*'],
            ],
            'Finance' => [
                ['Fee Statement', 'portal.student.fees', 'fa-receipt', 'portal.student.fees*'],
            ],
        ];
    }

    private static function hr(): array
    {
        return [
            'Human Resource' => [
                ['Dashboard', 'portal.hr.dashboard', 'fa-gauge-high', 'portal.hr.dashboard'],
                ['Employees', 'portal.hr.employees.index', 'fa-id-badge', 'portal.hr.employees.*'],
                ['Leave Requests', 'portal.hr.leave.index', 'fa-plane-departure', 'portal.hr.leave.*'],
                ['Leave Types', 'portal.hr.leave-types.index', 'fa-list-check', 'portal.hr.leave-types.*'],
                ['Payroll', 'portal.hr.payroll.index', 'fa-money-check-dollar', 'portal.hr.payroll.*'],
            ],
            'Recruitment' => [
                ['Vacancies', 'portal.hr.vacancies.index', 'fa-briefcase', 'portal.hr.vacancies.*'],
                ['Job Applications', 'portal.hr.applications.index', 'fa-file-import', 'portal.hr.applications.*'],
            ],
        ];
    }

    private static function accountant(): array
    {
        return [
            'Accounts' => [
                ['Dashboard', 'portal.accounts.dashboard', 'fa-gauge-high', 'portal.accounts.dashboard'],
                ['Receive Payment', 'portal.accounts.payments.create', 'fa-cash-register', 'portal.accounts.payments.create'],
                ['Payments & Receipts', 'portal.accounts.payments.index', 'fa-receipt', 'portal.accounts.payments.index'],
                ['Invoices & Billing', 'portal.accounts.invoices.index', 'fa-file-invoice', 'portal.accounts.invoices.*'],
                ['Student Balances', 'portal.accounts.balances', 'fa-scale-unbalanced', 'portal.accounts.balances*'],
                ['Fee Structures', 'portal.accounts.fees.index', 'fa-table-list', 'portal.accounts.fees.*'],
            ],
            'Expenditure' => [
                ['Expenses', 'portal.accounts.expenses.index', 'fa-money-bill-transfer', 'portal.accounts.expenses.*'],
                ['Payroll', 'portal.accounts.payroll.index', 'fa-money-check-dollar', 'portal.accounts.payroll.*'],
                ['Financial Reports', 'portal.accounts.reports', 'fa-chart-line', 'portal.accounts.reports'],
            ],
        ];
    }
}
