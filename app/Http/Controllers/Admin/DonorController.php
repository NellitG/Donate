<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index()
    {
        $donors = Donor::all();
        return view('admin.donors.index', compact('donors'));
    }

    public function create()
    {
        return view('admin.donors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:donors',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Donor::create($request->all());

        return redirect()->route('admin.donors.index')->with('success', 'Donor created successfully.');
    }

    public function edit(Donor $donor)
    {
        return view('admin.donors.edit', compact('donor'));
    }

    public function update(Request $request, Donor $donor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:donors,email,' . $donor->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $donor->update($request->all());

        return redirect()->route('admin.donors.index')->with('success', 'Donor updated successfully.');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();
        return redirect()->route('admin.donors.index')->with('success', 'Donor deleted successfully.');
    }
}
