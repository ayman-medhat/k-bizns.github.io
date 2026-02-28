<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-semibold text-sm text-gray-700 mb-1">{{ __('messages.name') }}</label>
            <input id="name"
                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl transition-all outline-none"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Ayman Medhat" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email"
                class="block font-semibold text-sm text-gray-700 mb-1">{{ __('messages.email_address') }}</label>
            <input id="email"
                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl transition-all outline-none"
                type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="kashmos@outlook.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password"
                class="block font-semibold text-sm text-gray-700 mb-1">{{ __('messages.password') }}</label>
            <input id="password"
                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl transition-all outline-none"
                type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation"
                class="block font-semibold text-sm text-gray-700 mb-1">{{ __('messages.confirm_password') }}</label>
            <input id="password_confirmation"
                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl transition-all outline-none"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);"
                class="w-full flex items-center justify-center px-6 py-4 border border-transparent rounded-xl font-bold text-base text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all shadow-lg hover:shadow-orange-500/20 hover:-translate-y-0.5">
                {{ __('messages.register') }}
            </button>
        </div>

        <div class="text-center pt-4 border-t border-gray-100">
            <p class="text-sm text-gray-500">
                {{ __('messages.already_registered') }}
                <a href="{{ route('login') }}"
                    class="text-orange-600 font-bold hover:text-orange-700 transition-colors">
                    {{ __('messages.login') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>