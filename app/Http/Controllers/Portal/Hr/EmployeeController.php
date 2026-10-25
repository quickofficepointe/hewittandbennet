<?php

namespace App\Http\Controllers\Portal\Hr;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\department;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\User;
use App\Support\AccountIssuer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /** Roles HR may grant when issuing an employee portal login. */
    private const STAFF_ROLES = [User::TRAINER, User::ADMIN, User::HR, User::ACCOUNTANT];

    public function index(Request $request)
    {
        $employees = Employee::with('department', 'user')
            ->when($request->filled('department_id'), fn ($q) => $q->where('department_id', $request->department_id))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($q) => $q
                ->where('first_name', 'like', "%{$request->q}%")
                ->orWhere('last_name', 'like', "%{$request->q}%")
                ->orWhere('employee_no', 'like', "%{$request->q}%")
                ->orWhere('designation', 'like', "%{$request->q}%")))
            ->orderBy('first_name')
            ->paginate(25)->withQueryString();

        return view('portal.hr.employees.index', [
            'employees' => $employees,
            'departments' => department::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function create()
    {
        return view('portal.hr.employees.form', $this->formData(new Employee([
            'date_hired' => today(),
            'employment_type' => 'permanent',
            'status' => 'active',
        ])));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['employee_no'] = ($data['employee_no'] ?? null) ?: Employee::nextEmployeeNo();
        $employee = Employee::create(Arr::except($data, ['portal_role']));

        $message = "Employee {$employee->full_name} added as {$employee->employee_no}.";
        if ($request->filled('portal_role')) {
            $message .= ' '.$this->issueAccount($employee, (int) $request->portal_role);
        }

        return redirect()->route('portal.hr.employees.show', $employee)->with('success', $message);
    }

    public function show(Employee $employee)
    {
        $employee->load('department', 'campus', 'user', 'leaveRequests.type');
        $payslips = $employee->payslips()->with('run')->latest()->take(12)->get();
        $balances = LeaveType::orderBy('name')->get()->map(fn ($type) => [
            'type' => $type,
            'taken' => $taken = $employee->leaveDaysTaken($type->id),
            'remaining' => max(0, $type->days_per_year - $taken),
        ]);

        return view('portal.hr.employees.show', compact('employee', 'payslips', 'balances'));
    }

    public function edit(Employee $employee)
    {
        return view('portal.hr.employees.form', $this->formData($employee));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = Arr::except($this->validated($request, $employee), ['portal_role']);
        $data['employee_no'] = ($data['employee_no'] ?? null) ?: $employee->employee_no;
        $employee->update($data);

        $employee->user?->update([
            'name' => $employee->full_name,
            'is_active' => $employee->status !== 'exited',
        ]);

        return redirect()->route('portal.hr.employees.show', $employee)->with('success', 'Employee record updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->update(['status' => 'exited']);
        $employee->user?->update(['is_active' => false]);
        $employee->delete();

        return redirect()->route('portal.hr.employees.index')->with('success', 'Employee archived and portal access disabled.');
    }

    public function createAccount(Request $request, Employee $employee)
    {
        abort_if($employee->user_id, 422, 'This employee already has a portal account.');
        $request->validate(['portal_role' => ['required', Rule::in(self::STAFF_ROLES)]]);

        return back()->with('success', $this->issueAccount($employee, (int) $request->portal_role));
    }

    private function issueAccount(Employee $employee, int $role): string
    {
        abort_unless(in_array($role, self::STAFF_ROLES, true), 422);

        $email = $employee->email && ! User::where('email', $employee->email)->exists() ? $employee->email : null;
        [$user, $password] = AccountIssuer::issue($employee->full_name, $email, $employee->employee_no, $role, $employee->phone);
        $employee->update(['user_id' => $user->id]);

        return AccountIssuer::message($user, $password);
    }

    private function formData(Employee $employee): array
    {
        return [
            'employee' => $employee,
            'departments' => department::orderBy('name')->pluck('name', 'id'),
            'campuses' => Campus::orderBy('name')->pluck('name', 'id'),
            'roles' => Arr::only(User::ROLE_LABELS, self::STAFF_ROLES),
        ];
    }

    private function validated(Request $request, ?Employee $employee = null): array
    {
        $data = $request->validate([
            'employee_no' => ['nullable', 'string', 'max:50', Rule::unique('employees')->ignore($employee?->id)],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'id_number' => 'nullable|string|max:30',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date|before:today',
            'department_id' => 'nullable|exists:departments,id',
            'campus_id' => 'nullable|exists:campuses,id',
            'designation' => 'required|string|max:150',
            'employment_type' => ['required', Rule::in(array_keys(Employee::TYPES))],
            'date_hired' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
            'house_allowance' => 'nullable|numeric|min:0',
            'other_allowances' => 'nullable|numeric|min:0',
            'kra_pin' => 'nullable|string|max:20',
            'nssf_no' => 'nullable|string|max:30',
            'shif_no' => 'nullable|string|max:30',
            'bank_name' => 'nullable|string|max:100',
            'bank_account' => 'nullable|string|max:50',
            'next_of_kin' => 'nullable|string|max:150',
            'next_of_kin_phone' => 'nullable|string|max:30',
            'status' => ['required', Rule::in(Employee::STATUSES)],
            'portal_role' => ['nullable', Rule::in(self::STAFF_ROLES)],
        ]);
        $data['house_allowance'] = $data['house_allowance'] ?? 0;
        $data['other_allowances'] = $data['other_allowances'] ?? 0;

        return $data;
    }
}
