<?php

namespace App\Http\Controllers\Portal\Trainer;

use App\Models\LearningMaterial;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends TrainerController
{
    public function store(Request $request, Unit $unit)
    {
        $this->authorizeUnit($unit);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'file' => 'nullable|file|max:20480|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,mp4,zip',
            'link' => 'nullable|url|max:500',
        ]);

        if (! $request->hasFile('file') && empty($data['link'])) {
            return back()->withInput()->withErrors(['file' => 'Upload a file or provide a link.']);
        }

        $unit->materials()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'link' => $data['link'] ?? null,
            'file_path' => $request->hasFile('file') ? $request->file('file')->store('materials', 'public') : null,
            'uploaded_by' => auth()->id(),
        ]);

        return back()->with('success', 'Learning material shared with students.');
    }

    public function destroy(LearningMaterial $material)
    {
        $this->authorizeUnit($material->unit);

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();

        return back()->with('success', 'Material removed.');
    }
}
