<?php

namespace App\Http\Controllers\Portal\Admin;

use App\Http\Controllers\Controller;
use App\Models\courses;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $units = Unit::with('course', 'trainer')
            ->when($request->filled('course_id'), fn ($q) => $q->where('course_id', $request->course_id))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($q) => $q
                ->where('name', 'like', "%{$request->q}%")->orWhere('code', 'like', "%{$request->q}%")))
            ->orderBy('course_id')->orderBy('term_no')->orderBy('code')
            ->paginate(30)->withQueryString();

        return view('portal.admin.units.index', [
            'units' => $units,
            'courses' => courses::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function create(Request $request)
    {
        return view('portal.admin.units.form', $this->formData(new Unit(['course_id' => $request->course_id, 'term_no' => 1])));
    }

    public function store(Request $request)
    {
        Unit::create($this->validated($request));

        return redirect()->route('portal.admin.units.index', ['course_id' => $request->course_id])->with('success', 'Unit created.');
    }

    public function edit(Unit $unit)
    {
        return view('portal.admin.units.form', $this->formData($unit));
    }

    public function update(Request $request, Unit $unit)
    {
        $unit->update($this->validated($request, $unit));

        return redirect()->route('portal.admin.units.index', ['course_id' => $unit->course_id])->with('success', 'Unit updated.');
    }

    public function destroy(Unit $unit)
    {
        if ($unit->assessments()->exists() || $unit->attendances()->exists()) {
            return back()->with('error', 'This unit already has marks or attendance recorded and cannot be deleted.');
        }
        $unit->delete();

        return back()->with('success', 'Unit deleted.');
    }

    private function formData(Unit $unit): array
    {
        return [
            'unit' => $unit,
            'courses' => courses::orderBy('name')->pluck('name', 'id'),
            'trainers' => User::where('role', User::TRAINER)->where('is_active', true)->orderBy('name')->pluck('name', 'id'),
        ];
    }

    private function validated(Request $request, ?Unit $unit = null): array
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'code' => ['required', 'string', 'max:30', Rule::unique('units')->ignore($unit?->id)],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'term_no' => 'required|integer|min:1|max:12',
            'hours' => 'nullable|integer|min:0|max:2000',
            'trainer_id' => ['nullable', Rule::exists('users', 'id')->where('role', User::TRAINER)],
        ]);
        $data['hours'] = $data['hours'] ?? 0;

        return $data;
    }
}
