<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use App\Models\Deal;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $counts = [
            'companies' => Client::count(),
            'contacts' => Contact::count(),
            'deals' => Deal::count(),
        ];

        return view('dashboard', compact('counts'));
    }
}
