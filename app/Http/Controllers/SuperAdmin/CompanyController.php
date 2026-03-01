<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanySubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

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
        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        $managers = $company->users()->orderBy('name')->get();

        return view('super-admin.companies.show', compact('company', 'plans', 'roles', 'managers'));
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

    public function storeUser(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'manager_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(fn($query) => $query->where('company_id', $company->id)),
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'manager_id' => $validated['manager_id'] ?? null,
            'company_id' => $company->id,
        ]);

        $user->assignRole($validated['role']);

        return redirect()
            ->route('super-admin.companies.show', $company)
            ->with('success', __('messages.user_created_successfully'));
    }
}
