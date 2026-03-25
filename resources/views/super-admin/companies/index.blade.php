<x-app-layout>
    <x-slot name="header">
        {{ __('messages.manage_companies') }}
    </x-slot>

    <div>
        <div class="flex justify-between items-center mb-6">
            <h3
                style="font-size: 1.5rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.4rem;">
                {{ __('messages.all_companies') }}
            </h3>
            <div class="flex gap-3">
                <a href="{{ route('super-admin.companies.create') }}" title="{{ __('messages.add_company') }}"
                    style="color: var(--btn-text); font-size: 1.6rem; transition: all 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">➕</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="glass-card overflow-hidden"
            style="background: var(--content-bg); border: 1px solid var(--row-border); border-radius: 1.5rem; box-shadow: var(--card-shadow);">
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--row-border); background: var(--nav-bg);">
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider"
                                style="color: var(--text-color); opacity: 0.7;">{{ __('messages.name') }}</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider"
                                style="color: var(--text-color); opacity: 0.7;">{{ __('messages.current_plan') }}</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider"
                                style="color: var(--text-color); opacity: 0.7;">{{ __('messages.status') }}</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider"
                                style="color: var(--text-color); opacity: 0.7;">{{ __('messages.created_at') }}</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider"
                                style="color: var(--text-color); opacity: 0.7;">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: var(--row-border);">
                        @foreach ($companies as $company)
                            <tr class="hover:bg-[var(--row-hover)] transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap font-medium" style="color: var(--text-color);">
                                    {{ $company->name }}
                                </td>
                                <td class="px-6 py-2 whitespace-nowrap" style="color: var(--text-color);">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium"
                                        style="background: var(--accent-bg); color: var(--accent-text);">
                                        {{ $company->activeSubscription->plan->name ?? __('messages.no_plan') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($company->activeSubscription)
                                        <span class="px-3 py-1 rounded-full text-xs font-medium"
                                            style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                            {{ __('messages.active') }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-medium"
                                            style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                                            {{ __('messages.no_active_plan') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm"
                                    style="color: var(--text-color); opacity: 0.8;">
                                    {{ $company->created_at->format('Y-m-d') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('super-admin.companies.show', $company) }}"
                                            style="color: var(--accent-text); background: var(--accent-bg); padding: 0.4rem 1rem; border-radius: 30px; border: 1px solid var(--accent-border);"
                                            class="hover:opacity-80 transition-opacity">
                                            {{ __('messages.view') }}
                                        </a>
                                        <a href="{{ route('super-admin.companies.edit', $company) }}"
                                            style="color: var(--btn-text); background: var(--btn-bg); padding: 0.4rem 1rem; border-radius: 30px; border: 1px solid var(--btn-border);"
                                            class="hover:opacity-80 transition-opacity">
                                            {{ __('messages.edit') ?? 'Edit' }}
                                        </a>
                                        @if(stripos($company->name, 'Kashmos') === false)
                                            <form action="{{ route('super-admin.companies.destroy', $company) }}" method="POST"
                                                onsubmit="return confirm('{{ __('messages.are_you_sure') }}');"
                                                class="inline m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="color: #ef4444; background: rgba(239, 68, 68, 0.1); padding: 0.4rem 1rem; border-radius: 30px; border: 1px solid rgba(239, 68, 68, 0.2);"
                                                    class="hover:opacity-80 transition-opacity">
                                                    {{ __('messages.delete') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden divide-y" style="border-color: var(--row-border);">
                @foreach ($companies as $company)
                    <div class="p-6 space-y-4 hover:bg-[var(--row-hover)] transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div class="font-bold text-lg" style="color: var(--text-color);">{{ $company->name }}</div>
                            @if ($company->activeSubscription)
                                <span class="px-3 py-1 rounded-full text-xs font-medium"
                                    style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                    {{ __('messages.active') }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-medium"
                                    style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                                    {{ __('messages.no_active_plan') }}
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-sm" style="color: var(--text-color);">
                            <span class="opacity-70">{{ __('messages.current_plan') }}:</span>
                            <span class="font-medium" style="color: var(--accent-text);">
                                {{ $company->activeSubscription->plan->name ?? __('messages.no_plan') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm" style="color: var(--text-color);">
                            <span class="opacity-70">{{ __('messages.created_at') }}:</span>
                            <span>{{ $company->created_at->format('Y-m-d') }}</span>
                        </div>
                        <div class="pt-2 flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('super-admin.companies.show', $company) }}"
                                style="color: var(--accent-text); background: var(--accent-bg); flex: 1; text-align: center; padding: 0.75rem; border-radius: 1rem; font-weight: 500; border: 1px solid var(--accent-border);"
                                class="hover:opacity-80 transition-opacity">
                                {{ __('messages.view') }}
                            </a>
                            <a href="{{ route('super-admin.companies.edit', $company) }}"
                                style="color: var(--btn-text); background: var(--btn-bg); flex: 1; text-align: center; padding: 0.75rem; border-radius: 1rem; font-weight: 500; border: 1px solid var(--btn-border);"
                                class="hover:opacity-80 transition-opacity">
                                {{ __('messages.edit') ?? 'Edit' }}
                            </a>
                            @if(stripos($company->name, 'Kashmos') === false)
                                <form action="{{ route('super-admin.companies.destroy', $company) }}" method="POST"
                                    onsubmit="return confirm('{{ __('messages.are_you_sure') }}');" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="color: #ef4444; background: rgba(239, 68, 68, 0.1); width: 100%; text-align: center; padding: 0.75rem; border-radius: 1rem; font-weight: 500; border: 1px solid rgba(239, 68, 68, 0.2);"
                                        class="hover:opacity-80 transition-opacity">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
