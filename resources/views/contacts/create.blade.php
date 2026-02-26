<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.create_contact') }}
        </h2>
    </x-slot>

    <div x-data="contactForm({{ $countries }})">
        <div class="flex justify-end mb-4">
            <a href="{{ route('contacts.index') }}" title="{{ __('messages.back_to_list') }}"
                style="color: var(--btn-text); font-size: 1.6rem; transition: all 0.2s;"
                onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                class="flex items-center">⬅️
            </a>
        </div>

        <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Personal Info -->
            <h3
                style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                {{ __('messages.personal_information') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <x-input-label for="first_name_en" :value="__('messages.first_name_en')" />
                    <x-text-input id="first_name_en" class="block mt-1 w-full" type="text" name="first_name_en"
                        required />
                </div>
                <div>
                    <x-input-label for="last_name_en" :value="__('messages.last_name_en')" />
                    <x-text-input id="last_name_en" class="block mt-1 w-full" type="text" name="last_name_en" />
                </div>
                <div class="{{ app()->getLocale() == 'ar' ? '' : 'text-right' }}" dir="rtl">
                    <x-input-label for="first_name_ar" :value="__('messages.first_name_ar')" />
                    <x-text-input id="first_name_ar" class="block mt-1 w-full text-right" type="text"
                        name="first_name_ar" />
                </div>
                <div class="{{ app()->getLocale() == 'ar' ? '' : 'text-right' }}" dir="rtl">
                    <x-input-label for="last_name_ar" :value="__('messages.last_name_ar')" />
                    <x-text-input id="last_name_ar" class="block mt-1 w-full text-right" type="text"
                        name="last_name_ar" />
                </div>
            </div>

            <!-- Contact Info -->
            <h3
                style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                {{ __('messages.contact_details') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <x-input-label for="email" :value="__('messages.email_address')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" />
                </div>
                <div>
                    <x-input-label for="phone" :value="__('messages.phone_number')" />
                    <div class="flex mt-1">
                        <select name="phone_country_id"
                            style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: {{ app()->getLocale() == 'ar' ? '0 0.75rem 0.75rem 0' : '0.75rem 0 0 0.75rem' }}; color: var(--text-color); width: 35%;"
                            class="focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                            <option value="">{{ __('messages.code') }}</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->phone_code }}
                                    ({{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }})
                                </option>
                            @endforeach
                        </select>
                        <x-text-input id="phone"
                            style="border-radius: {{ app()->getLocale() == 'ar' ? '0.75rem 0 0 0.75rem' : '0 0.75rem 0.75rem 0' }}; width: 65%; border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: none;"
                            class="block" type="text" name="phone" placeholder="123456789" />
                    </div>
                </div>
            </div>

            <!-- Identification -->
            <h3
                style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                {{ __('messages.identification') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <x-input-label for="nationality_id" :value="__('messages.nationality')" />
                    <select id="nationality_id" name="nationality_id" x-model="nationalityId"
                        style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                        class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                        <template x-for="country in countries" :key="country.id">
                            <option :value="country.id" x-text="country['nationality_' + '{{ app()->getLocale() }}']"
                                :selected="country.id == 1"></option>
                        </template>
                    </select>
                </div>
                <div x-show="isEgyptian">
                    <x-input-label for="national_id" :value="__('messages.national_id')" />
                    <x-text-input id="national_id" class="block mt-1 w-full" type="text" name="national_id" />
                </div>
                <div x-show="!isEgyptian">
                    <x-input-label for="passport_no" :value="__('messages.passport_number')" />
                    <x-text-input id="passport_no" class="block mt-1 w-full" type="text" name="passport_no" />
                </div>
                <div>
                    <x-input-label for="birthdate" :value="__('messages.birthdate')" />
                    <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" />
                </div>
            </div>

            <!-- Categorization -->
            <h3
                style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                {{ __('messages.categorization') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <x-input-label for="category" :value="__('messages.category')" />
                    <x-text-input id="category" class="block mt-1 w-full" type="text" name="category"
                        placeholder="e.g. VIP, Lead, Client" />
                </div>
                <div>
                    <x-input-label for="client_id" :value="__('messages.assign_company')" />
                    <select id="client_id" name="client_id"
                        style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                        class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                        <option value="">{{ __('messages.select_company') }}</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Files & Media -->
            <h3
                style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                {{ __('messages.files_media') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div
                    style="background: var(--nav-bg); padding: 1.5rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                    <x-input-label for="photo_path" :value="__('messages.contact_photo')" />
                    <input id="photo_path" type="file" name="photo_path" accept="image/*"
                        style="color: var(--text-color);"
                        class="block mt-2 w-full text-sm file:{{ app()->getLocale() == 'ar' ? 'ml' : 'mr' }}-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[var(--accent-bg)] file:text-[var(--accent-text)] hover:file:opacity-80" />
                    <p style="opacity: 0.7; font-size: 0.75rem; margin-top: 0.5rem;">
                        {{ __('messages.max_size_hint') }}
                    </p>
                </div>
                <div
                    style="background: var(--nav-bg); padding: 1.5rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                    <x-input-label for="papers" :value="__('messages.contact_papers')" />
                    <input id="papers" type="file" name="papers[]" accept=".pdf" multiple
                        style="color: var(--text-color);"
                        class="block mt-2 w-full text-sm file:{{ app()->getLocale() == 'ar' ? 'ml' : 'mr' }}-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[var(--accent-bg)] file:text-[var(--accent-text)] hover:file:opacity-80" />
                    <p style="opacity: 0.7; font-size: 0.75rem; margin-top: 0.5rem;">
                        {{ __('messages.max_files_hint') }}
                    </p>
                </div>
            </div>

            <!-- Address -->
            <h3
                style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                {{ __('messages.address') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <x-input-label for="address_country_id" :value="__('messages.country')" />
                    <select id="address_country_id" name="address_country_id" x-model="addressCountryId"
                        style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                        class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                        <option value="">{{ __('messages.select_country') }}</option>
                        <template x-for="country in countries" :key="country.id">
                            <option :value="country.id" x-text="country['name_' + '{{ app()->getLocale() }}']"></option>
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
                            <option :value="city.id" x-text="city['name_' + '{{ app()->getLocale() }}']">
                            </option>
                        </template>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="address_street" :value="__('messages.street_address')" />
                    <x-text-input id="address_street" class="block mt-1 w-full" type="text" name="address_street" />
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-end gap-3 mt-10">
                <button type="submit"
                    style="color: var(--btn-text); background: var(--btn-bg); padding: 0.8rem 2.5rem; border-radius: 40px; font-weight: 600; border: 1px solid var(--btn-border); cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); width: 100%;"
                    onmouseover="this.style.background='var(--btn-hover-bg)'; this.style.transform='translateY(-2px)';"
                    onmouseout="this.style.background='var(--btn-bg)'; this.style.transform='translateY(0)';"
                    class="focus:outline-none focus:shadow-outline sm:w-auto">
                    {{ __('messages.create_contact') }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function contactForm(countriesData) {
            return {
                countries: countriesData,
                nationalityId: 1, // Default to Egypt (ID 1)
                addressCountryId: 1, // Default to Egypt (ID 1)

                get isEgyptian() {
                    // Check if selected nationality corresponds to Egypt (assuming ID 1 is Egypt as per seeder)
                    return this.nationalityId == 1;
                },

                get availableCities() {
                    if (!this.addressCountryId) return [];
                    const country = this.countries.find(c => c.id == this.addressCountryId);
                    return country ? country.cities : [];
                },

                init() {
                    // Initialize if needed
                }
            }
        }
    </script>
</x-app-layout>