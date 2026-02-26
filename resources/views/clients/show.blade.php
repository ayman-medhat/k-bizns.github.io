<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $client->name }}
        </h2>
    </x-slot>

    <div>
        <div class="flex justify-end mb-4">
            <a href="{{ route('clients.index') }}" title="{{ __('messages.back_to_list') }}"
                style="color: var(--btn-text); font-size: 1.8rem; transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                class="flex items-center">
                ⬅️
            </a>
        </div>

        <div
            style="background: var(--nav-bg); border-radius: 2rem; padding: 2rem; border: 1px solid var(--nav-border); box-shadow: var(--card-shadow); margin-bottom: 1.5rem;">
            <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                <div class="flex items-center gap-6">
                    @if($client->logo_path)
                        <img src="{{ asset('storage/' . $client->logo_path) }}" alt="{{ $client->name }}"
                            style="height: 100px; width: 100px; border-radius: 1.5rem; border: 3px solid var(--accent-border); object-fit: cover; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);">
                    @else
                        <div
                            style="height: 100px; width: 100px; border-radius: 1.5rem; background: var(--bg-color); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-size: 2.5rem; border: 2px solid var(--nav-border); box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);">
                            {{ substr($client->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="text-3xl font-light" style="color: var(--title-color); letter-spacing: -0.01em;">
                            {{ $client->name }}
                        </h3>
                        @if($client->industry)
                            <span
                                style="display: inline-block; background: var(--badge-bg); padding: 0.3rem 1rem; border-radius: 40px; border: 1px solid var(--badge-border); color: var(--text-color); font-size: 0.85rem; margin-top: 0.5rem;">
                                {{ app()->getLocale() == 'ar' ? $client->industry->name_ar : $client->industry->name_en }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex gap-4 items-center">
                    <a href="{{ route('clients.edit', $client) }}" title="{{ __('messages.edit_client') }}"
                        style="color: var(--btn-text); font-size: 1.5rem; transition: transform 0.2s;"
                        onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                        class="flex items-center">
                        ✏️
                    </a>
                    <form action="{{ route('clients.destroy', $client) }}" method="POST"
                        onsubmit="return confirm('{{ __('messages.are_you_sure') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="{{ __('messages.delete') }}"
                            style="color: var(--btn-text); font-size: 1.5rem; border: none; cursor: pointer; transition: transform 0.2s; background: none;"
                            onmouseover="this.style.transform='scale(1.2)';"
                            onmouseout="this.style.transform='scale(1)';" class="flex items-center">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Details Section -->
            <div
                style="background: var(--content-bg); border-radius: 2rem; padding: 2rem; border: 1px solid var(--content-border);">
                <h4
                    style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                    {{ __('messages.client_details') }}
                </h4>

                <div class="space-y-4">
                    <div
                        style="background: var(--nav-bg); padding: 0.8rem 1.2rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                        <p style="font-size: 0.75rem; opacity: 0.7; text-transform: uppercase; font-weight: 600;">
                            {{ __('messages.email_address') }}
                        </p>
                        <p style="color: var(--text-color); font-weight: 500;">
                            {{ $client->email ?: __('messages.not_available') }}
                        </p>
                    </div>
                    <div
                        style="background: var(--nav-bg); padding: 0.8rem 1.2rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                        <p style="font-size: 0.75rem; opacity: 0.7; text-transform: uppercase; font-weight: 600;">
                            {{ __('messages.phone_number') }}
                        </p>
                        <p style="color: var(--text-color); font-weight: 500;">
                            @if($client->phoneCountry)
                                +{{ $client->phoneCountry->phone_code }}
                            @endif
                            {{ $client->phone ?: __('messages.not_available') }}
                        </p>
                    </div>
                    <div
                        style="background: var(--nav-bg); padding: 0.8rem 1.2rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                        <p style="font-size: 0.75rem; opacity: 0.7; text-transform: uppercase; font-weight: 600;">
                            {{ __('messages.website') }}
                        </p>
                        @if($client->website)
                            <a href="{{ $client->website }}" target="_blank"
                                style="color: var(--title-color); font-weight: 500; text-decoration: underline;">{{ $client->website }}</a>
                        @else
                            <p style="opacity: 0.5;">{{ __('messages.not_available') }}</p>
                        @endif
                    </div>
                    <div
                        style="background: var(--nav-bg); padding: 0.8rem 1.2rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                        <p style="font-size: 0.75rem; opacity: 0.7; text-transform: uppercase; font-weight: 600;">
                            {{ __('messages.address') }}
                        </p>
                        <p style="color: var(--text-color); font-weight: 500;">
                            @if($client->addressRel)
                                {{ $client->addressRel->street }},
                                {{ $client->addressRel->city ? (app()->getLocale() == 'ar' ? $client->addressRel->city->name_ar : $client->addressRel->city->name_en) : '' }},
                                {{ $client->addressRel->country ? (app()->getLocale() == 'ar' ? $client->addressRel->country->name_ar : $client->addressRel->country->name_en) : '' }}
                            @elseif($client->address)
                                {{ $client->address }}
                            @else
                                <span style="opacity: 0.5;">{{ __('messages.no_address_provided') }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Related Data Section -->
            <div class="flex flex-col gap-6">
                <!-- Contacts -->
                <div
                    style="background: var(--content-bg); border-radius: 2rem; padding: 2rem; border: 1px solid var(--content-border);">
                    <h4
                        style="font-size: 1.3rem; color: var(--title-color); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.2rem; font-weight: 350;">
                        <span>👥</span> {{ __('messages.contacts_count', ['count' => $client->contacts->count()]) }}
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @forelse($client->contacts as $contact)
                            <a href="{{ route('contacts.show', $contact) }}"
                                style="background: var(--nav-bg); padding: 0.5rem 1rem; border-radius: 12px; border: 1px solid var(--nav-border); color: var(--text-color); text-decoration: none; font-size: 0.9rem; transition: all 0.2s;"
                                onmouseover="this.style.background='var(--btn-hover-bg)';"
                                onmouseout="this.style.background='var(--nav-bg)';" class="flex items-center gap-1">
                                {{ $contact->name }}
                            </a>
                        @empty
                            <p style="opacity: 0.6; font-style: italic;">{{ __('messages.no_contacts_listed') }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Deals -->
                <div
                    style="background: var(--content-bg); border-radius: 2rem; padding: 2rem; border: 1px solid var(--content-border);">
                    <h4
                        style="font-size: 1.3rem; color: var(--title-color); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.2rem; font-weight: 350;">
                        <span>💰</span> {{ __('messages.deals_count', ['count' => $client->deals->count()]) }}
                    </h4>
                    <div class="space-y-3">
                        @forelse($client->deals as $deal)
                            <a href="{{ route('deals.show', $deal) }}"
                                style="display: flex; justify-between; items-center; padding: 0.8rem 1rem; background: var(--nav-bg); border-radius: 1rem; border: 1px solid var(--nav-border); text-decoration: none; transition: all 0.2s;"
                                onmouseover="this.style.background='var(--btn-hover-bg)';"
                                onmouseout="this.style.background='var(--nav-bg)';"
                                class="flex justify-between items-center">
                                <span style="color: var(--text-color); font-weight: 600;">{{ $deal->title }}</span>
                                <span
                                    style="background: var(--badge-bg); padding: 0.2rem 0.6rem; border-radius: 10px; color: var(--text-color); font-size: 0.8rem; font-weight: bold; border: 1px solid var(--badge-border);">
                                    ${{ number_format($deal->value, 2) }}
                                </span>
                            </a>
                        @empty
                            <p style="opacity: 0.6; font-style: italic;">{{ __('messages.no_deals_found') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-app-layout>