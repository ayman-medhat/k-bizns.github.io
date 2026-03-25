<x-app-layout>
    <x-slot name="header">{{ __('messages.users') }}</x-slot>

    <div>
        <div class="flex justify-between items-center mb-6">
            <h3
                style="font-size: 1.5rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.4rem;">
                {{ __('messages.all_users') }}
            </h3>
            <a href="{{ route('users.create') }}"
                style="background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border); padding: 0.5rem 1.25rem; border-radius: 2rem; font-weight: 600; text-decoration: none; font-size: 0.95rem; transition: all 0.2s; white-space: nowrap;"
                onmouseover="this.style.background='var(--btn-hover-bg)';"
                onmouseout="this.style.background='var(--btn-bg)';">
                ➕ {{ __('messages.create_user') }}
            </a>
        </div>

        @if(session('success'))
            <div
                style="background: #f0f7f0; border: 1px solid #c3e6cb; color: #155724; padding: 1rem; border-radius: 1.5rem; margin-bottom: 1.5rem;">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- ── MOBILE: Cards ── --}}
        <div class="sm:hidden space-y-3">
            @forelse ($users as $user)
                <div
                    style="background: var(--content-bg); border: 1px solid var(--row-border); border-radius: 1.25rem; padding: 1rem; box-shadow: var(--card-shadow);">
                    <div class="flex items-center gap-3">
                        <div
                            style="width: 42px; height: 42px; border-radius: 12px; background: var(--nav-bg); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem; border: 1px solid var(--table-border); color: var(--title-color); flex-shrink: 0;">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div style="font-weight: 600; color: var(--text-color);" class="truncate">{{ $user->name }}
                            </div>
                            <div style="font-size: 0.8rem; opacity: 0.7;" class="truncate">{{ $user->email }}</div>
                            <span
                                style="background: var(--badge-bg); padding: 0.1rem 0.5rem; border-radius: 10px; border: 1px solid var(--badge-border); font-size: 0.72rem; font-weight: 600;">
                                {{ $user->roles->pluck('name')->implode(', ') ?: '—' }}
                            </span>
                        </div>
                        <div class="flex flex-col gap-2 flex-shrink-0">
                            <a href="{{ route('users.edit', $user) }}" style="font-size: 1.1rem;" title="Edit">✏️</a>
                            <form action="{{ route('users.reset-password', $user) }}" method="POST"
                                onsubmit="return confirm('Reset this user\\'s password? A new password will be generated and emailed to the root admin.')">
                                @csrf
                                <button type="submit" title="Reset Password"
                                    style="font-size: 1.1rem; background: none; border: none; cursor: pointer;">🔑</button>
                            </form>
                            @if(!$user->is_root)
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Delete this user?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Delete User"
                                        style="font-size: 1.1rem; background: none; border: none; cursor: pointer;">🗑️</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center py-8 opacity-50">No users found.</p>
            @endforelse
        </div>

        {{-- ── DESKTOP: Table ── --}}
        <div class="hidden sm:block"
            style="background: var(--content-bg); border-radius: 2rem; overflow: hidden; border: 1px solid var(--content-border); box-shadow: var(--card-shadow);">
            <div class="overflow-x-auto">
                <table class="min-w-full" style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr style="background: var(--table-header-bg); color: var(--table-header-color);">
                            <th class="py-3 px-4 text-left"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border); border-radius: 1.5rem 0 0 1.5rem;">
                                {{ __('Name') }}
                            </th>
                            <th class="py-3 px-4 text-left"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border);">
                                {{ __('Email') }}
                            </th>
                            <th class="py-3 px-4 text-left"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border);">{{ __('Role') }}
                            </th>
                            <th class="py-3 px-4 text-right"
                                style="font-weight: 550; border-bottom: 2px solid var(--table-border); border-radius: 0 1.5rem 1.5rem 0;">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr style="border-bottom: 1px solid var(--row-border); transition: background 0.2s;"
                                onmouseover="this.style.background='var(--row-hover-bg)';"
                                onmouseout="this.style.background='transparent';">
                                <td class="p-4"
                                    style="border-bottom: 1px solid var(--row-border); font-weight: 600; color: var(--text-color);">
                                    {{ $user->name }}
                                </td>
                                <td class="p-4"
                                    style="border-bottom: 1px solid var(--row-border); opacity: 0.85; color: var(--text-color);">
                                    {{ $user->email }}
                                </td>
                                <td class="p-4" style="border-bottom: 1px solid var(--row-border);">
                                    <span
                                        style="background: var(--badge-bg); padding: 0.2rem 0.6rem; border-radius: 12px; border: 1px solid var(--badge-border); font-size: 0.8rem; font-weight: 600;">
                                        {{ $user->roles->pluck('name')->implode(', ') ?: '—' }}
                                    </span>
                                </td>
                                <td class="p-4 text-right" style="border-bottom: 1px solid var(--row-border);">
                                    <div class="flex justify-end gap-3 items-center">
                                        <a href="{{ route('users.edit', $user) }}" title="Edit User"
                                            style="color: var(--btn-text); font-size: 1.1rem; transition: transform 0.2s;"
                                            onmouseover="this.style.transform='scale(1.2)';"
                                            onmouseout="this.style.transform='scale(1)';">✏️</a>
                                        <form action="{{ route('users.reset-password', $user) }}" method="POST"
                                            onsubmit="return confirm('Reset this user\\'s password? A new password will be generated and emailed to the root admin.')"
                                            class="inline m-0 p-0 flex items-center">
                                            @csrf
                                            <button type="submit" title="Reset Password"
                                                style="color: var(--btn-text); font-size: 1.1rem; border: none; cursor: pointer; transition: transform 0.2s; background: none; padding: 0;"
                                                onmouseover="this.style.transform='scale(1.2)';"
                                                onmouseout="this.style.transform='scale(1)';">
                                                🔑
                                            </button>
                                        </form>
                                        @if(!$user->is_root)
                                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?')"
                                                class="inline m-0 p-0 flex items-center">
                                                @csrf @method('DELETE')
                                                <button type="submit" title="Delete User"
                                                    style="color: var(--btn-text); font-size: 1.1rem; border: none; cursor: pointer; transition: transform 0.2s; background: none; padding: 0;"
                                                    onmouseover="this.style.transform='scale(1.2)';"
                                                    onmouseout="this.style.transform='scale(1)';">🗑️</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $users->links() }}</div>
        </div>

        <div class="sm:hidden mt-4">{{ $users->links() }}</div>
    </div>
</x-app-layout>
