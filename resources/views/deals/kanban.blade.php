<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.deals_kanban_board') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="kanban()">
        <div class="flex justify-between items-center mb-8">
            <h3
                style="font-size: 1.8rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.5rem;">
                {{ __('messages.pipeline_kanban') }}
            </h3>
            <div class="flex gap-4">
                <a href="{{ route('deals.index') }}" title="{{ __('messages.list_view') }}"
                    style="color: var(--btn-text); font-size: 1.5rem; transition: all 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">
                    📄
                </a>
                <a href="{{ route('deals.create') }}" title="{{ __('messages.add_deal') }}"
                    style="color: var(--btn-text); font-size: 1.8rem; transition: all 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">
                    ➕
                </a>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-6 overflow-x-auto pb-8 snap-x">
            <!-- Open Column -->
            <div style="background: var(--nav-bg); border-radius: 2rem; border: 1px solid var(--nav-border); min-width: 320px; flex: 1; padding: 1.5rem; box-shadow: var(--card-shadow);"
                class="snap-start">
                <h3
                    style="font-size: 1.1rem; color: var(--title-color); font-weight: 700; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                    <span style="display:flex;align-items:center;gap:0.5rem;">
                        <span
                            style="width:10px;height:10px;border-radius:50%;background:#6366f1;display:inline-block;box-shadow:0 0 6px rgba(99,102,241,0.5);"></span>
                        {{ __('messages.open_deals') }}
                    </span>
                    <span
                        style="background: var(--accent-bg); color: var(--accent-text); border-radius: 20px; padding: 0.15rem 0.75rem; font-size: 0.8rem;">{{ $openDeals->count() }}</span>
                </h3>
                <div class="space-y-4 min-h-[400px]" @dragover.prevent @drop.prevent="drop($event, 'open')">
                    @foreach ($openDeals as $deal)
                        <div draggable="true" @dragstart="drag($event, {{ $deal->id }})"
                            style="background: var(--content-bg); border-radius: 1.5rem; padding: 1.2rem 1.3rem; border-left: 5px solid #6366f1; border-top: 1px solid var(--content-border); border-right: 1px solid var(--content-border); border-bottom: 1px solid var(--content-border); box-shadow: 0 4px 12px rgba(0,0,0,0.04); cursor: grab; transition: all 0.2s; position: relative;"
                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='var(--card-shadow)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.04)';">
                            <div class="flex justify-between items-start mb-2">
                                <h4
                                    style="color: var(--text-color); font-weight: 650; font-size: 1rem; line-height: 1.3; flex: 1; margin-right: 0.5rem;">
                                    {{ $deal->title }}</h4>
                                <span
                                    style="display:inline-block;padding:0.15rem 0.6rem;border-radius:20px;background:rgba(99,102,241,0.15);color:#818cf8;font-size:0.7rem;font-weight:700;white-space:nowrap;">OPEN</span>
                            </div>
                            <p style="color: var(--text-color); opacity: 0.6; font-size: 0.82rem; margin-bottom: 0.85rem;">
                                🏢 {{ $deal->client->name }}</p>
                            <div class="flex justify-between items-center">
                                <span
                                    style="font-size: 1.15rem; font-weight: 800; color: var(--accent-text);">${{ number_format($deal->value, 0) }}</span>
                                <a href="{{ route('deals.show', $deal) }}"
                                    style="font-size: 0.78rem; font-weight: 600; text-decoration: none; color: var(--accent-text); opacity: 0.7; transition: opacity 0.2s;"
                                    onmouseover="this.style.opacity='1';"
                                    onmouseout="this.style.opacity='0.7';">{{ __('messages.detail') }} →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Won Column -->
            <div style="background: #e8f5e9; border-radius: 2rem; border: 1px solid #c8e6c9; min-width: 320px; flex: 1; padding: 1.5rem; box-shadow: 0 4px 12px rgba(76, 175, 80, 0.05);"
                class="snap-start">
                <h3 style="font-size: 1.1rem; color: #2e7d32; font-weight: 700; margin-bottom: 1.5rem; display: flex; justify-between; align-items: center;"
                    class="justify-between flex">
                    <span>{{ __('messages.won_deals') }}</span>
                    <span
                        style="background: #4caf50; color: white; border-radius: 20px; padding: 0.1rem 0.7rem; font-size: 0.8rem;">{{ $wonDeals->count() }}</span>
                </h3>
                <div class="space-y-4 min-h-[400px]" @dragover.prevent @drop.prevent="drop($event, 'won')">
                    @foreach ($wonDeals as $deal)
                        <div draggable="true" @dragstart="drag($event, {{ $deal->id }})"
                            style="background: #fff; border-radius: 1.5rem; padding: 1.25rem; border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid #4caf50; box-shadow: 0 4px 10px rgba(0,0,0,0.03); cursor: grab; transition: all 0.2s;"
                            onmouseover="this.style.transform='translateY(-3px)';"
                            onmouseout="this.style.transform='translateY(0)';" class="group">
                            <h4 style="color: #1b5e20; font-weight: 650; font-size: 1.05rem; margin-bottom: 0.25rem;">
                                {{ $deal->title }}
                            </h4>
                            <p style="color: #4caf50; font-size: 0.85rem; margin-bottom: 1rem;">🏢
                                {{ $deal->client->name }}
                            </p>
                            <div class="flex justify-between items-center mt-2">
                                <span
                                    style="color: #2e7d32; font-weight: 750; font-size: 1.1rem;">${{ number_format($deal->value, 0) }}</span>
                                <a href="{{ route('deals.show', $deal) }}"
                                    style="color: #4caf50; font-size: 0.8rem; font-weight: 600; text-decoration: none;"
                                    class="hover:underline">{{ __('messages.detail') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Lost Column -->
            <div style="background: #fafafa; border-radius: 2rem; border: 1px solid #eeeeee; min-width: 320px; flex: 1; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);"
                class="snap-start">
                <h3 style="font-size: 1.1rem; color: #616161; font-weight: 700; margin-bottom: 1.5rem; display: flex; justify-between; align-items: center;"
                    class="justify-between flex">
                    <span>{{ __('messages.lost_deals') }}</span>
                    <span
                        style="background: #bdbdbd; color: white; border-radius: 20px; padding: 0.1rem 0.7rem; font-size: 0.8rem;">{{ $lostDeals->count() }}</span>
                </h3>
                <div class="space-y-4 min-h-[400px]" @dragover.prevent @drop.prevent="drop($event, 'lost')">
                    @foreach ($lostDeals as $deal)
                        <div draggable="true" @dragstart="drag($event, {{ $deal->id }})"
                            style="background: #fff; border-radius: 1.5rem; padding: 1.25rem; border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid #bdbdbd; box-shadow: 0 4px 10px rgba(0,0,0,0.03); cursor: grab; opacity: 0.7; transition: all 0.2s;"
                            onmouseover="this.style.opacity='1'; this.style.transform='translateY(-3px)';"
                            onmouseout="this.style.opacity='0.7'; this.style.transform='translateY(0)';" class="group">
                            <h4 style="color: #424242; font-weight: 650; font-size: 1.05rem; margin-bottom: 0.25rem;">
                                {{ $deal->title }}
                            </h4>
                            <p style="color: #757575; font-size: 0.85rem; margin-bottom: 1rem;">🏢
                                {{ $deal->client->name }}
                            </p>
                            <div class="flex justify-between items-center mt-2">
                                <span
                                    style="color: #9e9e9e; font-weight: 750; font-size: 1.1rem;">${{ number_format($deal->value, 0) }}</span>
                                <a href="{{ route('deals.show', $deal) }}"
                                    style="color: #9e9e9e; font-size: 0.8rem; font-weight: 600; text-decoration: none;"
                                    class="hover:underline">{{ __('messages.detail') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function kanban() {
            return {
                draggingDealId: null,

                drag(event, dealId) {
                    this.draggingDealId = dealId;
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', dealId);
                    event.target.style.opacity = '0.4';
                },

                drop(event, newStatus) {
                    const dealId = event.dataTransfer.getData('text/plain');
                    const element = document.querySelector(`[draggable="true"]`); // Simplified selector for finding the dragged element

                    // Send update to server
                    fetch(`/deals/${dealId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                        .then(response => {
                            if (response.ok) {
                                window.location.reload();
                            } else {
                                alert('Failed to update status');
                            }
                        });
                }
            }
        }
    </script>
</x-app-layout>