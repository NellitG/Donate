<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Campaign;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('donor', 'campaign')->get();
        return view('admin.donations.index', compact('donations'));
    }

    public function create()
    {
        $donors = Donor::all();
        $campaigns = Campaign::all();
        return view('admin.donations.create', compact('donors', 'campaigns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:Credit Card,PayPal,Bank Transfer',
            'status' => 'required|in:Pending,Completed,Failed',
        ]);

        Donation::create($request->all());

        return redirect()->route('admin.donations.index')->with('success', 'Donation created successfully.');
    }

    public function edit(Donation $donation)
    {
        $donors = Donor::all();
        $campaigns = Campaign::all();
        return view('admin.donations.edit', compact('donation', 'donors', 'campaigns'));
    }

    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:Credit Card,PayPal,Bank Transfer',
            'status' => 'required|in:Pending,Completed,Failed',
        ]);

        $donation->update($request->all());

        return redirect()->route('admin.donations.index')->with('success', 'Donation updated successfully.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Donation deleted successfully.');
    }
}

