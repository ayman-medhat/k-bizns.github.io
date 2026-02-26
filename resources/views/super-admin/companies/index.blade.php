<x-app-layout>
    <x-slot name="header">
        Manage Companies
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Manage Companies</h1>
            <a href="{{ route('super-admin.companies.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Add Company</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Current Plan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Created At</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 italic">
                    @foreach($companies as $company)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $company->name }}</td>
                            <td class="px-6 py-4">
                                {{ $company->activeSubscription->plan->name ?? 'No Plan' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($company->activeSubscription)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded-full text-xs">No Active
                                        Plan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $company->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('super-admin.companies.show', $company) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">Manage</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>