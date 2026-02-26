<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.clients_kanban') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="kanban()">
        <div class="flex justify-between items-center mb-8">
            <h3
                style="font-size: 1.8rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.5rem;">
                {{ __('messages.business_partner_kanban') }}</h3>
            <div class="flex gap-4">
                <a href="{{ route('clients.index') }}" title="{{ __('messages.list_view') }}"
                    style="color: var(--btn-text); font-size: 1.5rem; transition: all 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">
                    📄
                </a>
                <a href="{{ route('clients.create') }}" title="{{ __('messages.add_client') }}"
                    style="color: var(--btn-text); font-size: 1.8rem; transition: all 0.2s;"
                    onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                    class="flex items-center">
                    ➕
                </a>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-6 overflow-x-auto pb-8 snap-x">
            @foreach(['lead' => 'leads_column', 'client' => 'clients_column', 'partner' => 'partners_column', 'inactive' => 'inactive_column'] as $key => $msgKey)
                <div style="background: var(--nav-bg); border-radius: 2rem; border: 1px solid var(--nav-border); min-width: 310px; flex: 1; padding: 1.5rem; box-shadow: var(--card-shadow);"
                    class="snap-start">
                    <h3
                        style="font-size: 1.1rem; color: var(--title-color); font-weight: 700; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                        <span>{{ __('messages.' . $msgKey) }}</span>
                        <span
                            style="background: var(--accent-bg); color: var(--accent-text); border-radius: 20px; padding: 0.1rem 0.7rem; font-size: 0.8rem;">{{ $statuses[$key]->count() }}</span>
                    </h3>
                    <div class="space-y-4 min-h-[400px]" @dragover.prevent @drop.prevent="drop($event, '{{ $key }}')">
                        @foreach ($statuses[$key] as $client)
                            <div draggable="true" @dragstart="drag($event, {{ $client->id }})"
                                style="background: var(--content-bg); border-radius: 1.5rem; padding: 1.25rem; border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 6px solid var(--accent-border); box-shadow: 0 4px 10px rgba(0,0,0,0.03); cursor: grab; transition: all 0.2s;"
                                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='var(--card-shadow)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.03)';"
                                class="group">
                                <div class="flex items-center gap-3 mb-3">
                                    @if($client->logo_path)
                                        <img src="{{ asset('storage/' . $client->logo_path) }}"
                                            style="width: 40px; height: 40px; border-radius: 12px; object-fit: cover; border: 1px solid var(--nav-border);">
                                    @else
                                        <div
                                            style="width: 40px; height: 40px; border-radius: 12px; background: var(--nav-bg); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; border: 1px solid var(--nav-border);">
                                            🏢</div>
                                    @endif
                                    <h4 style="color: var(--text-color); font-weight: 650; font-size: 1.1rem;">
                                        {{ $client->name }}</h4>
                                </div>
                                <p style="color: var(--text-color); opacity: 0.8; font-size: 0.85rem; margin-bottom: 0.5rem;">📧
                                    {{ $client->email }}</p>
                                @if($client->industry)
                                    <p style="color: var(--accent-border); font-size: 0.8rem;">🏭 {{ app()->getLocale() == 'ar' ? $client->industry->name_ar : $client->industry->name_en }}</p>
                                @endif
                                <div class="mt-4 flex justify-between items-center">
                                    <span style="font-size: 0.75rem; opacity: 0.6;">{{ __('messages.contacts_count', ['count' => $client->contacts->count()]) }}</span>
                                    <a href="{{ route('clients.show', $client) }}"
                                        style="color: var(--accent-text); font-size: 0.8rem; font-weight: 600; text-decoration: none;"
                                        class="hover:underline">{{ __('messages.detail') }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function kanban() {
            return {
                drag(event, id) {
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', id);
                    event.target.style.opacity = '0.4';
                },

                drop(event, newStatus) {
                    const id = event.dataTransfer.getData('text/plain');
                    fetch(`/clients/${id}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ status: newStatus })
                    }).then(response => {
                        if (response.ok) window.location.reload();
                        else alert('Failed to update status');
                    });
                }
            }
        }
    </script>
</x-app-layout>