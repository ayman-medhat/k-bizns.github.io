<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::all();

        return view('super-admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('super-admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'interval' => 'required|in:month,year',
            'limits' => 'required|array',
            'features' => 'nullable|array',
        ]);

        SubscriptionPlan::create($request->all());

        return redirect()->route('super-admin.plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit(SubscriptionPlan $plan)
    {
        return view('super-admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'interval' => 'required|in:month,year',
            'limits' => 'required|array',
            'features' => 'nullable|array',
        ]);

        $plan->update($request->all());

        return redirect()->route('super-admin.plans.index')->with('success', 'Plan updated successfully.');
    }
}
