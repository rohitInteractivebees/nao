<x-guest-layout>
<section class="login-sec relative">
    <div class="login-banner">
        <div class="login-content">
            <div class="container mx-auto">
                <div class="login-inner">
                    <div class="common-title mb-0">Welcome,</div>
                    <p>Login into your account</p>
                    <form method="POST" action="{{ route('login') }}" class="mt-10">
                        @csrf
                        <ul>
                            <li>
                                <div class="input-group">
                                    <label for="user_id">User ID</label>
                                    <input type="text" class="form-control"  id="user_id" name="user_id" placeholder="User ID" value="{{ old('user_id') }}" required>
                                    <span class="text-red-500 text-sm error-message">@error('user_id'){{ $message }}@enderror</span>
                                </div>
                            </li>
                            <li>
                                <div class="input-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" class="form-control" autocomplete="current-password" placeholder="Password" name="password" required>
                                </div>
                            </li>
                            <li class="flex justify-between items-center mb-4">
                                <div class="remberme">
                                    <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox"
                                            class="" name="remember">
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                    </label>
                                </div>
                                <div class="forgot-pass">
                                    @if (Route::has('password.request'))
                                        <a
                                            href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <button class="common-btn w-full">
                                    {{ __('Log in') }}
                                </button>
                            </li>
                            <li>
                                <div class="seprater-or">
                                    Or
                                </div>
                            </li>
                            <li>
                                <div class="register-account mb-2">
                                    <a
                                        href="{{ route('register') }}" class="login-btn w-full">
                                        Don’t have an account? {{ __('Register') }}! 
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="register-account">
                                    <a
                                        href="{{ route('school_register') }}" class="login-btn w-full">
                                        Don’t have an account? {{ __('School Register') }}! 
                                    </a>
                                </div>
                            </li>
                            
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </section>

</x-guest-layout>
