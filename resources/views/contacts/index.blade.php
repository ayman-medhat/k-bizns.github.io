<x-app-layout>
    <x-slot name="header">{{ __('messages.contacts') }}</x-slot>

    <div>
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-light" style="color: var(--title-color);">{{ __('messages.all_contacts') }}</h3>
            <div class="flex gap-3">
                <a href="{{ route('contacts.kanban') }}" title="{{ __('messages.kanban_view') }}"
                    style="color: var(--btn-text); font-size: 1.4rem; transition: all 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">📊</a>
                <a href="{{ route('contacts.create') }}" title="{{ __('messages.add_contact') }}"
                    style="color: var(--btn-text); font-size: 1.6rem; transition: all 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">➕</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div
                style="background: #f0f7f0; border: 1px solid #c3e6cb; color: #155724; padding: 1rem; border-radius: 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>✅</span> {{ $message }}
            </div>
        @endif

        {{-- ── MOBILE: Card list ── --}}
        <div class="sm:hidden space-y-3">
            @forelse ($contacts as $contact)
                @php
                    $fullName = app()->getLocale() == 'ar'
                        ? ($contact->first_name_ar . ' ' . $contact->last_name_ar)
                        : ($contact->first_name_en . ' ' . $contact->last_name_en);
                @endphp
                <div
                    style="background: var(--content-bg); border: 1px solid var(--row-border); border-radius: 1.25rem; padding: 1rem; box-shadow: var(--card-shadow);">
                    <div class="flex items-center gap-3">
                        @if($contact->photo_path)
                            <img src="{{ asset('storage/' . $contact->photo_path) }}" alt="Avatar"
                                style="width: 44px; height: 44px; border-radius: 12px; border: 1px solid var(--table-border); object-fit: cover; flex-shrink: 0;">
                        @else
                            <div
                                style="width: 44px; height: 44px; border-radius: 12px; background: var(--nav-bg); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; border: 1px solid var(--table-border); flex-shrink: 0;">
                                👤</div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('contacts.show', $contact) }}"
                                style="color: var(--text-color); font-weight: 600; text-decoration: none;"
                                class="block truncate hover:underline">
                                {{ $fullName }}
                            </a>
                            @if($contact->company)
                                <span style="font-size: 0.8rem; opacity: 0.7;">{{ $contact->company->name }}</span>
                            @endif
                        </div>
                        <div class="flex gap-3 flex-shrink-0">
                            <a href="{{ route('contacts.show', $contact) }}" style="font-size: 1.2rem;">👁️</a>
                            <a href="{{ route('contacts.edit', $contact) }}" style="font-size: 1.2rem;">✏️</a>
                        </div>
                    </div>
                    <div class="mt-2 pl-14 text-sm space-y-0.5" style="color: var(--text-color); opacity: 0.75;">
                        @if($contact->email)
                        <div>✉️ {{ $contact->email }}</div>@endif
                        @if($contact->full_phone)
                        <div>📞 {{ $contact->full_phone }}</div>@endif
                    </div>
                </div>
            @empty
                <p class="text-center py-8 opacity-50">{{ __('messages.no_data') ?? 'No contacts yet.' }}</p>
            @endforelse
        </div>

        {{-- ── DESKTOP: Table ── --}}
        <div class="hidden sm:block"
            style="background: var(--content-bg); border-radius: 2rem; padding: 1.5rem; border: 1px solid var(--content-border); overflow: hidden; box-shadow: var(--card-shadow);">
            <table class="min-w-full" style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background: var(--table-header-bg); color: var(--table-header-color);">
                        <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                            style="font-weight: 550; border-bottom: 2px solid var(--table-border); border-radius: {{ app()->getLocale() == 'ar' ? '0 1.5rem 1.5rem 0' : '1.5rem 0 0 1.5rem' }};">
                            {{ __('messages.avatar') }}
                        </th>
                        <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                            style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                            {{ __('messages.name') }}</th>
                        <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                            style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                            {{ __('messages.email') }}</th>
                        <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                            style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                            {{ __('messages.phone') }}</th>
                        <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                            style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                            {{ __('messages.company') }}</th>
                        <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"
                            style="font-weight: 550; border-bottom: 2px solid var(--table-border); border-radius: {{ app()->getLocale() == 'ar' ? '1.5rem 0 0 1.5rem' : '0 1.5rem 1.5rem 0' }};">
                            {{ __('messages.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr style="border-bottom: 1px solid var(--row-border); transition: background 0.2s;"
                            onmouseover="this.style.background='var(--row-hover-bg)';"
                            onmouseout="this.style.background='transparent';">
                            <td class="py-3 px-4" style="border-bottom: 1px solid var(--row-border);">
                                @if($contact->photo_path)
                                    <img src="{{ asset('storage/' . $contact->photo_path) }}" alt="Avatar"
                                        style="width: 40px; height: 40px; border-radius: 12px; border: 1px solid var(--table-border); object-fit: cover;">
                                @else
                                    <div
                                        style="width: 40px; height: 40px; border-radius: 12px; background: var(--nav-bg); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-size: 1.2rem; border: 1px solid var(--table-border);">
                                        👤</div>
                                @endif
                            </td>
                            <td class="py-3 px-4"
                                style="color: var(--text-color); font-weight: 600; border-bottom: 1px solid var(--row-border);">
                                <a href="{{ route('contacts.show', $contact) }}"
                                    style="text-decoration: none; color: inherit;" class="hover:underline">
                                    {{ app()->getLocale() == 'ar' ? ($contact->first_name_ar . ' ' . $contact->last_name_ar) : ($contact->first_name_en . ' ' . $contact->last_name_en) }}
                                </a>
                            </td>
                            <td class="py-3 px-4"
                                style="color: var(--text-color); border-bottom: 1px solid var(--row-border); opacity: 0.9;">
                                {{ $contact->email }}</td>
                            <td class="py-3 px-4"
                                style="color: var(--text-color); border-bottom: 1px solid var(--row-border); opacity: 0.9;">
                                {{ $contact->full_phone }}</td>
                            <td class="py-3 px-4" style="border-bottom: 1px solid var(--row-border);">
                                @if($contact->company)
                                    <a href="{{ route('clients.show', $contact->company) }}"
                                        style="color: var(--title-color); text-decoration: underline; opacity: 0.8;"
                                        onmouseover="this.style.opacity='1';"
                                        onmouseout="this.style.opacity='0.8';">{{ $contact->company->name }}</a>
                                @else
                                    <span style="opacity: 0.5;">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"
                                style="border-bottom: 1px solid var(--row-border);">
                                <div class="flex {{ app()->getLocale() == 'ar' ? 'justify-start' : 'justify-end' }} gap-4">
                                    <a href="{{ route('contacts.show', $contact) }}" title="{{ __('messages.view') }}"
                                        style="color: var(--btn-text); font-size: 1.2rem; transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.2)';"
                                        onmouseout="this.style.transform='scale(1)';" class="flex items-center">👁️</a>
                                    <a href="{{ route('contacts.edit', $contact) }}" title="{{ __('messages.edit') }}"
                                        style="color: var(--btn-text); font-size: 1.2rem; transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.2)';"
                                        onmouseout="this.style.transform='scale(1)';" class="flex items-center">✏️</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $contacts->links() }}</div>
    </div>
</x-app-layout>