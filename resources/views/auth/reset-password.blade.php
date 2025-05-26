<x-guest-layout>
    <section class="login-sec relative">
    <div class="login-banner">
        <div class="login-content">
            <div class="container mx-auto">
                <div class="login-inner">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <div class="common-title mb-0">Welcome,</div>
                    <p>Reset Password</p>
                    
                    <form method="POST" action="{{ route('password.store') }}" class="mt-10">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <ul>
                            <li>
                                <div class="input-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </li>

                            <li>
                                <div class="input-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required autocomplete="new-password">
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </li>

                            <li>
                                <div class="input-group mt-3">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required autocomplete="new-password">
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </li>
                            <li>
                                <button class="common-btn w-full">
                                    {{ __('Reset Password') }}
                                </button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </section>
</x-guest-layout>
