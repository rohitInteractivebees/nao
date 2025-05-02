<x-app-layout>
    <section class="common-sec login-page profile-edit">
        <div class="container d-flex justify-end">
            <ul class="links">
            <li>
                    <a href="{{url('profile')}}">Profile Information</a>
                </li>
                <li class="active">
                    <a href="{{url('profile/password')}}">Update Password</a>
                </li>
            </ul>
            <div class="right overview">
                
                <div class="inner" id="update">
                    <div class="text-sec text-center">
                        <div class="heading">Update Information</div>
                        <p>Update your account's profile information</p>
                    </div>
                    <section>

<form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('put')
    <div class="half-view d-flex justify-between">
        <div class="form-style">
            <x-input-label for="current_password" :value="__('Current Password')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="form-style">
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="form-style">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mt-8 gap-4 w-100">
            <x-primary-button>{{ __('Update Password') }}</x-primary-button>

            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </div>
</form>    
</section>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>