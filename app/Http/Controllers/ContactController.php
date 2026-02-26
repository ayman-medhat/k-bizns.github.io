<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contact::class, 'contact');
    }

    public function index(): View
    {
        $contacts = Contact::with('client')->latest()->paginate(10);

        return view('contacts.index', compact('contacts'));
    }

    public function create(): View
    {
        $clients = Client::all();
        $countries = \App\Models\Country::with('cities')->get();

        return view('contacts.create', compact('clients', 'countries'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name_en' => 'required|string|max:255',
            'first_name_ar' => 'nullable|string|max:255',
            'last_name_en' => 'nullable|string|max:255',
            'last_name_ar' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_country_id' => 'nullable|exists:countries,id',
            'client_id' => 'nullable|exists:clients,id',
            'nationality_id' => 'nullable|exists:countries,id',
            'national_id' => 'nullable|string|max:20|unique:contacts,national_id',
            'passport_no' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'category' => 'nullable|string|max:50',
            'address_street' => 'nullable|string',
            'address_city_id' => 'nullable|exists:cities,id',
            'address_country_id' => 'nullable|exists:countries,id',
            'address_notes' => 'nullable|string',
            'photo_path' => 'nullable|image|max:2048', // 2MB Max
            'papers.*' => 'nullable|file|mimes:pdf|max:10240', // 10MB Max per file
        ]);

        // Handle Photo Upload
        if ($request->hasFile('photo_path')) {
            $path = $request->file('photo_path')->store('contacts/photos', 'public');
            $validated['photo_path'] = $path;
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

        $contact = Contact::create($validated);

        // Handle Papers Upload
        if ($request->hasFile('papers')) {
            foreach ($request->file('papers') as $file) {
                $path = $file->store('contacts/papers', 'public');
                $contact->papers()->create([
                    'file_path' => $path,
                    'title' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    public function show(Contact $contact): View
    {
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact): View
    {
        $clients = Client::all();
        $countries = \App\Models\Country::with('cities')->get();

        return view('contacts.edit', compact('contact', 'clients', 'countries'));
    }

    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'first_name_en' => 'required|string|max:255',
            'first_name_ar' => 'nullable|string|max:255',
            'last_name_en' => 'nullable|string|max:255',
            'last_name_ar' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_country_id' => 'nullable|exists:countries,id',
            'client_id' => 'nullable|exists:clients,id',
            'nationality_id' => 'nullable|exists:countries,id',
            'national_id' => 'nullable|string|max:20|unique:contacts,national_id,'.$contact->id,
            'passport_no' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'category' => 'nullable|string|max:50',
            'address_street' => 'nullable|string',
            'address_city_id' => 'nullable|exists:cities,id',
            'address_country_id' => 'nullable|exists:countries,id',
            'address_notes' => 'nullable|string',
            'photo_path' => 'nullable|image|max:2048',
            'papers.*' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Handle Photo Upload
        if ($request->hasFile('photo_path')) {
            // Delete old photo if exists
            if ($contact->photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($contact->photo_path);
            }
            $path = $request->file('photo_path')->store('contacts/photos', 'public');
            $validated['photo_path'] = $path;
        }

        // Handle Address Update (Create new if didn't exist, or update existing)
        if ($request->filled('address_street') || $request->filled('address_city_id') || $request->filled('address_country_id')) {
            if ($contact->address_id) {
                $contact->address->update([
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

        $contact->update($validated);

        // Handle Papers Upload (Append)
        // Check max count
        $currentCount = $contact->papers()->count();
        if ($request->hasFile('papers')) {
            $newCount = count($request->file('papers'));
            if (($currentCount + $newCount) > 30) {
                return back()->withErrors(['papers' => 'Maximum 30 papers allowed per contact.']);
            }

            foreach ($request->file('papers') as $file) {
                $path = $file->store('contacts/papers', 'public');
                $contact->papers()->create([
                    'file_path' => $path,
                    'title' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }

    public function kanban(): View
    {
        $contacts = Contact::with('client')->get();

        $categories = [
            'lead' => $contacts->where('category', 'lead'),
            'prospect' => $contacts->where('category', 'prospect'),
            'customer' => $contacts->where('category', 'customer'),
            'other' => $contacts->whereNotIn('category', ['lead', 'prospect', 'customer']),
        ];

        return view('contacts.kanban', compact('categories'));
    }

    public function updateStatus(Request $request, Contact $contact): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $contact->update(['category' => $request->status]);

        return response()->json(['success' => true]);
    }
}
