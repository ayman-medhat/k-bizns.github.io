<x-app-layout>
    <x-slot name="header">
        {{ __('messages.contact_details') }}
    </x-slot>

    <div>
        <div class="flex justify-end mb-4">
            <a href="{{ route('contacts.index') }}" title="{{ __('messages.back_to_list') }}"
                style="color: var(--btn-text); font-size: 1.8rem; transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.2)';"
                onmouseout="this.style.transform='scale(1)';" class="flex items-center">
                ⬅️
            </a>
        </div>

        <div
            style="background: var(--nav-bg); border-radius: 2rem; padding: 2rem; border: 1px solid var(--nav-border); box-shadow: var(--card-shadow); margin-bottom: 1.5rem;">
            <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                <div class="flex items-center gap-6">
                    @if($contact->photo_path)
                        <img src="{{ asset('storage/' . $contact->photo_path) }}" alt="{{ $contact->name }}"
                            style="height: 120px; width: 120px; border-radius: 2rem; border: 3px solid var(--accent-border); object-fit: cover; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);">
                    @else
                        <div
                            style="height: 120px; width: 120px; border-radius: 2rem; background: var(--bg-color); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-size: 3rem; border: 2px solid var(--nav-border); box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);">
                            {{ substr($contact->first_name_en, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="text-3xl font-light" style="color: var(--title-color); letter-spacing: -0.01em;">
                            {{ $contact->name }}</h3>
                        <p style="color: var(--text-color); opacity: 0.8; font-size: 1.25rem; margin-top: 0.25rem;"
                            dir="rtl">
                            {{ $contact->first_name_ar }} {{ $contact->last_name_ar }}
                        </p>
                        @if($contact->company)
                            <p style="margin-top: 0.5rem;">
                                <a href="{{ route('clients.show', $contact->company) }}"
                                    style="color: var(--title-color); font-weight: 500; text-decoration: underline;"
                                    onmouseover="this.style.opacity='0.7';" onmouseout="this.style.opacity='1';">
                                    🏢 {{ $contact->company->name }}
                                </a>
                            </p>
                        @endif
                        <span
                            style="display: inline-block; background: var(--badge-bg); padding: 0.3rem 1rem; border-radius: 40px; border: 1px solid var(--badge-border); color: var(--text-color); font-size: 0.85rem; margin-top: 0.75rem;">
                            {{ $contact->category ? (app()->getLocale() == 'ar' ? (__('messages.' . strtolower($contact->category)) != 'messages.' . strtolower($contact->category) ? __('messages.' . strtolower($contact->category)) : $contact->category) : $contact->category) : __('messages.general_contact') }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-4 items-center">
                    <a href="{{ route('contacts.edit', $contact) }}" title="{{ __('messages.edit_contact') }}"
                        style="color: var(--btn-text); font-size: 1.5rem; transition: transform 0.2s;"
                        onmouseover="this.style.transform='scale(1.2)';"
                        onmouseout="this.style.transform='scale(1)';" class="flex items-center">
                        ✏️
                    </a>
                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST"
                        onsubmit="return confirm('{{ __('messages.are_you_sure') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="{{ __('messages.delete') }}"
                            style="color: var(--btn-text); font-size: 1.5rem; border: none; cursor: pointer; transition: transform 0.2s; background: none;"
                            onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                            class="flex items-center">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Information Sections -->
            <div
                style="background: var(--content-bg); border-radius: 2rem; padding: 2rem; border: 1px solid var(--content-border);">
                <h4
                    style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                    {{ __('messages.contact_information') }}</h4>

                <div class="space-y-4">
                    <div
                        style="background: var(--nav-bg); padding: 0.8rem 1.2rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                        <p style="font-size: 0.75rem; opacity: 0.7; text-transform: uppercase; font-weight: 600;">{{ __('messages.email_address') }}</p>
                        <p style="color: var(--text-color); font-weight: 500;">{{ $contact->email }}</p>
                    </div>
                    <div
                        style="background: var(--nav-bg); padding: 0.8rem 1.2rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                        <p style="font-size: 0.75rem; opacity: 0.7; text-transform: uppercase; font-weight: 600;">{{ __('messages.phone_number') }}</p>
                        <p style="color: var(--text-color); font-weight: 500;">{{ $contact->full_phone }}</p>
                    </div>
                    <div
                        style="background: var(--nav-bg); padding: 0.8rem 1.2rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                        <p style="font-size: 0.75rem; opacity: 0.7; text-transform: uppercase; font-weight: 600;">
                            {{ __('messages.identification') }}</p>
                        <p style="color: var(--text-color); font-weight: 500;">
                            @if($contact->national_id)
                                {{ __('messages.national_id_label', ['id' => $contact->national_id]) }}
                            @elseif($contact->passport_no)
                                {{ __('messages.passport_label', ['no' => $contact->passport_no]) }}
                            @else
                                <span style="opacity: 0.5;">{{ __('messages.no_id_provided') }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div
                style="background: var(--content-bg); border-radius: 2rem; padding: 2rem; border: 1px solid var(--content-border);">
                <h4
                    style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                    {{ __('messages.additional_details') }}</h4>

                <div class="space-y-4">
                    <div
                        style="background: var(--nav-bg); padding: 0.8rem 1.2rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                        <p style="font-size: 0.75rem; opacity: 0.7; text-transform: uppercase; font-weight: 600;">
                            {{ __('messages.birthdate_age') }}</p>
                        <p style="color: var(--text-color); font-weight: 500;">
                            {{ $contact->birthdate ? $contact->birthdate->format('M d, Y') : __('messages.not_available') }}
                            @if($contact->detailed_age)
                                <span
                                    style="opacity: 0.7; font-size: 0.85rem; margin-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 0.5rem;">({{ $contact->detailed_age }})</span>
                            @endif
                        </p>
                    </div>
                    @if($contact->address)
                        <div
                            style="background: var(--nav-bg); padding: 0.8rem 1.2rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                            <p style="font-size: 0.75rem; opacity: 0.7; text-transform: uppercase; font-weight: 600;">
                                {{ __('messages.location') }}</p>
                            <p style="color: var(--text-color); font-weight: 500;">
                                {{ $contact->address->street }},
                                {{ $contact->address->city ? (app()->getLocale() == 'ar' ? $contact->address->city->name_ar : $contact->address->city->name_en) : '' }},
                                {{ $contact->address->country ? (app()->getLocale() == 'ar' ? $contact->address->country->name_ar : $contact->address->country->name_en) : '' }}
                            </p>
                        </div>
                    @endif
                    <div
                        style="background: var(--nav-bg); padding: 0.8rem 1.2rem; border-radius: 1.5rem; border: 1px solid var(--nav-border);">
                        <p style="font-size: 0.75rem; opacity: 0.7; text-transform: uppercase; font-weight: 600;">
                            {{ __('messages.nationality') }}</p>
                        <p style="color: var(--text-color); font-weight: 500;">
                            {{ $contact->nationality ? (app()->getLocale() == 'ar' ? $contact->nationality->nationality_ar : $contact->nationality->nationality_en) : __('messages.not_available') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Papers Section -->
        @if($contact->papers->count() > 0)
            <div
                style="margin-top: 1.5rem; background: var(--nav-bg); border-radius: 2rem; padding: 2rem; border: 1px solid var(--nav-border);">
                <h4
                    style="font-size: 1.5rem; color: var(--title-color); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; font-weight: 350;">
                    <span style="font-size: 2rem;">📄</span> {{ __('messages.documents_count', ['count' => $contact->papers->count()]) }}
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($contact->papers as $paper)
                        <a href="{{ asset('storage/' . $paper->file_path) }}" target="_blank"
                            style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: var(--content-bg); border-radius: 1.5rem; border: 1px solid var(--content-border); text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);"
                            onmouseover="this.style.transform='translateY(-2px)';"
                            onmouseout="this.style.transform='translateY(0)';" class="group">
                            <span
                                style="font-size: 2rem; background: var(--nav-bg); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 1rem; color: var(--text-color);">📑</span>
                            <div style="overflow: hidden;">
                                <p
                                    style="color: var(--text-color); font-weight: 600; font-size: 0.95rem; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                    {{ $paper->title }}</p>
                                <p style="opacity: 0.6; font-size: 0.75rem;">{{ __('messages.pdf_document') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>