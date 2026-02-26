<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $deal->title }}
        </h2>
    </x-slot>

    <div>
        <div class="flex justify-end mb-4">
            <a href="{{ route('deals.index') }}" title="{{ __('messages.back_to_list') }}"
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
                    <div
                        style="height: 80px; width: 80px; border-radius: 1.5rem; background: var(--bg-color); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-size: 2rem; border: 2px solid var(--nav-border); box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);">
                        💰
                    </div>
                    <div>
                        <h3 class="text-3xl font-light" style="color: var(--title-color); letter-spacing: -0.01em;">
                            {{ $deal->title }}
                        </h3>
                        <div class="flex items-center gap-3 mt-2">
                            @php
                                $statusStyles = [
                                    'won' => ['bg' => '#e6f4ea', 'text' => '#137333', 'border' => '#ceead6'],
                                    'lost' => ['bg' => '#fce8e6', 'text' => '#c5221f', 'border' => '#fad2cf'],
                                    'negotiation' => ['bg' => '#fef7e0', 'text' => '#b06000', 'border' => '#feefc3'],
                                    'proposal' => ['bg' => '#e8f0fe', 'text' => '#1967d2', 'border' => '#d2e3fc'],
                                    'default' => ['bg' => 'var(--badge-bg)', 'text' => 'var(--text-color)', 'border' => 'var(--badge-border)'],
                                ];
                                $style = $statusStyles[$deal->status] ?? $statusStyles['default'];
                            @endphp
                            <span
                                style="background: {{ $style['bg'] }}; color: {{ $style['text'] }}; border: 1px solid {{ $style['border'] }}; padding: 0.2rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">
                                {{ __('messages.' . $deal->status) }}
                            </span>
                            <span style="color: var(--text-color); font-weight: 500;">
                                {{ __('messages.for_company', ['company' => '']) }} <a
                                    href="{{ route('clients.show', $deal->company) }}"
                                    style="color: var(--accent-border); text-decoration: underline;">{{ $deal->company->name }}</a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('deals.edit', $deal) }}" title="{{ __('messages.edit_deal') }}"
                        style="color: var(--btn-text); font-size: 1.5rem; transition: transform 0.2s;"
                        onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                        class="flex items-center">
                        ✏️
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
                style="background: var(--content-bg); border-radius: 2rem; padding: 2rem; border: 1px solid var(--content-border);">
                <h4
                    style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                    {{ __('messages.financial_details') }}
                </h4>
                <div
                    style="background: var(--nav-bg); padding: 1.5rem; border-radius: 2rem; border: 1px solid var(--nav-border); text-align: center;">
                    <p
                        style="font-size: 0.9rem; opacity: 0.7; text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem;">
                        {{ __('messages.total_value') }}
                    </p>
                    <p style="font-size: 2.5rem; color: var(--text-color); font-weight: 800;">
                        ${{ number_format($deal->value, 2) }}</p>
                </div>
            </div>

            <div
                style="background: var(--content-bg); border-radius: 2rem; padding: 2rem; border: 1px solid var(--content-border);">
                <h4
                    style="font-size: 1.5rem; color: var(--title-color); border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem; margin-bottom: 1.5rem; font-weight: 350;">
                    {{ __('messages.activities') }}
                </h4>
                <div class="flex flex-col items-center justify-center py-8">
                    <span style="font-size: 3rem; opacity: 0.2;">📝</span>
                    <p style="opacity: 0.6; font-style: italic; margin-top: 1rem;">
                        {{ __('messages.no_activities_logged') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>