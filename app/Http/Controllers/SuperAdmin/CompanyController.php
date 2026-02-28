<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanySubscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with('activeSubscription.plan')->get();

        return view('super-admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('super-admin.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Company::create($request->only('name'));

        return redirect()->route('super-admin.companies.index')->with('success', __('messages.company_created_successfully'));
    }

    public function show(Company $company)
    {
        $company->load('subscriptions.plan', 'users');
        $plans = SubscriptionPlan::all();

        return view('super-admin.companies.show', compact('company', 'plans'));
    }

    public function updateSubscription(Request $request, Company $company)
    {
        $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'ends_at' => 'nullable|date|after:today',
        ]);

        // Deactivate current active subscriptions
        $company->subscriptions()->where('status', 'active')->update(['status' => 'inactive']);

        CompanySubscription::create([
            'company_id' => $company->id,
            'subscription_plan_id' => $request->subscription_plan_id,
            'starts_at' => now(),
            'ends_at' => $request->ends_at,
            'status' => 'active',
        ]);

        return redirect()->route('super-admin.companies.show', $company)->with('success', __('messages.subscription_updated_successfully'));
    }
}
