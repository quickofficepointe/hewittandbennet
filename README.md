# Hewitt and Bennet International College – Website & College Management System

Laravel 10 application with two parts:

- **Public website** (`/`): courses, admissions, news, gallery, careers, fees structure.
- **Public website details** (phones, email, WhatsApp, campuses, social links, homepage stats) live in `config/college.php`; social links come from `SOCIAL_*` in `.env`. Contact-form messages appear in the portal under Website → Contact Messages. Static website images are web-optimised WebP files in `public/images/`.
- **College Management System portal** (`/portal`): one login page, one layout, and a menu that changes with the user's role.

## Roles and modules

| Role | Code | What they do |
|---|---|---|
| Director | 0 | Executive dashboard (enrolment, collections, outstanding fees, attendance, staff), academic/finance/HR reports, **approves expenses and payroll**, and can open every Admin, HR and Accounts page. |
| Administrator / Registrar | 1 | Online applications → **admit students** (auto admission no. + portal login), student records, units/modules with learning outcomes, timetable (clash detection), terms & intakes, end-of-term promotion, results broadsheets, user accounts, announcements, website content (banners, news, gallery, campuses, team, testimonials, reviews, partners, TikTok). |
| Trainer | 3 | My units, class lists, **attendance register**, CBET assessments (CATs, practicals, exams) with weighted marks and publishing, learning materials, auto-marked online exams, timetable. |
| Student | 2 | Dashboard, units & learning outcomes, materials, timetable, attendance %, results & printable provisional transcript, fee statement & receipts, online exams. |
| HR Officer | 4 | Employees (salary & statutory details), portal logins for staff, leave types and leave approvals, **monthly payroll** (PAYE, NSSF, SHIF, Housing Levy), payslips, job vacancies (shown on `/jobs`) and applications. |
| Accountant | 5 | Receive payments (cash, M-Pesa, bank, cheque, card; duplicate reference check), printable receipts, single and class-wide invoicing from fee structures, balances/defaulters, statements, expenses, paying approved payroll, income & expenditure reports. |

All staff also get **My HR**: apply for leave and download their payslips.

### Key workflows

- **Admission:** website application → Admin "Admit" → student record + login (username = admission number, temporary password shown once).
- **Billing:** Accounts sets fee structure per course/term → "Bill a whole class" (safe to repeat; already-billed items are skipped) → payments → statement/receipts visible to the student.
- **Payroll:** HR generates a draft for the month → Director approves → Accountant marks it paid → staff see payslips.
- **Expenses:** Accountant records → Director approves/rejects → approved expenses count in reports.
- **Grading:** final unit mark = weighted average of *published* assessments. Distinction ≥ 80, Credit ≥ 65, Pass ≥ 50 (Competent), otherwise Not Yet Competent.

Statutory payroll rates live in `app/Support/KenyaPayroll.php`. Review them whenever KRA, NSSF or SHA change rates.

## Local setup

```bash
composer install
cp .env.example .env && php artisan key:generate   # set DB_* for MySQL
php artisan migrate:fresh --seed                   # schema + website content + demo data (local only)
php artisan storage:link
php artisan serve
```

Demo logins (local only, password `password`): `director` (password `ChangeMe@2026`), `admin`, `hr`, `accounts`, `trainer`, `trainer2`–`trainer4`, and the student `HBIC/<year>/0001`. Users can sign in with either their username or their email address.

Run the tests (uses a MySQL database called `hbic_testing`):

```bash
php artisan test
```

## Deploying to production

1. Back up the production database.
2. `composer install --no-dev --optimize-autoloader`
3. **Existing live database:** run `php artisan migrate --force`, then `php artisan db:seed --class=SetupSeeder --force` (it keeps an existing `director` login). The `2026_10_23_000000_upgrade_legacy_schema` migration recreates missing website tables, renames the old portal tables that clash (`students`, `units`, `online_exams`) to `legacy_*` with their data kept, and adds the new user columns. Contact-form messages reuse the existing `contacts` table. Old student and receipt records stay in the `legacy_*`/old tables until they are imported into the new `students`/`payments` tables. **New database:** `php artisan migrate --force && php artisan db:seed --class=SetupSeeder --force`. `SetupSeeder` creates the `director` login (set `DIRECTOR_PASSWORD` in `.env` first) plus leave types, expense categories, terms and intakes. Demo data is never seeded outside `local`/`testing`.
4. `php artisan optimize:clear && php artisan optimize` (an old route cache hides the new portal routes).
5. `php artisan storage:link`
6. Sign in as `director`, change the password, then create the Admin, HR and Accountant accounts.
