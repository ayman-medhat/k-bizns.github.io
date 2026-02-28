<x-app-layout>
    <x-slot name="header">
        {{ __('messages.subscription_plans') }}
    </x-slot>

    <div>
        <div class="flex justify-between items-center mb-6">
            <h3
                style="font-size: 1.5rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.4rem;">
                {{ __('messages.subscription_plans') }}
            </h3>
            <div class="flex gap-3">
                <a href="{{ route('super-admin.plans.create') }}" title="{{ __('messages.create_plan') }}"
                    style="color: var(--btn-text); font-size: 1.6rem; transition: all 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">➕</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($plans as $plan)
                <div class="glass-card p-6 space-y-4 flex flex-col"
                    style="background: var(--content-bg); border: 1px solid var(--row-border); border-radius: 1.5rem; box-shadow: var(--card-shadow);">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-bold" style="color: var(--text-color);">{{ $plan->name }}</h2>
                            <p class="text-2xl font-bold mt-2" style="color: var(--accent-text);">
                                ${{ $plan->price }}
                                <span class="text-sm font-normal opacity-60">/ {{ $plan->interval }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex-grow space-y-4">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider opacity-60 mb-2"
                                style="color: var(--text-color);">{{ __('messages.limits') }}</h3>
                            <ul class="text-sm space-y-1.5" style="color: var(--text-color);">
                                @foreach ($plan->limits as $key => $value)
                                    <li class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[var(--accent-text)] opacity-40"></span>
                                        <span class="capitalize opacity-80">{{ str_replace('_', ' ', $key) }}:</span>
                                        <span class="font-semibold">{{ $value }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if ($plan->features)
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider opacity-60 mb-2"
                                    style="color: var(--text-color);">{{ __('messages.features') }}</h3>
                                <ul class="text-sm space-y-1.5" style="color: var(--text-color);">
                                    @foreach ($plan->features as $feature)
                                        <li class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="opacity-90">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t" style="border-color: var(--row-border);">
                        <a href="{{ route('super-admin.plans.edit', $plan) }}"
                            style="color: var(--accent-text); background: var(--accent-bg); display: block; text-align: center; padding: 0.6rem; border-radius: 1rem; font-weight: 500; border: 1px solid var(--accent-border);"
                            class="hover:opacity-80 transition-opacity">
                            {{ __('messages.edit_plan') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>