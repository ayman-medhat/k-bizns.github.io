<x-app-layout>
    <x-slot name="header">
        {{ __('messages.company_settings') }}
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <h2 class="text-xl font-bold mb-4">Subscription Overview</h2>

            @if($company->activeSubscription)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-slate-500 uppercase font-semibold">Current Plan</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $company->activeSubscription->plan->name }}</p>
                        <p class="text-sm text-slate-400 mt-1">Status: <span
                                class="text-green-600 font-medium">Active</span></p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 uppercase font-semibold">Ends At</p>
                        <p class="text-lg font-medium">
                            {{ $company->activeSubscription->ends_at ? $company->activeSubscription->ends_at->format('Y-m-d') : 'Never' }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 border-t border-slate-100 pt-6">
                    <h3 class="text-lg font-semibold mb-4">Plan Limits & Usage</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @php
                            $limits = $company->activeSubscription->plan->limits;
                            $usage = [
                                'max_users' => \App\Models\User::count(),
                                'max_clients' => \App\Models\Client::count(),
                                'max_contacts' => \App\Models\Contact::count(),
                                'max_deals' => \App\Models\Deal::count(),
                            ];
                        @endphp

                        @foreach($limits as $key => $limit)
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                                <p class="text-xs text-slate-500 uppercase font-bold">{{ str_replace('_', ' ', $key) }}</p>
                                <p class="text-xl font-bold mt-1">
                                    {{ $usage[$key] ?? 0 }} / {{ $limit }}
                                </p>
                                <div class="w-full bg-slate-200 rounded-full h-1.5 mt-2">
                                    <div class="bg-blue-600 h-1.5 rounded-full"
                                        style="width: {{ min(100, (($usage[$key] ?? 0) / $limit) * 100) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="p-4 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-lg">
                    No active subscription found. Please contact support.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>