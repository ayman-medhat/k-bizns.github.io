<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.edit_client') }}
        </h2>
    </x-slot>

    <div x-data="clientForm({{ $countries }}, {{ $client->addressRel ? $client->addressRel->country_id : 1 }})">
        <div class="flex justify-end mb-4">
            <a href="{{ route('clients.index') }}" title="{{ __('messages.back_to_list') }}"
                style="color: var(--btn-text); font-size: 1.6rem; transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                class="flex items-center">⬅️
            </a>
        </div>

        <form action="{{ route('clients.update', $client) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Info -->
                        <h3
                            style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                            {{ __('messages.client_details') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <x-input-label for="name" :value="__('messages.client_name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name', $client->name)" required />
                            </div>
                            <div>
                                <x-input-label for="industry_id" :value="__('messages.industry')" />
                                <select name="industry_id" id="industry_id"
                                    style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                                    class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                                    <option value="">{{ __('messages.select_industry') }}</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry->id }}" {{ $client->industry_id == $industry->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $industry->name_ar : $industry->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="website" :value="__('messages.website_url')" />
                                <x-text-input id="website" class="block mt-1 w-full" type="url" name="website"
                                    :value="old('website', $client->website)" placeholder="https://example.com" />
                            </div>
                            <div
                                style="background: var(--nav-bg); padding: 1rem; border-radius: 1.25rem; border: 1px solid var(--nav-border);">
                                <x-input-label for="logo_path" :value="__('messages.client_logo')" />
                                @if($client->logo_path)
                                    <div class="mb-3 flex items-center gap-3">
                                        <img src="{{ asset('storage/' . $client->logo_path) }}" alt="Current Logo"
                                            style="height: 50px; width: 50px; border-radius: 0.75rem; border: 2px solid var(--accent-border); object-fit: cover;">
                                        <span
                                            style="font-size: 0.8rem; opacity: 0.7; font-style: italic;">{{ __('messages.current_logo') }}</span>
                                    </div>
                                @endif
                                <input id="logo_path" type="file" name="logo_path" accept="image/*"
                                    style="color: var(--text-color);"
                                    class="block mt-2 w-full text-sm file:{{ app()->getLocale() == 'ar' ? 'ml' : 'mr' }}-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[var(--accent-bg)] file:text-[var(--accent-text)] hover:file:opacity-80" />
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <h3
                            style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                            {{ __('messages.contact_information') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <x-input-label for="email" :value="__('messages.email_address')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email', $client->email)" />
                            </div>
                            <div>
                                <x-input-label for="phone" :value="__('messages.phone_number')" />
                                <div class="flex mt-1">
                                    <select name="phone_country_id"
                                        style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: {{ app()->getLocale() == 'ar' ? '0 0.75rem 0.75rem 0' : '0.75rem 0 0 0.75rem' }}; color: var(--text-color); width: 35%;"
                                        class="focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                                        <option value="">{{ __('messages.code') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ $client->phone_country_id == $country->id ? 'selected' : '' }}>
                                                +{{ $country->phone_code }}
                                                ({{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-text-input id="phone"
                                        style="border-radius: {{ app()->getLocale() == 'ar' ? '0.75rem 0 0 0.75rem' : '0 0.75rem 0.75rem 0' }}; width: 65%; border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: none;"
                                        class="block" type="text" name="phone" :value="old('phone', $client->phone)"
                                        placeholder="123456789" />
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <h3
                            style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                            {{ __('messages.location_details') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <x-input-label for="address_country_id" :value="__('messages.country')" />
                                <select id="address_country_id" name="address_country_id" x-model="addressCountryId"
                                    style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                                    class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                                    <option value="">{{ __('messages.select_country') }}</option>
                                    <template x-for="country in countries" :key="country.id">
                                        <option :value="country.id" x-text="country['name_{{ app()->getLocale() }}']"
                                            :selected="country.id == addressCountryId"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="address_city_id" :value="__('messages.city')" />
                                <select id="address_city_id" name="address_city_id"
                                    style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                                    class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                                    <option value="">{{ __('messages.select_city') }}</option>
                                    <template x-for="city in availableCities" :key="city.id">
                                        <option :value="city.id" x-text="city['name_{{ app()->getLocale() }}']"
                                            :selected="city.id == {{ $client->addressRel ? $client->addressRel->city_id : 'null' }}">
                                        </option>
                                    </template>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="address_street" :value="__('messages.street_address')" />
                                <x-text-input id="address_street" class="block mt-1 w-full" type="text"
                                    name="address_street" :value="old('address_street', $client->addressRel ? $client->addressRel->street : $client->address)" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="address_notes" :value="__('messages.address_notes')" />
                                <textarea id="address_notes" name="address_notes"
                                    style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 1rem; color: var(--text-color);"
                                    class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]"
                                    rows="2">{{ old('address_notes', $client->addressRel ? $client->addressRel->notes : '') }}</textarea>
                            </div>
                        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-3 mt-10">
            <button type="submit"
                style="color: var(--btn-text); background: var(--btn-bg); padding: 0.8rem 2.5rem; border-radius: 40px; font-weight: 600; border: 1px solid var(--btn-border); cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); width: 100%;"
                onmouseover="this.style.background='var(--btn-hover-bg)'; this.style.transform='translateY(-2px)';"
                onmouseout="this.style.background='var(--btn-bg)'; this.style.transform='translateY(0)';"
                class="focus:outline-none focus:shadow-outline sm:w-auto">
                {{ __('messages.update_client') }}
            </button>
        </div>
    </form>
</div>

    <script>
        function clientForm(countriesData, initialCountryId) {
            return {
                countries: countriesData,
                addressCountryId: initialCountryId,

                get availableCities() {
                    if (!this.addressCountryId) return [];
                    const country = this.countries.find(c => c.id == this.addressCountryId);
                    return country ? country.cities : [];
                }
            }
        }
    </script>
</x-app-layout>