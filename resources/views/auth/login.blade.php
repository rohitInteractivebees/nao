<x-guest-layout>
    <!-- Session Status -->
     <div class="text-center text-sec">
        <div class="heading">Welcome</div>
        <div class="subtitle">Login into your account</div>
     </div>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-style">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-style">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="forgot-password">
            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
        <!-- Remember Me -->
        <div class="remberme">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-center mt-4">
            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <div class="register-account">
            <a
                href="{{ route('register') }}">
                Don’t have an account? <span>{{ __('Register') }}! </span>
            </a>
        </div>
        <div class="register-account">
            <a
                href="{{ route('school_register') }}">
                Don’t have an account? <span>{{ __('School Register') }}! </span>
            </a>
        </div>
    </form>

</x-guest-layout>
