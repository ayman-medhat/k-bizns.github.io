<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.edit_deal') }}
        </h2>
    </x-slot>

    <div>
        <div class="flex justify-end mb-4">
            <a href="{{ route('deals.index') }}" title="{{ __('messages.back_to_list') }}"
                style="color: var(--btn-text); font-size: 1.6rem; transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                class="flex items-center">⬅️
            </a>
        </div>

        <form action="{{ route('deals.update', $deal) }}" method="POST">
            @csrf
            @method('PUT')

            <h3
                style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 2rem; font-weight: 350;">
                {{ __('messages.edit_deal_details') }}
            </h3>

            <div class="mb-6">
                <x-input-label for="title" :value="__('messages.deal_title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $deal->title)" required />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <x-input-label for="value" :value="__('messages.expected_value')" />
                    <x-text-input id="value" class="block mt-1 w-full" type="number" step="0.01" name="value"
                        :value="old('value', $deal->value)" required />
                </div>
                <div>
                    <x-input-label for="status" :value="__('messages.current_status')" />
                    <select name="status" id="status"
                        style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                        class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                        <option value="open" {{ $deal->status == 'open' ? 'selected' : '' }}>
                            {{ __('messages.open') }}
                        </option>
                        <option value="negotiation" {{ $deal->status == 'negotiation' ? 'selected' : '' }}>
                            {{ __('messages.negotiation') }}
                        </option>
                        <option value="proposal" {{ $deal->status == 'proposal' ? 'selected' : '' }}>
                            {{ __('messages.proposal') }}
                        </option>
                        <option value="won" {{ $deal->status == 'won' ? 'selected' : '' }}>
                            {{ __('messages.won') }}
                        </option>
                        <option value="lost" {{ $deal->status == 'lost' ? 'selected' : '' }}>
                            {{ __('messages.lost') }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="mb-8">
                <x-input-label for="client_id" :value="__('messages.associated_company')" />
                <select name="client_id" id="client_id"
                    style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                    class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]"
                    required>
                    <option value="">{{ __('messages.select_a_company') }}</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $deal->client_id == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Company selection for Super Admin -->
            @if(auth()->user()->hasRole('Super Admin'))
                <h3
                    style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 2rem; font-weight: 350;">
                    {{ __('messages.company_assignment') ?? __('Company Assignment') }}
                </h3>
                <div class="mb-8">
                    <x-input-label for="company_id" :value="__('messages.company') ?? __('Company')" />
                    <select name="company_id" id="company_id" required
                        style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                        class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                        <option value="">{{ __('messages.select_company') ?? __('Select Company') }}</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id', $deal->company_id) == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-end gap-3 mt-10">
                <button type="submit"
                    style="color: var(--btn-text); background: var(--btn-bg); padding: 0.8rem 2.5rem; border-radius: 40px; font-weight: 600; border: 1px solid var(--btn-border); cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); width: 100%;"
                    onmouseover="this.style.background='var(--btn-hover-bg)'; this.style.transform='translateY(-2px)';"
                    onmouseout="this.style.background='var(--btn-bg)'; this.style.transform='translateY(0)';"
                    class="focus:outline-none focus:shadow-outline sm:w-auto">
                    {{ __('messages.update_deal') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>