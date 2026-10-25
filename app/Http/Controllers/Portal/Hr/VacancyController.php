<?php

namespace App\Http\Controllers\Portal\Hr;

use App\Http\Controllers\Controller;
use App\Models\department;
use App\Models\Employee;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Job vacancies published on the website's careers page. */
class VacancyController extends Controller
{
    public function index()
    {
        return view('portal.hr.vacancies', [
            'vacancies' => JobVacancy::with('department')->withCount('applications')->latest()->get(),
            'departments' => department::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        JobVacancy::create($this->validated($request));

        return back()->with('success', 'Vacancy published on the careers page.');
    }

    public function update(Request $request, JobVacancy $vacancy)
    {
        $vacancy->update($this->validated($request));

        return back()->with('success', 'Vacancy updated.');
    }

    public function destroy(JobVacancy $vacancy)
    {
        $vacancy->delete();

        return back()->with('success', 'Vacancy deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'location' => 'nullable|string|max:100',
            'employment_type' => ['required', Rule::in(array_keys(Employee::TYPES))],
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'closing_date' => 'nullable|date',
        ]) + ['is_open' => $request->boolean('is_open')];
    }
}
