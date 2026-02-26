<x-app-layout>
    <x-slot name="header">
        Company Details: {{ $company->name }}
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('super-admin.companies.index') }}" class="text-blue-600 hover:underline">← Back to
                Companies</a>
            <h1 class="text-3xl font-bold mt-2">{{ $company->name }}</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Subscription Management -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold mb-4">Manage Subscription</h2>

                <div class="mb-4">
                    <p class="text-sm text-slate-500 uppercase font-semibold">Current Plan</p>
                    <p class="text-lg font-medium">
                        {{ $company->activeSubscription->plan->name ?? 'No active subscription' }}
                        @if($company->activeSubscription)
                            <span class="text-sm text-slate-400"> (Expires:
                                {{ $company->activeSubscription->ends_at ? $company->activeSubscription->ends_at->format('Y-m-d') : 'Never' }})</span>
                        @endif
                    </p>
                </div>

                <form action="{{ route('super-admin.companies.update-subscription', $company) }}" method="POST"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Change Plan</label>
                        <select name="subscription_plan_id"
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ ($company->activeSubscription && $company->activeSubscription->subscription_plan_id == $plan->id) ? 'selected' : '' }}>
                                    {{ $plan->name }} (${{ $plan->price }}/{{ $plan->interval }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Expiry Date (Optional)</label>
                        <input type="date" name="ends_at"
                            value="{{ $company->activeSubscription && $company->activeSubscription->ends_at ? $company->activeSubscription->ends_at->format('Y-m-d') : '' }}"
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Update
                        Subscription</button>
                </form>
            </div>

            <!-- Company Stats / Users -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold mb-4">Users ({{ $company->users->count() }})</h2>
                <ul class="divide-y divide-slate-100">
                    @foreach($company->users as $user)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium">{{ $user->name }}</p>
                                <p class="text-sm text-slate-500">{{ $user->email }}</p>
                            </div>
                            <span class="text-xs bg-slate-100 px-2 py-1 rounded">{{ $user->getRoleNames()->first() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>