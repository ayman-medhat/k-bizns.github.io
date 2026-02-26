<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;

class CompanyInfoController extends Controller
{
    /**
     * Display the company information.
     */
    public function show()
    {
        $companyInfo = CompanyInfo::first();

        return view('company-info.show', compact('companyInfo'));
    }
}
