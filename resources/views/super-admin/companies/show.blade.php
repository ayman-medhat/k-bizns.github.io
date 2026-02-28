<x-app-layout>
    <x-slot name="header">
        {{ __('messages.company_details') }}: {{ $company->name }}
    </x-slot>

    <div>
        <div class="mb-6">
            <a href="{{ route('super-admin.companies.index') }}"
                style="color: var(--accent-text); padding: 0.4rem 1.2rem; border-radius: 30px; background: var(--accent-bg); border: 1px solid var(--accent-border); font-size: 0.875rem; transition: all 0.2s; display: inline-flex; items-center gap-1;"
                onmouseover="this.style.transform='translateX(-5px)';"
                onmouseout="this.style.transform='translateX(0)';" class="hover:underline">
                <span>←</span> {{ __('messages.back_to_companies') }}
            </a>
            <h2 class="mt-4"
                style="font-size: 2rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.4rem;">
                {{ $company->name }}
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Subscription Management -->
            <div class="glass-card p-8 space-y-6"
                style="background: var(--content-bg); border: 1px solid var(--row-border); border-radius: 1.5rem; box-shadow: var(--card-shadow);">
                <h3 class="text-xl font-semibold" style="color: var(--title-color);">
                    {{ __('messages.manage_subscription') }}
                </h3>

                <div class="p-4 rounded-2xl" style="background: var(--nav-bg); border: 1px solid var(--row-border);">
                    <p class="text-xs uppercase tracking-wider font-bold opacity-60" style="color: var(--text-color);">
                        {{ __('messages.current_plan') }}
                    </p>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-lg font-medium" style="color: var(--text-color);">
                            {{ $company->activeSubscription->plan->name ?? __('messages.no_active_subscription') }}
                        </span>
                        @if ($company->activeSubscription)
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold"
                                style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                {{ __('messages.active') }}
                            </span>
                        @endif
                    </div>
                    @if ($company->activeSubscription)
                        <p class="text-sm mt-2 opacity-70" style="color: var(--text-color);">
                            {{ __('messages.expires') }}:
                            {{ $company->activeSubscription->ends_at ? $company->activeSubscription->ends_at->format('Y-m-d') : __('messages.never') }}
                        </p>
                    @endif
                </div>

                <form action="{{ route('super-admin.companies.update-subscription', $company) }}" method="POST"
                    class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1.5"
                            style="color: var(--text-color);">{{ __('messages.change_plan') }}</label>
                        <select name="subscription_plan_id"
                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            style="background-color: var(--content-bg); color: var(--text-color); border-color: var(--row-border);">
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $company->activeSubscription && $company->activeSubscription->subscription_plan_id == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} (${{ $plan->price }}/{{ $plan->interval }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5"
                            style="color: var(--text-color);">{{ __('messages.expiry_date_optional') }}</label>
                        <input type="date" name="ends_at"
                            value="{{ $company->activeSubscription && $company->activeSubscription->ends_at ? $company->activeSubscription->ends_at->format('Y-m-d') : '' }}"
                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            style="background-color: var(--content-bg); color: var(--text-color); border-color: var(--row-border);">
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            style="background: var(--btn-bg); color: var(--btn-text); width: 100%; padding: 0.8rem; border-radius: 1rem; font-weight: 500; transition: all 0.2s;"
                            onmouseover="this.style.transform='translateY(-2px)';"
                            onmouseout="this.style.transform='translateY(0)';" class="hover:shadow-lg">
                            {{ __('messages.update_subscription') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Company Stats / Users -->
            <div class="glass-card p-8"
                style="background: var(--content-bg); border: 1px solid var(--row-border); border-radius: 1.5rem; box-shadow: var(--card-shadow);">
                <h3 class="text-xl font-semibold mb-6" style="color: var(--title-color);">
                    {{ __('messages.users') }} ({{ $company->users->count() }})
                </h3>
                <ul class="divide-y" style="border-color: var(--row-border);">
                    @foreach ($company->users as $user)
                        <li class="py-4 flex justify-between items-center">
                            <div>
                                <p class="font-medium" style="color: var(--text-color);">{{ $user->name }}</p>
                                <p class="text-sm opacity-70" style="color: var(--text-color);">{{ $user->email }}</p>
                            </div>
                            <span class="text-xs px-3 py-1 rounded-full font-semibold"
                                style="background: var(--nav-bg); color: var(--text-color); border: 1px solid var(--row-border);">
                                {{ $user->getRoleNames()->first() }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>