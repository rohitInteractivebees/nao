<x-guest-layout>
    <section class="login-sec relative">
    <div class="login-banner">
        <div class="login-content">
            <div class="container mx-auto">
                <div class="login-inner">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <div class="common-title mb-0">Forgot Password</div>
                    
                    
                    <form method="POST" action="{{ route('password.email') }}" class="mt-10">
                        @csrf
                        <ul>
                            <li>
                                <div class="input-group mb-0">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-1 mb-2" />
                            </li>
                            <li>
                                <button class="common-btn w-full mt-5">
                                    {{ __('Reset') }}
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
                                        href="{{ route('login') }}" class="login-btn w-full">
                                         Back to Login 
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
