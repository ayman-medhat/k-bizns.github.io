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

        <h3 class="text-2xl font-light mb-8 flex items-center gap-3"
            style="color: var(--title-color); letter-spacing: -0.01em;">
            {{ __('messages.welcome') }} <span style="font-weight: 600; color: var(--accent-text);">K-bizns</span>
            <img src="{{ asset('images/kashmos-logo.png') }}" alt="KASHMOS"
                style="height: 32px; width: 32px; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        </h3>

        {{-- ── Stat Cards ── --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            {{-- Companies --}}
            <a href="{{ route('clients.index') }}"
                style="background: var(--nav-bg); border-radius: 2rem; padding: 2.2rem 1.8rem; border: 1px solid var(--nav-border); box-shadow: var(--card-shadow); transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-decoration: none; display: block; position: relative; overflow: hidden;"
                onmouseover="this.style.transform='translateY(-6px)'; this.style.background='var(--content-bg)'; this.style.borderColor='var(--accent-border)'; this.querySelector('.stat-glow').style.opacity='1';"
                onmouseout="this.style.transform='translateY(0)'; this.style.background='var(--nav-bg)'; this.style.borderColor='var(--nav-border)'; this.querySelector('.stat-glow').style.opacity='0';">
                {{-- Glow effect --}}
                <div class="stat-glow"
                    style="position:absolute;inset:0;background:radial-gradient(circle at 30% 30%,rgba(139,92,246,0.08),transparent 70%);opacity:0;transition:opacity 0.3s;pointer-events:none;border-radius:2rem;">
                </div>
                <div
                    style="font-size: 2.2rem; margin-bottom: 1rem; display: inline-flex; align-items: center; justify-content: center; background: var(--accent-bg); width: 64px; height: 64px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    🏢</div>
                <h3
                    style="font-size: 1.9rem; font-weight: 300; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.5rem; margin-bottom: 1rem;">
                    {{ __('messages.companies') }}
                </h3>
                <div style="display: flex; align-items: baseline; gap: 0.5rem;">
                    <span
                        style="font-size: 2.5rem; font-weight: 800; color: var(--text-color);">{{ $counts['companies'] }}</span>
                    <span
                        style="font-size: 0.95rem; font-weight: 600; opacity: 0.6; color: var(--text-color); text-transform: uppercase; letter-spacing: 0.05em;">{{ __('messages.active_records') }}</span>
                </div>
            </a>

            {{-- Contacts --}}
            <a href="{{ route('contacts.index') }}"
                style="background: var(--nav-bg); border-radius: 2rem; padding: 2.2rem 1.8rem; border: 1px solid var(--nav-border); box-shadow: var(--card-shadow); transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-decoration: none; display: block; position: relative; overflow: hidden;"
                onmouseover="this.style.transform='translateY(-6px)'; this.style.background='var(--content-bg)'; this.style.borderColor='var(--accent-border)'; this.querySelector('.stat-glow').style.opacity='1';"
                onmouseout="this.style.transform='translateY(0)'; this.style.background='var(--nav-bg)'; this.style.borderColor='var(--nav-border)'; this.querySelector('.stat-glow').style.opacity='0';">
                <div class="stat-glow"
                    style="position:absolute;inset:0;background:radial-gradient(circle at 30% 30%,rgba(139,92,246,0.08),transparent 70%);opacity:0;transition:opacity 0.3s;pointer-events:none;border-radius:2rem;">
                </div>
                <div
                    style="font-size: 2.2rem; margin-bottom: 1rem; display: inline-flex; align-items: center; justify-content: center; background: var(--accent-bg); width: 64px; height: 64px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    👥</div>
                <h3
                    style="font-size: 1.9rem; font-weight: 300; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.5rem; margin-bottom: 1rem;">
                    {{ __('messages.contacts') }}
                </h3>
                <div style="display: flex; align-items: baseline; gap: 0.5rem;">
                    <span
                        style="font-size: 2.5rem; font-weight: 800; color: var(--text-color);">{{ $counts['contacts'] }}</span>
                    <span
                        style="font-size: 0.95rem; font-weight: 600; opacity: 0.6; color: var(--text-color); text-transform: uppercase; letter-spacing: 0.05em;">{{ __('messages.growth_network') }}</span>
                </div>
            </a>

            {{-- Deals --}}
            <a href="{{ route('deals.index') }}"
                style="background: var(--nav-bg); border-radius: 2rem; padding: 2.2rem 1.8rem; border: 1px solid var(--nav-border); box-shadow: var(--card-shadow); transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-decoration: none; display: block; position: relative; overflow: hidden;"
                onmouseover="this.style.transform='translateY(-6px)'; this.style.background='var(--content-bg)'; this.style.borderColor='var(--accent-border)'; this.querySelector('.stat-glow').style.opacity='1';"
                onmouseout="this.style.transform='translateY(0)'; this.style.background='var(--nav-bg)'; this.style.borderColor='var(--nav-border)'; this.querySelector('.stat-glow').style.opacity='0';">
                <div class="stat-glow"
                    style="position:absolute;inset:0;background:radial-gradient(circle at 30% 30%,rgba(139,92,246,0.08),transparent 70%);opacity:0;transition:opacity 0.3s;pointer-events:none;border-radius:2rem;">
                </div>
                <div
                    style="font-size: 2.2rem; margin-bottom: 1rem; display: inline-flex; align-items: center; justify-content: center; background: var(--accent-bg); width: 64px; height: 64px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    💼</div>
                <h3
                    style="font-size: 1.9rem; font-weight: 300; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.5rem; margin-bottom: 1rem;">
                    {{ __('messages.deals') }}
                </h3>
                <div style="display: flex; align-items: baseline; gap: 0.5rem;">
                    <span
                        style="font-size: 2.5rem; font-weight: 800; color: var(--text-color);">{{ $counts['deals'] }}</span>
                    <span
                        style="font-size: 0.95rem; font-weight: 600; opacity: 0.6; color: var(--text-color); text-transform: uppercase; letter-spacing: 0.05em;">{{ __('messages.pipeline_value') }}</span>
                </div>
            </a>
        </div>

        {{-- ── Recent Activity ── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            {{-- Recent Contacts --}}
            <div
                style="background: var(--nav-bg); border-radius: 2rem; padding: 1.8rem; border: 1px solid var(--nav-border); box-shadow: var(--card-shadow);">
                <div class="flex justify-between items-center mb-4">
                    <h4 style="font-size: 1.1rem; font-weight: 600; color: var(--title-color);">👥
                        {{ __('messages.contacts') }}</h4>
                    <a href="{{ route('contacts.index') }}"
                        style="font-size: 0.8rem; color: var(--accent-text); text-decoration: none; opacity: 0.8;"
                        onmouseover="this.style.opacity='1';"
                        onmouseout="this.style.opacity='0.8';">{{ __('messages.view_all') ?? 'View all' }} →</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentContacts as $rc)
                        @php $rcName = app()->getLocale() == 'ar' ? ($rc->first_name_ar . ' ' . $rc->last_name_ar) : ($rc->first_name_en . ' ' . $rc->last_name_en); @endphp
                        <a href="{{ route('contacts.show', $rc) }}"
                            style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; background: var(--content-bg); border-radius: 1.25rem; border: 1px solid var(--content-border); text-decoration: none; transition: all 0.2s;"
                            onmouseover="this.style.borderColor='var(--accent-border)'; this.style.transform='translateX(4px)';"
                            onmouseout="this.style.borderColor='var(--content-border)'; this.style.transform='translateX(0)';">
                            @if($rc->photo_path)
                                <img src="{{ asset('storage/' . $rc->photo_path) }}"
                                    style="width:36px;height:36px;border-radius:10px;object-fit:cover;flex-shrink:0;">
                            @else
                                <div
                                    style="width:36px;height:36px;border-radius:10px;background:var(--accent-bg);display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">
                                    {{ substr($rc->first_name_en ?? '?', 0, 1) }}</div>
                            @endif
                            <div style="min-width:0;">
                                <p
                                    style="color:var(--text-color);font-weight:600;font-size:0.9rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $rcName }}</p>
                                <p style="color:var(--text-color);opacity:0.55;font-size:0.75rem;">{{ $rc->email }}</p>
                            </div>
                        </a>
                    @empty
                        <p style="opacity:0.4;text-align:center;padding:1rem;">
                            {{ __('messages.no_data') ?? 'No contacts yet.' }}</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Deals --}}
            <div
                style="background: var(--nav-bg); border-radius: 2rem; padding: 1.8rem; border: 1px solid var(--nav-border); box-shadow: var(--card-shadow);">
                <div class="flex justify-between items-center mb-4">
                    <h4 style="font-size: 1.1rem; font-weight: 600; color: var(--title-color);">💼
                        {{ __('messages.deals') }}</h4>
                    <a href="{{ route('deals.kanban') }}"
                        style="font-size: 0.8rem; color: var(--accent-text); text-decoration: none; opacity: 0.8;"
                        onmouseover="this.style.opacity='1';"
                        onmouseout="this.style.opacity='0.8';">{{ __('messages.view_all') ?? 'View all' }} →</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentDeals as $rd)
                        <a href="{{ route('deals.show', $rd) }}"
                            style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--content-bg); border-radius: 1.25rem; border: 1px solid var(--content-border); text-decoration: none; transition: all 0.2s;"
                            onmouseover="this.style.borderColor='var(--accent-border)'; this.style.transform='translateX(4px)';"
                            onmouseout="this.style.borderColor='var(--content-border)'; this.style.transform='translateX(0)';">
                            <div style="min-width:0;">
                                <p
                                    style="color:var(--text-color);font-weight:600;font-size:0.9rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $rd->title }}</p>
                                <p style="color:var(--text-color);opacity:0.55;font-size:0.75rem;">🏢
                                    {{ $rd->client->name ?? '-' }}</p>
                            </div>
                            <span
                                style="font-size:0.9rem;font-weight:700;color:var(--accent-text);flex-shrink:0;margin-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}:0.5rem;">
                                ${{ number_format($rd->value, 0) }}
                            </span>
                        </a>
                    @empty
                        <p style="opacity:0.4;text-align:center;padding:1rem;">
                            {{ __('messages.no_data') ?? 'No deals yet.' }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ── Quote ── --}}
        <div
            style="background: var(--nav-bg); padding: 1.8rem 2rem; border-radius: 2rem; border: 1px solid var(--nav-border); color: var(--text-color); display: flex; align-items: flex-start; gap: 1rem;">
            <span
                style="font-size: 3rem; color: var(--accent-text); opacity: 0.4; line-height: 1; flex-shrink: 0;">&ldquo;</span>
            <p style="font-style: italic; opacity: 0.8; font-size: 1.05rem; line-height: 1.6;">
                {{ __('messages.relationships_quote') }}</p>
        </div>
    </div>
</x-app-layout>