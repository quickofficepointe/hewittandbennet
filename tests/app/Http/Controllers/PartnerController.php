<?php

namespace App\Http\Controllers;

use App\Models\partner;  // Updated to match new model name
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = partner::all();
        return view('dashboards.staff.partners.index', compact('partners'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'partner_name' => 'required|string|max:255',
            'partner_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'partner_description' => 'required|string',
        ]);

        $path = $request->file('partner_logo')->store('partnerships', 'public');

        Partner::create([
            'name' => $validated['partner_name'],
            'logo' => $path,
            'description' => $validated['partner_description'],
        ]);

        return redirect()->back()
            ->with('success', 'Partner added successfully!');
    }

    public function show()
    {
        $partners = Partner::all();
        return view('quicks.frontend.partners', compact('partners'));
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('quicks.admins.partnership.edit', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'partner_name' => 'required|string|max:255',
            'partner_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'partner_description' => 'required|string',
        ]);

        $partner = Partner::findOrFail($id);
        $data = [
            'name' => $validated['partner_name'],
            'description' => $validated['partner_description'],
        ];

        if ($request->hasFile('partner_logo')) {
            // Delete old logo
            Storage::disk('public')->delete($partner->logo);

            // Store new logo
            $data['logo'] = $request->file('partner_logo')->store('partnerships', 'public');
        }

        $partner->update($data);

        return redirect()->route('quicks.admins.partnership.index')
            ->with('success', 'Partner updated successfully!');
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);

        // Delete logo file
        Storage::disk('public')->delete($partner->logo);

        $partner->delete();

        return redirect()->route('quicks.admins.partnership.index')
            ->with('success', 'Partner deleted successfully!');
    }
}