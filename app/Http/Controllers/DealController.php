<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Deal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Deal::class, 'deal');
    }

    public function index(): View
    {
        $deals = Deal::with('client')->latest()->paginate(10);

        return view('deals.index', compact('deals'));
    }
    public function create(): View
    {
        $clients = Client::all();
        $companies = auth()->user()->hasRole('Super Admin') ? \App\Models\Company::all() : collect();
        return view('deals.create', compact('clients', 'companies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'status' => 'required|in:open,won,lost',
            'client_id' => 'required|exists:clients,id',
        ]);

        if (auth()->user()->hasRole('Super Admin') && $request->filled('company_id')) {
            $validated['company_id'] = $request->company_id;
        }

        Deal::create($validated);

        return redirect()->route('deals.index')
            ->with('success', __('messages.deal_created_successfully'));
    }

    public function show(Deal $deal): View
    {
        return view('deals.show', compact('deal'));
    }
    public function edit(Deal $deal): View
    {
        $clients = Client::all();
        $companies = auth()->user()->hasRole('Super Admin') ? \App\Models\Company::all() : collect();
        return view('deals.edit', compact('deal', 'clients', 'companies'));
    }

    public function update(Request $request, Deal $deal): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'status' => 'required|in:open,won,lost',
            'client_id' => 'required|exists:clients,id',
        ]);

        if (auth()->user()->hasRole('Super Admin') && $request->filled('company_id')) {
            $validated['company_id'] = $request->company_id;
        }

        $deal->update($validated);

        return redirect()->route('deals.index')
            ->with('success', __('messages.deal_updated_successfully'));
    }

    public function destroy(Deal $deal): RedirectResponse
    {
        $deal->delete();

        return redirect()->route('deals.index')
            ->with('success', __('messages.deal_deleted_successfully'));
    }

    public function kanban(): View
    {
        $deals = Deal::all();
        $openDeals = $deals->where('status', 'open');
        $wonDeals = $deals->where('status', 'won');
        $lostDeals = $deals->where('status', 'lost');

        return view('deals.kanban', compact('openDeals', 'wonDeals', 'lostDeals'));
    }

    public function updateStatus(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,won,lost',
        ]);

        $deal->update(['status' => $validated['status']]);

        return response()->json(['success' => true]);
    }
}
