<x-app-layout>
    <section class="common-sec login-page profile-edit">
        <div class="container d-flex justify-end">
            <ul class="links">
                <li class="active">
                    <a href="{{url('profile')}}">Profile Information</a>
                </li>
                <li>
                    <a href="{{url('profile/password')}}">Update Password</a>
                </li>
            </ul>
            <div class="right overview">
                <div class="inner" id="info">
                    <div class="text-sec text-center">
                        <div class="heading">Profile Information</div>
                        <p>Update your account's profile information</p>
                    </div>
                    <section>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="half-view d-flex justify-between">
            <div class="form-style">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            @php
            $institutes = App\Models\Instute::where('id',$user->institute)->first();
            @endphp
            @if(auth()->user()->is_admin != 1)
            <div class="form-style">
                <x-input-label for="institute" :value="__('School')" />
                <select wire:model.defer="institute" id="institute" name="institute" class="mt-1 block w-full" required>
                    <!-- <option value="" disabled>Select your institute</option> -->

                    <option value="{{ $institutes->id }}" {{ old('institute', $institutes->id) == $institutes->id ? 'selected' : '' }}>{{ $institutes->name }}</option>

                </select>
                <x-input-error class="mt-2" :messages="$errors->get('institute')" />
            </div>
            @endif

            @if(auth()->user()->is_college != 1 && auth()->user()->is_admin != 1)

            <div class="form-style d-flex justify-between" style="row-gap: 30px;">
                <div id="other-stream-upper" style="margin-top: 0;" class="w-100">
                    <x-input-label for="streams" :value="__('Streams')" />
                    <select id="streams" class="block mt-1 w-full" name="streams" onchange="toggleOtherField(this)">
                        <option value="">Select your engineering department</option>
                        <option value="Aerospace Engineering" {{ old('streams', $user->streams) == 'Aerospace Engineering' ? 'selected' : '' }}>Aerospace Engineering</option>
                        <option value="Agricultural Engineering" {{ old('streams', $user->streams) == 'Agricultural Engineering' ? 'selected' : '' }}>Agricultural Engineering</option>
                        <option value="Biomedical Engineering" {{ old('streams', $user->streams) == 'Biomedical Engineering' ? 'selected' : '' }}>Biomedical Engineering</option>
                        <option value="Chemical Engineering" {{ old('streams', $user->streams) == 'Chemical Engineering' ? 'selected' : '' }}>Chemical Engineering</option>
                        <option value="Civil Engineering" {{ old('streams', $user->streams) == 'Civil Engineering' ? 'selected' : '' }}>Civil Engineering</option>
                        <option value="Computer Engineering" {{ old('streams', $user->streams) == 'Computer Engineering' ? 'selected' : '' }}>Computer Engineering</option>
                        <option value="Electrical Engineering" {{ old('streams', $user->streams) == 'Electrical Engineering' ? 'selected' : '' }}>Electrical Engineering</option>
                        <option value="Environmental Engineering" {{ old('streams', $user->streams) == 'Environmental Engineering' ? 'selected' : '' }}>Environmental Engineering</option>
                        <option value="Industrial Engineering" {{ old('streams', $user->streams) == 'Industrial Engineering' ? 'selected' : '' }}>Industrial Engineering</option>
                        <option value="Materials Engineering" {{ old('streams', $user->streams) == 'Materials Engineering' ? 'selected' : '' }}>Materials Engineering</option>
                        <option value="Mechanical Engineering" {{ old('streams', $user->streams) == 'Mechanical Engineering' ? 'selected' : '' }}>Mechanical Engineering</option>
                        <option value="Software Engineering" {{ old('streams', $user->streams) == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                        <option value="other" {{ old('streams', $user->streams) == 'other' ? 'selected' : '' }}>Other</option>

                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('streams')" />
                </div>

                <div id="other-stream" style="display: none; margin-top: 0;" class="form-style">
                    <x-input-label for="other_stream" :value="__('Other Stream')" />
                    <input id="other_stream" type="text" class="block mt-1 w-full" name="other_stream" value="{{ old('other_stream', $user->other_stream) }}" />
                </div>
            </div>


            <div class="form-style">
                <x-input-label for="session_year" :value="__('Session year')" />
                <x-text-input id="session_year" name="session_year" type="text" class="mt-1 block w-full" :value="old('session_year', $user->session_year)" />
                <x-input-error class="mt-2" :messages="$errors->get('session_year')" />
            </div>
            @endif

            <div class="form-style">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" readonly autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                    @endif
                </div>
                @endif
            </div>
            <div class="form-style">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" maxlength="10" oninput="validatePhoneInput(this)" required autofocus autocomplete="phone" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            <div class="flex items-center justify-center mt-8 gap-4 w-100">
                <x-primary-button>{{ __('Update Profile') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
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

<script>
    function validatePhoneInput(input) {
        // Allow only numbers
        input.value = input.value.replace(/\D/g, '');

        // Limit to 10 digits
        if (input.value.length > 10) {
            input.value = input.value.slice(0, 10);
        }
    }
</script>
<script>    
    document.addEventListener('DOMContentLoaded', function() {
        var select = document.getElementById('streams');
        var otherField = document.getElementById('other-stream');    
        var otherFieldUpper = document.getElementById('other-stream-upper');   
        var otherStreamInput = document.getElementById('other_stream');

        if (select.value === 'other') {
            otherField.style.display = 'block';
            otherFieldUpper.classList.add("form-style")
            otherFieldUpper.classList.remove("w-100")
            // select.name = '';
            // otherStreamInput.name = 'streams';
        }
        else {
            otherField.style.display = 'none';
            otherFieldUpper.classList.remove("form-style")
            otherFieldUpper.classList.add("w-100")
            // select.name = 'streams';
            // otherStreamInput.name = 'other_stream';
        }

        select.addEventListener('change', function() {
            if (select.value === 'other') {
                otherField.style.display = 'block';
                otherFieldUpper.classList.add("form-style")
                otherFieldUpper.classList.remove("w-100")
                // select.name = '';
                // otherStreamInput.name = 'streams';
            } else {
                otherField.style.display = 'none';
                otherFieldUpper.classList.remove("form-style")
                otherFieldUpper.classList.add("w-100")
                // select.name = 'streams';
                // otherStreamInput.name = 'other_stream';
            }
        });
    });
</script>