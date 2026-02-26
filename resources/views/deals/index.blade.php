<x-app-layout>
    <x-slot name="header">{{ __('messages.deals') }}</x-slot>

    <div>
        <div class="flex justify-between items-center mb-6">
            <h3
                style="font-size: 1.5rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.4rem;">
                {{ __('messages.all_deals') }}
            </h3>
            <div class="flex gap-3">
                <a href="{{ route('deals.kanban') }}" title="{{ __('messages.kanban') }}"
                    style="color: var(--btn-text); font-size: 1.4rem; transition: transform 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">📋</a>
                <a href="{{ route('deals.create') }}" title="{{ __('messages.add_deal') }}"
                    style="color: var(--btn-text); font-size: 1.6rem; transition: transform 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">➕</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div
                style="background: #f0f7f0; border: 1px solid #c3e6cb; color: #155724; padding: 1rem; border-radius: 1.5rem; margin-bottom: 1.5rem;">
                ✅ {{ $message }}
            </div>
        @endif

        @php
            $statusStyles = [
                'won' => ['bg' => '#e6f4ea', 'text' => '#137333', 'border' => '#ceead6'],
                'lost' => ['bg' => '#fce8e6', 'text' => '#c5221f', 'border' => '#fad2cf'],
                'negotiation' => ['bg' => '#fef7e0', 'text' => '#b06000', 'border' => '#feefc3'],
                'proposal' => ['bg' => '#e8f0fe', 'text' => '#1967d2', 'border' => '#d2e3fc'],
                'default' => ['bg' => '#f1f3f4', 'text' => '#3c4043', 'border' => '#dadce0'],
            ];
        @endphp

        {{-- ── MOBILE: Card list ── --}}
        <div class="sm:hidden space-y-3">
            @forelse ($deals as $deal)
                @php $style = $statusStyles[$deal->status] ?? $statusStyles['default']; @endphp
                <div
                    style="background: var(--content-bg); border: 1px solid var(--row-border); border-radius: 1.25rem; padding: 1rem; box-shadow: var(--card-shadow);">
                    <div class="flex items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('deals.show', $deal) }}"
                                style="color: var(--text-color); font-weight: 600; text-decoration: none; font-size: 1rem;"
                                class="block truncate hover:underline">
                                {{ $deal->title }}
                            </a>
                            <div class="flex items-center gap-2 mt-1 flex-wrap">
                                <span style="font-size: 0.8rem; opacity: 0.7;">{{ $deal->company->name }}</span>
                                <span
                                    style="background: {{ $style['bg'] }}; color: {{ $style['text'] }}; border: 1px solid {{ $style['border'] }}; padding: 0.1rem 0.5rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase;">
                                    {{ __('messages.' . $deal->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-right">
                            <div style="font-weight: 700; color: var(--title-color);">${{ number_format($deal->value, 0) }}
                            </div>
                            <div class="flex gap-3 mt-1">
                                <a href="{{ route('deals.show', $deal) }}" style="font-size: 1.1rem;">👁️</a>
                                <a href="{{ route('deals.edit', $deal) }}" style="font-size: 1.1rem;">✏️</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center py-8 opacity-50">{{ __('messages.no_data') ?? 'No deals yet.' }}</p>
            @endforelse
        </div>

        {{-- ── DESKTOP: Table ── --}}
        <div class="hidden sm:block"
            style="background: var(--content-bg); border-radius: 2rem; padding: 1.5rem; border: 1px solid var(--content-border); overflow: hidden; box-shadow: var(--card-shadow);">
            <div class="overflow-x-auto">
                <table class="min-w-full" style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr style="background: var(--table-header-bg); color: var(--table-header-color);">
                            <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border); border-radius: {{ app()->getLocale() == 'ar' ? '0 1.5rem 1.5rem 0' : '1.5rem 0 0 1.5rem' }};">
                                {{ __('messages.title') }}
                            </th>
                            <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                                {{ __('messages.company') }}</th>
                            <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                                {{ __('messages.value') }}</th>
                            <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                                {{ __('messages.status') }}</th>
                            <th class="py-3 px-4 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border); border-radius: {{ app()->getLocale() == 'ar' ? '1.5rem 0 0 1.5rem' : '0 1.5rem 1.5rem 0' }};">
                                {{ __('messages.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deals as $deal)
                            @php $style = $statusStyles[$deal->status] ?? $statusStyles['default']; @endphp
                            <tr style="border-bottom: 1px solid var(--row-border); transition: background 0.2s;"
                                onmouseover="this.style.background='var(--row-hover-bg)';"
                                onmouseout="this.style.background='transparent';">
                                <td class="py-4 px-4" style="border-bottom: 1px solid var(--row-border);">
                                    <a href="{{ route('deals.show', $deal) }}"
                                        style="color: var(--text-color); font-weight: 600; text-decoration: none;"
                                        class="hover:underline">{{ $deal->title }}</a>
                                </td>
                                <td class="py-4 px-4" style="border-bottom: 1px solid var(--row-border);">
                                    <a href="{{ route('clients.show', $deal->company) }}"
                                        style="color: var(--title-color); text-decoration: none; opacity: 0.8;"
                                        class="hover:underline">{{ $deal->company->name }}</a>
                                </td>
                                <td class="py-4 px-4"
                                    style="border-bottom: 1px solid var(--row-border); color: var(--text-color); font-weight: 500;">
                                    ${{ number_format($deal->value, 2) }}</td>
                                <td class="py-4 px-4" style="border-bottom: 1px solid var(--row-border);">
                                    <span
                                        style="background: {{ $style['bg'] }}; color: {{ $style['text'] }}; border: 1px solid {{ $style['border'] }}; padding: 0.2rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">
                                        {{ __('messages.' . $deal->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"
                                    style="border-bottom: 1px solid var(--row-border);">
                                    <div
                                        class="flex {{ app()->getLocale() == 'ar' ? 'justify-start' : 'justify-end' }} gap-4">
                                        <a href="{{ route('deals.show', $deal) }}" title="{{ __('messages.view') }}"
                                            style="color: var(--btn-text); font-size: 1.2rem; transition: transform 0.2s;"
                                            onmouseover="this.style.transform='scale(1.2)';"
                                            onmouseout="this.style.transform='scale(1)';" class="flex items-center">👁️</a>
                                        <a href="{{ route('deals.edit', $deal) }}" title="{{ __('messages.edit') }}"
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
            @if($deals->hasPages())
                <div class="mt-6" style="border-top: 1px solid var(--row-border); padding-top: 1.5rem;">
                    {{ $deals->links() }}
                </div>
            @endif
        </div>

        @if($deals->hasPages())
            <div class="sm:hidden mt-4">{{ $deals->links() }}</div>
        @endif
    </div>
</x-app-layout>