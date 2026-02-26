<?php

namespace App\Http\Controllers;

class CompanySettingsController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        $company->load('activeSubscription.plan');

        return view('company-settings.index', compact('company'));
    }
}
