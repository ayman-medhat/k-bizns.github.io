<?php

namespace App\Services;

use App\Models\Company;

class FeatureGate
{
    protected $company;

    public function __construct()
    {
        if (auth()->check()) {
            $this->company = auth()->user()->company;
        } elseif (session()->has('company_id')) {
            $this->company = Company::find(session('company_id'));
        }
    }

    public function setCompany(Company $company)
    {
        $this->company = $company;

        return $this;
    }

    public function hasFeature(string $feature): bool
    {
        if (! $this->company) {
            return false;
        }

        if (auth()->check() && auth()->user()->isRoot()) {
            return true;
        }

        $subscription = $this->company->activeSubscription;
        if (! $subscription) {
            if (! $this->company->trial_ends_at || $this->company->trial_ends_at->isFuture()) {
                return true;
            }
            return false;
        }

        $features = $subscription->plan->features ?? [];

        return in_array($feature, $features);
    }

    public function checkLimit(string $limit, int $currentCount): bool
    {
        if (! $this->company) {
            return false;
        }

        if (auth()->check() && auth()->user()->isRoot()) {
            return true;
        }

        $subscription = $this->company->activeSubscription;
        if (! $subscription) {
            if (! $this->company->trial_ends_at || $this->company->trial_ends_at->isFuture()) {
                return true;
            }
            return false;
        }

        $limits = $subscription->plan->limits ?? [];
        $max = $limits[$limit] ?? 0;

        return $currentCount < $max;
    }
}
