<?php

namespace App\Http\Controllers\Portal\Accounts;

use App\Http\Controllers\Controller;
use App\Models\AcademicTerm;
use App\Models\courses;
use App\Models\Intake;
use App\Models\Invoice;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('student', 'term')
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($q) => $q
                ->where('invoice_no', 'like', "%{$request->q}%")
                ->orWhere('description', 'like', "%{$request->q}%")
                ->orWhereHas('student', fn ($s) => $s->where('admission_no', 'like', "%{$request->q}%")
                    ->orWhere('first_name', 'like', "%{$request->q}%")->orWhere('last_name', 'like', "%{$request->q}%"))))
            ->latest('invoice_date')->latest('id')
            ->paginate(30)->withQueryString();

        return view('portal.accounts.invoices', [
            'invoices' => $invoices,
            'courses' => courses::orderBy('name')->get(['id', 'name', 'total_terms']),
            'intakes' => Intake::orderByDesc('start_date')->pluck('name', 'id'),
            'terms' => AcademicTerm::orderByDesc('start_date')->pluck('name', 'id'),
            'currentTerm' => AcademicTerm::current(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admission_no' => 'required|exists:students,admission_no',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'academic_term_id' => 'nullable|exists:academic_terms,id',
        ]);

        $student = Student::where('admission_no', $data['admission_no'])->firstOrFail();
        $invoice = $student->invoices()->create(collect($data)->except('admission_no')->all() + [
            'invoice_no' => Invoice::nextNumber(),
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', "Invoice {$invoice->invoice_no} of ".money($invoice->amount)." raised for {$student->full_name}.");
    }

    /**
     * Bills every active student of a course (and optional intake) who is in the chosen term,
     * using that term's fee structure items. Students already billed for the same item and
     * academic term are skipped, so running it twice does not double-bill.
     */
    public function bulk(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'intake_id' => 'nullable|exists:intakes,id',
            'term_no' => 'required|integer|min:1|max:12',
            'academic_term_id' => 'required|exists:academic_terms,id',
            'include_once_off' => 'nullable|boolean',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
        ]);

        $course = courses::findOrFail($data['course_id']);
        $items = $course->feeItems()
            ->where(fn ($q) => $q->where('term_no', $data['term_no'])
                ->when($request->boolean('include_once_off'), fn ($q) => $q->orWhereNull('term_no')))
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error', "No fee structure items found for {$course->name} term {$data['term_no']}. Set up the fee structure first.");
        }

        $students = Student::where('course_id', $course->id)->where('status', 'active')
            ->where('current_term', $data['term_no'])
            ->when($data['intake_id'] ?? null, fn ($q, $id) => $q->where('intake_id', $id))
            ->get();

        $created = 0;
        DB::transaction(function () use ($students, $items, $data, &$created) {
            foreach ($students as $student) {
                foreach ($items as $item) {
                    $description = $item->name.($item->term_no ? " - Term {$item->term_no}" : '');
                    // Term items are billed once per academic term; once-off items only ever once.
                    $alreadyBilled = $student->invoices()->where('description', $description)
                        ->when($item->term_no, fn ($q) => $q->where('academic_term_id', $data['academic_term_id']))
                        ->exists();
                    if ($alreadyBilled) {
                        continue;
                    }
                    $student->invoices()->create([
                        'invoice_no' => Invoice::nextNumber(),
                        'academic_term_id' => $data['academic_term_id'],
                        'description' => $description,
                        'amount' => $item->amount,
                        'invoice_date' => $data['invoice_date'],
                        'due_date' => $data['due_date'] ?? null,
                        'created_by' => auth()->id(),
                    ]);
                    $created++;
                }
            }
        });

        return back()->with('success', "{$created} invoice line(s) raised for {$students->count()} student(s) in {$course->name}.");
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return back()->with('success', "Invoice {$invoice->invoice_no} cancelled.");
    }
}
