<x-app-layout>
    <x-slot name="header">{{ __('messages.companies') }}</x-slot>

    <div>
        <div class="flex justify-between items-center mb-6">
            <h3
                style="font-size: 1.5rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.4rem;">
                {{ __('messages.all_companies') }}
            </h3>
            <div class="flex gap-3">
                <a href="{{ route('clients.kanban') }}" title="{{ __('messages.kanban_view') }}"
                    style="color: var(--btn-text); font-size: 1.4rem; transition: all 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">📊</a>
                <a href="{{ route('clients.create') }}" title="{{ __('messages.add_client') }}"
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

        {{-- ── MOBILE: Card list (hidden on sm+) ── --}}
        <div class="sm:hidden space-y-3">
            @forelse ($clients as $client)
                <div
                    style="background: var(--content-bg); border: 1px solid var(--row-border); border-radius: 1.25rem; padding: 1rem; box-shadow: var(--card-shadow);">
                    <div class="flex items-center gap-3">
                        @if($client->logo_path)
                            <img src="{{ asset('storage/' . $client->logo_path) }}" alt="Logo"
                                style="height: 44px; width: 44px; border-radius: 0.75rem; border: 2px solid var(--table-border); object-fit: cover; flex-shrink: 0;">
                        @else
                            <div
                                style="height: 44px; width: 44px; border-radius: 0.75rem; background: var(--nav-bg); border: 1px solid var(--table-border); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-weight: bold; font-size: 1rem; flex-shrink: 0;">
                                {{ substr($client->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('clients.show', $client) }}"
                                style="color: var(--text-color); font-weight: 600; text-decoration: none; font-size: 1rem;"
                                class="truncate block hover:underline">
                                {{ $client->name }}
                            </a>
                            <span
                                style="background: var(--badge-bg); padding: 0.1rem 0.5rem; border-radius: 10px; border: 1px solid var(--badge-border); font-size: 0.75rem;">
                                {{ $client->industry ? (app()->getLocale() == 'ar' ? $client->industry->name_ar : $client->industry->name_en) : __('messages.general') }}
                            </span>
                        </div>
                        <div class="flex gap-3 flex-shrink-0 items-center">
                            <a href="{{ route('clients.show', $client) }}" style="font-size: 1.2rem;">👁️</a>
                            <a href="{{ route('clients.edit', $client) }}" style="font-size: 1.2rem;">✏️</a>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('{{ __('messages.are_you_sure') }}');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="font-size: 1.2rem; border: none; background: none; cursor: pointer;" title="{{ __('messages.delete') }}">🗑️</button>
                            </form>
                        </div>
                    </div>
                    @if($client->email || $client->phone)
                        <div class="mt-2 pl-14 text-sm" style="color: var(--text-color); opacity: 0.75;">
                            @if($client->email)
                            <div>{{ $client->email }}</div>@endif
                            @if($client->phone)
                            <div>{{ $client->phone }}</div>@endif
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-center py-8 opacity-50">{{ __('messages.no_data') ?? 'No companies yet.' }}</p>
            @endforelse
        </div>

        {{-- ── DESKTOP: Table (hidden on mobile) ── --}}
        <div class="hidden sm:block"
            style="background: var(--content-bg); border-radius: 2rem; padding: 1.5rem; border: 1px solid var(--content-border); overflow: hidden; box-shadow: var(--card-shadow);">
            <div class="overflow-x-auto">
                <table class="min-w-full" style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr style="background: var(--table-header-bg); color: var(--table-header-color);">
                            <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border); border-radius: {{ app()->getLocale() == 'ar' ? '0 1.5rem 1.5rem 0' : '1.5rem 0 0 1.5rem' }};">
                                {{ __('messages.logo') }}
                            </th>
                            <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                                {{ __('messages.name') }}
                            </th>
                            <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                                {{ __('messages.industry') }}
                            </th>
                            <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                                {{ __('messages.contact_info') }}
                            </th>
                            <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border); border-radius: {{ app()->getLocale() == 'ar' ? '1.5rem 0 0 1.5rem' : '0 1.5rem 1.5rem 0' }};">
                                {{ __('messages.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr style="border-bottom: 1px solid var(--row-border); transition: background 0.2s;"
                                onmouseover="this.style.background='var(--row-hover-bg)';"
                                onmouseout="this.style.background='transparent';">
                                <td class="py-4 px-4" style="border-bottom: 1px solid var(--row-border);">
                                    @if($client->logo_path)
                                        <img src="{{ asset('storage/' . $client->logo_path) }}" alt="Logo"
                                            style="height: 40px; width: 40px; border-radius: 0.75rem; border: 2px solid var(--table-border); object-fit: cover;">
                                    @else
                                        <div
                                            style="height: 40px; width: 40px; border-radius: 0.75rem; background: var(--nav-bg); border: 1px solid var(--table-border); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-weight: bold; font-size: 1rem;">
                                            {{ substr($client->name, 0, 1) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4" style="border-bottom: 1px solid var(--row-border);">
                                    <a href="{{ route('clients.show', $client) }}"
                                        style="color: var(--text-color); font-weight: 600; text-decoration: none;"
                                        class="hover:underline">
                                        {{ $client->name }}
                                    </a>
                                </td>
                                <td class="py-4 px-4"
                                    style="border-bottom: 1px solid var(--row-border); color: var(--text-color); font-size: 0.9rem;">
                                    <span
                                        style="background: var(--badge-bg); padding: 0.2rem 0.6rem; border-radius: 12px; border: 1px solid var(--badge-border);">
                                        {{ $client->industry ? (app()->getLocale() == 'ar' ? $client->industry->name_ar : $client->industry->name_en) : __('messages.general') }}
                                    </span>
                                </td>
                                <td class="py-4 px-4" style="border-bottom: 1px solid var(--row-border);">
                                    <div style="font-size: 0.85rem; color: var(--text-color);">{{ $client->email }}</div>
                                    <div style="font-size: 0.85rem; opacity: 0.8;">{{ $client->phone }}</div>
                                </td>
                                <td class="py-4 px-4 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"
                                    style="border-bottom: 1px solid var(--row-border);">
                                    <div
                                        class="flex {{ app()->getLocale() == 'ar' ? 'justify-start' : 'justify-end' }} gap-4 items-center">
                                        <a href="{{ route('clients.show', $client) }}" title="{{ __('messages.view') }}"
                                            style="color: var(--btn-text); font-size: 1.2rem; transition: transform 0.2s;"
                                            onmouseover="this.style.transform='scale(1.2)';"
                                            onmouseout="this.style.transform='scale(1)';" class="flex items-center">👁️</a>
                                        <a href="{{ route('clients.edit', $client) }}" title="{{ __('messages.edit') }}"
                                            style="color: var(--btn-text); font-size: 1.2rem; transition: transform 0.2s;"
                                            onmouseover="this.style.transform='scale(1.2)';"
                                            onmouseout="this.style.transform='scale(1)';" class="flex items-center">✏️</a>
                                        <form action="{{ route('clients.destroy', $client) }}" method="POST"
                                            onsubmit="return confirm('{{ __('messages.are_you_sure') }}');" class="inline m-0 p-0 flex items-center">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="{{ __('messages.delete') }}"
                                                style="color: var(--btn-text); font-size: 1.2rem; border: none; cursor: pointer; transition: transform 0.2s; background: none; padding: 0;"
                                                onmouseover="this.style.transform='scale(1.2)';"
                                                onmouseout="this.style.transform='scale(1)';" class="flex items-center">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($clients->hasPages())
                <div class="mt-6" style="border-top: 1px solid var(--row-border); padding-top: 1.5rem;">
                    {{ $clients->links() }}
                </div>
            @endif
        </div>

        {{-- Mobile pagination --}}
        @if($clients->hasPages())
            <div class="sm:hidden mt-4">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</x-app-layout>