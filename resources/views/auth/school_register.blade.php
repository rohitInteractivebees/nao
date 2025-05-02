<x-guest-layout>
    <div class="text-center text-sec">
        <div class="heading">School Register</div>
    </div>
    <form method="POST" action="{{ route('school_register') }}" enctype="multipart/form-data">
        @csrf


        {{-- @php
            $data = App\Models\Instute::get();
        @endphp --}}

        <div class="justify-between half-view d-flex">
            <div class="form-style">
                <x-input-label for="school" :value="__('School Name')" />
                <x-text-input id="school" class="block w-full mt-1" type="text" name="school" :value="old('school')" required
                    autofocus autocomplete="school" />
                <x-input-error :messages="$errors->get('school')" class="mt-2" />
            </div>


            {{-- <div class="form-style">
                <x-input-label for="class" :value="__('Class')" />
                <select id="class" class="block w-full mt-1" name="class" required>
                    <option value="" disabled selected>Select your Class</option>
                    @foreach($data_classess as $val)
                        <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach

                </select>
                <x-input-error :messages="$errors->get('class')" class="mt-2" />
            </div> --}}


            {{-- <div class="form-style">
                <x-input-label for="session_year" :value="__('Session Year')" />
                <input id="session_year" type="text" class="block w-full mt-1" name="session_year" required />
                <x-input-error :messages="$errors->get('session_year')" class="mt-2" />
            </div> --}}




            <!-- Student Name -->
            <div class="form-style">
                <x-input-label for="principal_name" :value="__('Principal Name')" />
                <x-text-input id="principal_name" class="block w-full mt-1" type="text" name="principal_name" :value="old('principal_name')" required
                    autofocus autocomplete="principal_name" />
                <x-input-error :messages="$errors->get('principal_name')" class="mt-2" />
            </div>
            <div class="form-style">
                <x-input-label for="mobile" :value="__('Mobile')" />
                <x-text-input id="mobile" class="block w-full mt-1" type="text" name="mobile" :value="old('mobile')"
                    required autofocus autocomplete="mobile" maxlength="10" oninput="validatePhoneInput(this)" />
                <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
            </div>
            <!-- Country -->
            <div class="form-style">
                <x-input-label for="country" :value="__('Country')" />
                <x-text-input id="country" class="block w-full mt-1" type="text" name="country" :value="old('country')" required
                    autofocus autocomplete="country" />
                <x-input-error :messages="$errors->get('country')" class="mt-2" />
            </div>
            <!-- State -->
            <div class="form-style">
                <x-input-label for="state" :value="__('State')" />
                <x-text-input id="state" class="block w-full mt-1" type="text" name="state" :value="old('student_name')" required
                    autofocus autocomplete="state" />
                <x-input-error :messages="$errors->get('state')" class="mt-2" />
            </div>
            <!-- City -->
            <div class="form-style">
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" class="block w-full mt-1" type="text" name="city" :value="old('city')" required
                    autofocus autocomplete="city" />
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>
            <!-- Parent Name -->
            <div class="form-style">
                <x-input-label for="spoc_name" :value="__('Spoc Name')" />
                <x-text-input id="spoc_name" class="block w-full mt-1" type="text" name="spoc_name" :value="old('spoc_name')" required
                    autofocus autocomplete="spoc_name" />
                <x-input-error :messages="$errors->get('spoc_name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="form-style">
                <x-input-label for="spoc_email" :value="__('Spoc Email')" />
                <x-text-input id="spoc_email" class="block w-full mt-1" type="email" name="spoc_email" :value="old('spoc_email')"
                    required autocomplete="spoc_email" />
                <x-input-error :messages="$errors->get('spoc_email')" class="mt-2" />
            </div>
            <!-- Email Address -->
            <div class="form-style">
                <x-input-label for="spoc_mobile" :value="__('Spoc Mobile')" />
                <x-text-input id="spoc_mobile" class="block w-full mt-1" type="text" name="spoc_mobile" :value="old('spoc_mobile')"
                required autofocus autocomplete="spoc_mobile" maxlength="10" oninput="validatePhoneInput(this)" />
                <x-input-error :messages="$errors->get('spoc_mobile')" class="mt-2" />
            </div>





            {{-- <div class="form-style">
                <x-input-label for="idcard" :value="__('School ID Card')" />
                <input id="idcard" type="file" class="block w-full mt-1" name="idcard" required />
                <x-input-error :messages="$errors->get('idcard')" class="mt-2" />
            </div> --}}




            <!-- Password -->
            <div class="form-style">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="form-style">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block w-full mt-1" type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center mt-8 w-100">
                <x-primary-button class="ml-5">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
            <div class="register-account w-100">
                <a href="{{ route('login') }}">
                    Already Registered? <span>{{ __('Sign in!') }}</span>
                </a>
            </div>
        </div>
    </form>

</x-guest-layout>

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

