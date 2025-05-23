<x-app-layout>
    <style>
        span.select2.select2-container.select2-container--default{
            border: 0.1rem solid #ccc !important;
            border-right: 0 !important;
        }
    </style>
    <section class="common-sec login-page profile-edit">
        <div class="container justify-end d-flex">
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
                    <div class="text-center text-sec mb-0">
                        <div class="common-title">Profile <span>Information </span></div>
                        <p>Update your account's profile information</p>
                    </div>
                    <section>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="post" action="{{ route('profile.update') }}" class="">
        @csrf
        @method('patch')
        <div class="justify-between half-view d-flex">
            <div class="form-style">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="block w-full mt-1" :value="old('name', $user->name)" required readonly autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            @php
                $institutes = App\Models\Instute::where('id',$user->institute)->first();
                if($user->institute == 'Other')
                {
                    $institutes = (object)[
                        'id' => $user->institute,
                        'name' => $user->school_name
                    ];
                }
                $countries = Illuminate\Support\Facades\DB::table('countries')
                            ->orderByRaw("CASE WHEN shortname = 'IN' THEN 0 ELSE 1 END")
                            ->orderBy('id', 'asc')
                            ->get();
            @endphp
            @if(auth()->user()->is_admin != 1)
            <div class="form-style">
                <x-input-label for="institute" :value="__('School')" />
                <select wire:model.defer="institute" id="institute" name="institute" class="block w-full mt-1" required>
                    <!-- <option value="" disabled>Select your institute</option> -->
                        <option value="{{ $institutes->id }}" {{ old('institute', $institutes->id) == $institutes->id ? 'selected' : '' }}>{{ $institutes->name }}</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('institute')" />
            </div>
            @endif

            @if(auth()->user()->is_college != 1 && auth()->user()->is_admin != 1)
                @php
                    $classIds = json_decode(auth()->user()->class, true);
                    $class = '';
            
                    if (!empty($classIds)) {
                        $classNames = \App\Models\Classess::whereIn('id', $classIds)->pluck('name')->toArray();
                        $class = implode(', ', $classNames);
                    }
                @endphp
            <div class="form-style">
                <x-input-label for="session_year" :value="__('Session year')" />
                <x-text-input id="session_year" name="session_year" type="text" readonly class="block w-full mt-1" :value="old('session_year', $user->session_year)" />
                <x-input-error class="mt-2" :messages="$errors->get('session_year')" />
            </div>
            <div class="form-style">
                <x-input-label for="class" :value="__('Class')" />
                <x-text-input id="class" name="class" type="text" readonly class="block w-full mt-1" :value="old('class', $class)" />
                <x-input-error class="mt-2" :messages="$errors->get('class')" />
            </div>
            @endif

            <div class="form-style">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="block w-full mt-1" :value="old('email', $user->email)" readonly autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm font-medium text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                    @endif
                </div>
                @endif
            </div>
            <div class="form-style">
                <x-input-label for="phone" :value="__('Phone')" />
                <div class="flex pincode-div">
                    <select name="country_code" id="country_code" class="form-control select2">
                        @foreach($countries as $country)
                            <option value="{{ $country->phonecode }}"
                                {{ (old('country_code') ?? $user->country_code ?? 91) == $country->phonecode ? 'selected' : '' }}>
                                +{{ $country->phonecode }} ({{ $country->shortname }})
                            </option>
                        @endforeach
                    </select>
                    <x-text-input id="phone" name="phone" type="text" readonly class="block w-full" :value="old('phone', $user->phone)" maxlength="10" oninput="validatePhoneInput(this)" required autofocus autocomplete="phone" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            @if(auth()->user()->is_college == 1)
                <div class="form-style">
                    <x-input-label :value="__('Registration Link')" />
                    <x-text-input type="text" class="block w-full mt-1" :value="url('/register') . '/' . $user->reg_no" readonly />
                </div>
            @endif
            
            <!--<div class="flex items-center justify-center gap-4 mt-8 w-100">-->
            <!--    <x-primary-button class="common-btn short">{{ __('Update Profile') }}</x-primary-button>-->

            <!--    @if (session('status') === 'profile-updated')-->
            <!--    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>-->
            <!--    @endif-->
            <!--</div>-->
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
