<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Client::class, 'client');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $clients = Client::with('industry')->latest()->paginate(10);

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $industries = \App\Models\Industry::all();
        $countries = \App\Models\Country::with('cities')->get();

        return view('clients.create', compact('industries', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_country_id' => 'nullable|exists:countries,id',
            'website' => 'nullable|url|max:255',
            'logo_path' => 'nullable|image|max:2048', // 2MB Max
            'industry_id' => 'nullable|exists:industries,id',
            'address_street' => 'nullable|string',
            'address_city_id' => 'nullable|exists:cities,id',
            'address_country_id' => 'nullable|exists:countries,id',
            'address_notes' => 'nullable|string',
        ]);

        // Handle File Upload
        if ($request->hasFile('logo_path')) {
            $path = $request->file('logo_path')->store('client_logos', 'public');
            $validated['logo_path'] = $path;
        }

        // Handle Address Creation
        if ($request->filled('address_street') || $request->filled('address_city_id') || $request->filled('address_country_id')) {
            $address = \App\Models\Address::create([
                'street' => $request->address_street,
                'city_id' => $request->address_city_id ?: null,
                'country_id' => $request->address_country_id ?: null,
                'notes' => $request->address_notes,
            ]);
            $validated['address_id'] = $address->id;
        }

        // Mapping address_street to address field for backward compatibility or simple display if needed
        if (isset($validated['address_street'])) {
            $validated['address'] = $validated['address_street'];
        }

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client): View
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client): View
    {
        $industries = \App\Models\Industry::all();
        $countries = \App\Models\Country::with('cities')->get();

        return view('clients.edit', compact('client', 'industries', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_country_id' => 'nullable|exists:countries,id',
            'website' => 'nullable|url|max:255',
            'logo_path' => 'nullable|image|max:2048',
            'industry_id' => 'nullable|exists:industries,id',
            'address_street' => 'nullable|string',
            'address_city_id' => 'nullable|exists:cities,id',
            'address_country_id' => 'nullable|exists:countries,id',
            'address_notes' => 'nullable|string',
        ]);

        // Handle File Upload
        if ($request->hasFile('logo_path')) {
            $path = $request->file('logo_path')->store('client_logos', 'public');
            $validated['logo_path'] = $path;
        }

        // Handle Address Update
        if ($request->filled('address_street') || $request->filled('address_city_id') || $request->filled('address_country_id')) {
            if ($client->address_id) {
                $client->addressRel()->update([
                    'street' => $request->address_street,
                    'city_id' => $request->address_city_id ?: null,
                    'country_id' => $request->address_country_id ?: null,
                    'notes' => $request->address_notes,
                ]);
            } else {
                $address = \App\Models\Address::create([
                    'street' => $request->address_street,
                    'city_id' => $request->address_city_id ?: null,
                    'country_id' => $request->address_country_id ?: null,
                    'notes' => $request->address_notes,
                ]);
                $validated['address_id'] = $address->id;
            }
        }

        if (isset($request->address_street)) {
            $validated['address'] = $request->address_street;
        }

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    public function kanban(): View
    {
        $clients = Client::all();

        $statuses = [
            'lead' => $clients->where('status', 'lead'),
            'client' => $clients->where('status', 'client'),
            'partner' => $clients->where('status', 'partner'),
            'inactive' => $clients->where('status', 'inactive'),
        ];

        return view('clients.kanban', compact('statuses'));
    }

    public function updateStatus(Request $request, Client $client): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $client->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
}
