<?php

namespace App\Http\Controllers\Portal\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\courseapplication;
use App\Models\courses;
use App\Models\Intake;
use App\Models\Student;
use App\Models\User;
use App\Support\AccountIssuer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::with('course', 'intake', 'campus')
            ->when($request->filled('course_id'), fn ($q) => $q->where('course_id', $request->course_id))
            ->when($request->filled('intake_id'), fn ($q) => $q->where('intake_id', $request->intake_id))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($q) => $q
                ->where('admission_no', 'like', "%{$request->q}%")
                ->orWhere('first_name', 'like', "%{$request->q}%")
                ->orWhere('last_name', 'like', "%{$request->q}%")
                ->orWhere('phone', 'like', "%{$request->q}%")
                ->orWhere('id_number', 'like', "%{$request->q}%")))
            ->latest()
            ->paginate(25)->withQueryString();

        return view('portal.admin.students.index', [
            'students' => $students,
            'courses' => courses::orderBy('name')->pluck('name', 'id'),
            'intakes' => Intake::orderByDesc('start_date')->pluck('name', 'id'),
        ]);
    }

    public function create(Request $request)
    {
        $student = new Student([
            'admission_date' => today(),
            'current_term' => 1,
            'status' => 'active',
            'mode_of_study' => 'Full time',
            'intake_id' => Intake::where('is_open', true)->orderBy('start_date')->value('id'),
        ]);

        // Admitting an online applicant pre-fills the form from their application.
        $application = $request->filled('application') ? courseapplication::findOrFail($request->application) : null;
        if ($application) {
            [$first, $last] = array_pad(explode(' ', trim($application->name), 2), 2, '');
            $student->fill([
                'first_name' => $first,
                'last_name' => $last,
                'email' => $application->email,
                'phone' => $application->phoneNumber,
                'address' => $application->location,
                'course_id' => $application->course_id,
                'campus_id' => $application->campus_id,
                'mode_of_study' => $application->modeOfLearning ?: 'Full time',
            ]);
        }

        return view('portal.admin.students.form', $this->formData($student) + ['application' => $application]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $message = DB::transaction(function () use ($request, $data) {
            $data['admission_no'] = ($data['admission_no'] ?? null) ?: Student::nextAdmissionNo();
            $student = Student::create($data);

            if ($request->filled('application_id')) {
                courseapplication::whereKey($request->application_id)->update(['student_id' => $student->id, 'status' => 'admitted']);
            }

            $message = "Student {$student->full_name} admitted as {$student->admission_no}.";
            if ($request->boolean('create_account')) {
                $message .= ' '.$this->issueAccount($student);
            }

            return $message;
        });

        return redirect()->route('portal.admin.students.index')->with('success', $message);
    }

    public function show(Student $student)
    {
        $student->load('course.department', 'intake', 'campus', 'user', 'invoices', 'payments');
        $units = $student->units()->with('trainer')->get();
        $marks = $units->mapWithKeys(fn ($unit) => [$unit->id => $unit->finalMarkFor($student)]);
        $attendance = $student->attendances()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('portal.admin.students.show', compact('student', 'units', 'marks', 'attendance'));
    }

    public function edit(Student $student)
    {
        return view('portal.admin.students.form', $this->formData($student) + ['application' => null]);
    }

    public function update(Request $request, Student $student)
    {
        $data = $this->validated($request, $student);
        $data['admission_no'] = ($data['admission_no'] ?? null) ?: $student->admission_no;
        $student->update($data);

        $student->user?->update([
            'name' => $student->full_name,
            'is_active' => in_array($student->status, ['active', 'deferred'], true),
        ]);

        return redirect()->route('portal.admin.students.show', $student)->with('success', 'Student record updated.');
    }

    public function destroy(Student $student)
    {
        $student->user?->update(['is_active' => false]);
        $student->delete();

        return redirect()->route('portal.admin.students.index')->with('success', 'Student archived and portal access disabled.');
    }

    public function createAccount(Student $student)
    {
        abort_if($student->user_id, 422, 'This student already has a portal account.');

        return back()->with('success', $this->issueAccount($student));
    }

    private function issueAccount(Student $student): string
    {
        $email = $student->email && ! User::where('email', $student->email)->exists() ? $student->email : null;
        [$user, $password] = AccountIssuer::issue($student->full_name, $email, $student->admission_no, User::STUDENT, $student->phone);
        $student->update(['user_id' => $user->id]);

        return AccountIssuer::message($user, $password);
    }

    private function formData(Student $student): array
    {
        return [
            'student' => $student,
            'courses' => courses::orderBy('name')->pluck('name', 'id'),
            'intakes' => Intake::orderByDesc('start_date')->pluck('name', 'id'),
            'campuses' => Campus::orderBy('name')->pluck('name', 'id'),
        ];
    }

    private function validated(Request $request, ?Student $student = null): array
    {
        $data = $request->validate([
            'admission_no' => ['nullable', 'string', 'max:50', Rule::unique('students')->ignore($student?->id)],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'id_number' => 'nullable|string|max:30',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:30',
            'guardian_relationship' => 'nullable|string|max:50',
            'course_id' => 'required|exists:courses,id',
            'intake_id' => 'nullable|exists:intakes,id',
            'campus_id' => 'nullable|exists:campuses,id',
            'mode_of_study' => 'required|string|max:50',
            'current_term' => 'required|integer|min:1|max:12',
            'admission_date' => 'required|date',
            'status' => ['required', Rule::in(Student::STATUSES)],
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($student?->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        return $data;
    }
}
