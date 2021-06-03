<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('imagenes/auth/logo-sigin.jpg') }}" class="mx-auto fill-current" width="150" height="150" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>

                <x-input id="email" class="block mt-1 w-full hover:bg-blue-100" type="email" name="email" :value="old('email')" required autofocus placeholder="Email" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input id="password" class="block w-full hover:bg-blue-100"
                                type="password"
                                name="password"
                                required autocomplete="current-password" 
                                placeholder="Contraseña"/>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-primary">{{ __('Recuérdame') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-primary" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif
                <a href="{{ route('register') }}" class="ml-4 underline text-sm text-primary">Crear cuenta</a>

                <x-button class="ml-3 text-primary">
                    {{ __('Acceder') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
