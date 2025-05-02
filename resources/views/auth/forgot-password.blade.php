<x-guest-layout>
    <div class="text-sec text-center">
        <div class="heading">Forgot your password?</div>
        <p>{{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
     </div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-style">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="forgot-password">
            <a href="{{ route('login') }}"> Back to Login<a/>
        </div>
        <div class="flex items-center justify-center mt-4">
            <x-primary-button>
                {{ __('Reset') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
