<x-app-layout>
    <x-slot name="header">
        {{ __('messages.dashboard') }}
    </x-slot>

    <div>
        @can('manage company')
            <div class="mb-6 flex justify-end">
                <a href="{{ route('super-admin.companies.index') }}"
                    style="color: var(--btn-text); background: var(--btn-bg); padding: 0.7rem 1.2rem; border-radius: 999px; border: 1px solid var(--btn-border); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                    onmouseover="this.style.background='var(--btn-hover-bg)'; this.style.transform='translateY(-1px)';"
                    onmouseout="this.style.background='var(--btn-bg)'; this.style.transform='translateY(0)';">
                    {{ __('messages.manage_companies') }}
                </a>
            </div>
        @endcan

        <h3 class="text-2xl font-light mb-6 flex items-center gap-3"
            style="color: var(--title-color); letter-spacing: -0.01em;">
            {{ __('messages.welcome') }} <span style="font-weight: 600; color: var(--accent-text);">K-bizns</span>
            <img src="{{ asset('images/kashmos-logo.png') }}" alt="KASHMOS"
                style="height: 32px; width: 32px; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        </h3>

        <!-- Themed Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Companies Card -->
            <a href="{{ route('clients.index') }}"
                style="background: var(--nav-bg); border-radius: 2rem; padding: 2.2rem 1.8rem; border: 1px solid var(--nav-border); box-shadow: var(--card-shadow); transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-decoration: none; display: block;"
                onmouseover="this.style.transform='translateY(-6px)'; this.style.background='var(--content-bg)'; this.style.borderColor='var(--accent-border)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.background='var(--nav-bg)'; this.style.borderColor='var(--nav-border)';"
                class="hover:shadow-lg">
                <div
                    style="font-size: 2.8rem; margin-bottom: 1rem; display: inline-block; background: var(--accent-bg); width: 70px; height: 70px; line-height: 74px; text-align: center; border-radius: 24px; color: var(--accent-text); box-shadow: 0 5px 10px rgba(0,0,0,0.05);">
                    🏢</div>
                <h3
                    style="font-size: 2rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.5rem; margin-bottom: 1rem;">
                    {{ __('messages.companies') }}
                </h3>
                <div style="display: flex; align-items: baseline; gap: 0.5rem;">
                    <span
                        style="font-size: 2.2rem; font-weight: 800; color: var(--text-color);">{{ $counts['companies'] }}</span>
                    <span
                        style="font-size: 1.1rem; font-weight: 500; opacity: 0.7; color: var(--text-color); text-transform: uppercase;">{{ __('messages.active_records') }}</span>
                </div>
            </a>

            <!-- Contacts Card -->
            <a href="{{ route('contacts.index') }}"
                style="background: var(--nav-bg); border-radius: 2rem; padding: 2.2rem 1.8rem; border: 1px solid var(--nav-border); box-shadow: var(--card-shadow); transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-decoration: none; display: block;"
                onmouseover="this.style.transform='translateY(-6px)'; this.style.background='var(--content-bg)'; this.style.borderColor='var(--accent-border)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.background='var(--nav-bg)'; this.style.borderColor='var(--nav-border)';"
                class="hover:shadow-lg">
                <div
                    style="font-size: 2.8rem; margin-bottom: 1rem; display: inline-block; background: var(--accent-bg); width: 70px; height: 70px; line-height: 74px; text-align: center; border-radius: 24px; color: var(--accent-text); box-shadow: 0 5px 10px rgba(0,0,0,0.05);">
                    👥</div>
                <h3
                    style="font-size: 2rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.5rem; margin-bottom: 1rem;">
                    {{ __('messages.contacts') }}
                </h3>
                <div style="display: flex; align-items: baseline; gap: 0.5rem;">
                    <span
                        style="font-size: 2.2rem; font-weight: 800; color: var(--text-color);">{{ $counts['contacts'] }}</span>
                    <span
                        style="font-size: 1.1rem; font-weight: 500; opacity: 0.7; color: var(--text-color); text-transform: uppercase;">{{ __('messages.growth_network') }}</span>
                </div>
            </a>

            <!-- Deals Card -->
            <a href="{{ route('deals.index') }}"
                style="background: var(--nav-bg); border-radius: 2rem; padding: 2.2rem 1.8rem; border: 1px solid var(--nav-border); box-shadow: var(--card-shadow); transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-decoration: none; display: block;"
                onmouseover="this.style.transform='translateY(-6px)'; this.style.background='var(--content-bg)'; this.style.borderColor='var(--accent-border)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.background='var(--nav-bg)'; this.style.borderColor='var(--nav-border)';"
                class="hover:shadow-lg">
                <div
                    style="font-size: 2.8rem; margin-bottom: 1rem; display: inline-block; background: var(--accent-bg); width: 70px; height: 70px; line-height: 74px; text-align: center; border-radius: 24px; color: var(--accent-text); box-shadow: 0 5px 10px rgba(0,0,0,0.05);">
                    💼</div>
                <h3
                    style="font-size: 2rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.5rem; margin-bottom: 1rem;">
                    {{ __('messages.deals') }}
                </h3>
                <div style="display: flex; align-items: baseline; gap: 0.5rem;">
                    <span
                        style="font-size: 2.2rem; font-weight: 800; color: var(--text-color);">{{ $counts['deals'] }}</span>
                    <span
                        style="font-size: 1.1rem; font-weight: 500; opacity: 0.7; color: var(--text-color); text-transform: uppercase;">{{ __('messages.pipeline_value') }}</span>
                </div>
            </a>
        </div>

        <!-- Quote Section -->
        <div
            style="background: var(--nav-bg); padding: 1.8rem; border-radius: 2rem; margin-top: 2.5rem; border: 1px solid var(--nav-border); color: var(--text-color);">
            <i style="font-size: 2rem; color: var(--accent-text); opacity: 0.5; margin-right: 0.5rem;">"</i>
            {{ __('messages.relationships_quote') }}
        </div>
    </div>
</x-app-layout>
