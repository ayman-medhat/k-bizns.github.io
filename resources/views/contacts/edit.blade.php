<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.edit_contact') }}
        </h2>
    </x-slot>

    <div x-data="contactForm({{ $countries }}, {{ $contact->nationality_id ?? 'null' }}, {{ $contact->address ? $contact->address->country_id : 'null' }})">
        <div class="flex justify-end mb-4">
            <a href="{{ route('contacts.index') }}" title="{{ __('messages.back_to_list') }}"
                style="color: var(--btn-text); font-size: 1.6rem; transition: all 0.2s;"
                onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                class="flex items-center">⬅️
            </a>
        </div>

        <form action="{{ route('contacts.update', $contact) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Personal Info -->
                        <h3
                            style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                            {{ __('messages.edit_personal_information') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <x-input-label for="first_name_en" :value="__('messages.first_name_en')" />
                                <x-text-input id="first_name_en" class="block mt-1 w-full" type="text"
                                    name="first_name_en" :value="old('first_name_en', $contact->first_name_en)"
                                    required />
                            </div>
                            <div>
                                <x-input-label for="last_name_en" :value="__('messages.last_name_en')" />
                                <x-text-input id="last_name_en" class="block mt-1 w-full" type="text"
                                    name="last_name_en" :value="old('last_name_en', $contact->last_name_en)" />
                            </div>
                            <div class="{{ app()->getLocale() == 'ar' ? '' : 'text-right' }}" dir="rtl">
                                <x-input-label for="first_name_ar" :value="__('messages.first_name_ar')" />
                                <x-text-input id="first_name_ar" class="block mt-1 w-full text-right" type="text"
                                    name="first_name_ar" :value="old('first_name_ar', $contact->first_name_ar)" />
                            </div>
                            <div class="{{ app()->getLocale() == 'ar' ? '' : 'text-right' }}" dir="rtl">
                                <x-input-label for="last_name_ar" :value="__('messages.last_name_ar')" />
                                <x-text-input id="last_name_ar" class="block mt-1 w-full text-right" type="text"
                                    name="last_name_ar" :value="old('last_name_ar', $contact->last_name_ar)" />
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
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email', $contact->email)" />
                            </div>
                            <div>
                                <x-input-label for="phone" :value="__('messages.phone_number')" />
                                <div class="flex mt-1">
                                    <select name="phone_country_id"
                                        style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: {{ app()->getLocale() == 'ar' ? '0 0.75rem 0.75rem 0' : '0.75rem 0 0 0.75rem' }}; color: var(--text-color); width: 35%;"
                                        class="focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                                        <option value="">{{ __('messages.code') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ $contact->phone_country_id == $country->id ? 'selected' : '' }}>
                                                {{ $country->phone_code }}
                                                ({{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-text-input id="phone"
                                        style="border-radius: {{ app()->getLocale() == 'ar' ? '0.75rem 0 0 0.75rem' : '0 0.75rem 0.75rem 0' }}; width: 65%; border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: none;"
                                        class="block" type="text" name="phone" :value="old('phone', $contact->phone)" />
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
                                        <option :value="country.id"
                                            x-text="country['nationality_' + '{{ app()->getLocale() }}']"
                                            :selected="country.id == nationalityId"></option>
                                    </template>
                                </select>
                            </div>
                            <div x-show="isEgyptian">
                                <x-input-label for="national_id" :value="__('messages.national_id')" />
                                <x-text-input id="national_id" class="block mt-1 w-full" type="text" name="national_id"
                                    :value="old('national_id', $contact->national_id)" />
                            </div>
                            <div x-show="!isEgyptian">
                                <x-input-label for="passport_no" :value="__('messages.passport_number')" />
                                <x-text-input id="passport_no" class="block mt-1 w-full" type="text" name="passport_no"
                                    :value="old('passport_no', $contact->passport_no)" />
                            </div>
                            <div>
                                <x-input-label for="birthdate" :value="__('messages.birthdate')" />
                                <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate"
                                    :value="old('birthdate', $contact->birthdate ? $contact->birthdate->format('Y-m-d') : '')" />
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
                                    :value="old('category', $contact->category)" placeholder="e.g. VIP, Lead, Client" />
                            </div>
                            <div>
                                <x-input-label for="client_id" :value="__('messages.assign_company')" />
                                <select id="client_id" name="client_id"
                                    style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                                    class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                                    <option value="">{{ __('messages.select_company') }}</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ $contact->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Company selection for Super Admin -->
                        @if(auth()->user()->hasRole('Super Admin'))
                        <h3
                            style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                            {{ __('messages.company_assignment') ?? __('Company Assignment') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <x-input-label for="company_id" :value="__('messages.company') ?? __('Company')" />
                                <select name="company_id" id="company_id" required
                                    style="background: var(--nav-bg); border-color: var(--nav-border); border-radius: 0.75rem; color: var(--text-color);"
                                    class="block mt-1 w-full focus:border-[var(--accent-border)] focus:ring-[var(--accent-border)]">
                                    <option value="">{{ __('messages.select_company') ?? __('Select Company') }}</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $contact->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        <!-- Files & Media -->
                        <h3
                            style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                            {{ __('messages.files_media') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div
                                style="background: var(--nav-bg); padding: 1.5rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                                <x-input-label for="photo_path" :value="__('messages.contact_photo')" />
                                @if($contact->photo_path)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $contact->photo_path) }}" alt="Current Photo"
                                            style="height: 80px; width: 80px; border-radius: 1rem; object-fit: cover; border: 2px solid var(--accent-border);">
                                        <p
                                            style="font-size: 0.8rem; opacity: 0.7; font-style: italic; margin-top: 0.25rem;">
                                            {{ __('messages.current_photo') }}
                                        </p>
                                    </div>
                                @endif
                                <input id="photo_path" type="file" name="photo_path" accept="image/*"
                                    style="color: var(--text-color);"
                                    class="block mt-2 w-full text-sm file:{{ app()->getLocale() == 'ar' ? 'ml' : 'mr' }}-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[var(--accent-bg)] file:text-[var(--accent-text)] hover:file:opacity-80" />
                                <p style="opacity: 0.7; font-size: 0.75rem; margin-top: 0.5rem;">
                                    {{ __('messages.max_size_hint') }}
                                </p>
                            </div>
                            <div
                                style="background: var(--nav-bg); padding: 1.5rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                                <x-input-label for="papers" :value="__('messages.add_more_papers')" />
                                @if($contact->papers->count() > 0)
                                    <p style="opacity: 0.7; font-size: 0.85rem; margin-bottom: 0.5rem;">
                                        {{ __('messages.current_documents', ['count' => $contact->papers->count()]) }}
                                    </p>
                                @endif
                                <input id="papers" type="file" name="papers[]" accept=".pdf" multiple
                                    style="color: var(--text-color);"
                                    class="block mt-2 w-full text-sm file:{{ app()->getLocale() == 'ar' ? 'ml' : 'mr' }}-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[var(--accent-bg)] file:text-[var(--accent-text)] hover:file:opacity-80" />
                                <p style="opacity: 0.7; font-size: 0.75rem; margin-top: 0.5rem;">
                                    {{ __('messages.max_files_hint') }}
                                </p>
                            </div>
                        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-3 mt-10">
            <button type="submit"
                style="color: var(--btn-text); background: var(--btn-bg); padding: 0.8rem 2.5rem; border-radius: 40px; font-weight: 600; border: 1px solid var(--btn-border); cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); width: 100%;"
                onmouseover="this.style.background='var(--btn-hover-bg)'; this.style.transform='translateY(-2px)';"
                onmouseout="this.style.background='var(--btn-bg)'; this.style.transform='translateY(0)';"
                class="focus:outline-none focus:shadow-outline sm:w-auto">
                {{ __('messages.update_contact') }}
            </button>
        </div>
    </form>
</div>

    <script>
        function contactForm(countriesData, initialNationality, initialAddressCountry) {
            return {
                countries: countriesData,
                nationalityId: initialNationality || 1,
                addressCountryId: initialAddressCountry,

                get isEgyptian() {
                    return this.nationalityId == 1;
                },

                get availableCities() {
                    if (!this.addressCountryId) return [];
                    const country = this.countries.find(c => c.id == this.addressCountryId);
                    return country ? country.cities : [];
                }
            }
        }
    </script>
</x-app-layout>