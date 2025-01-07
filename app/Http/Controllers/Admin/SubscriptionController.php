<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonorSubscription;
use App\Models\Donor;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = DonorSubscription::with('donor', 'plan')->get();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $donors = Donor::all();
        $plans = SubscriptionPlan::all();
        return view('admin.subscriptions.create', compact('donors', 'plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'plan_id' => 'required|exists:subscription_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:Active,Expired',
        ]);

        DonorSubscription::create($request->all());

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription created successfully.');
    }

    public function edit(DonorSubscription $subscription)
    {
        $donors = Donor::all();
        $plans = SubscriptionPlan::all();
        return view('admin.subscriptions.edit', compact('subscription', 'donors', 'plans'));
    }

    public function update(Request $request, DonorSubscription $subscription)
    {
        $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'plan_id' => 'required|exists:subscription_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:Active,Expired',
        ]);

        $subscription->update($request->all());

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function destroy(DonorSubscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription deleted successfully.');
    }
}
