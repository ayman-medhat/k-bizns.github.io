<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.edit_user') ?? __('Edit User') }}
        </h2>
    </x-slot>

    <div>
        <div class="mb-6">
            <h3
                style="font-size: 1.5rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.4rem;">
                {{ __('messages.team_management') }}
            </h3>
        </div>

        <div style="background: var(--content-bg); border-radius: 1.5rem; padding: 2rem; border: 1px solid var(--row-border); box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('messages.name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('messages.email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div>
                            <x-input-label for="role" :value="__('messages.role')" />
                            <select id="role" name="role"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                style="background-color: var(--content-bg); color: var(--text-color); border-color: var(--row-border);">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Manager -->
                        <div>
                            <x-input-label for="manager_id" :value="__('messages.manager') ?? __('Manager')" />
                            <select id="manager_id" name="manager_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                style="background-color: var(--content-bg); color: var(--text-color); border-color: var(--row-border);">
                                <option value="">{{ __('messages.no_manager') }}</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}" {{ $user->manager_id == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('manager_id')" class="mt-2" />
                        </div>

                        <!-- Company (Super Admin only) -->
                        @if(auth()->user()->hasRole('Super Admin'))
                        <div>
                            <x-input-label for="company_id" :value="__('messages.company') ?? __('Company')" />
                            <select id="company_id" name="company_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                style="background-color: var(--content-bg); color: var(--text-color); border-color: var(--row-border);" required>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $user->company_id) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                        </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <button type="submit" 
                            style="background: var(--btn-bg); color: var(--btn-text); padding: 0.8rem 2rem; border-radius: 40px; font-weight: 700; border: 1px solid var(--btn-border); transition: all 0.2s;"
                            class="w-full sm:w-auto"
                            onmouseover="this.style.background='var(--btn-hover-bg)'; this.style.transform='translateY(-2px)';"
                            onmouseout="this.style.background='var(--btn-bg)'; this.style.transform='translateY(0)';"
                        >
                            {{ __('Update User') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>