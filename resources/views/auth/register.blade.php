<x-guest-layout>
    <div class="text-center text-sec">
        <div class="heading">Register to Participate</div>
    </div>
    <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
        @csrf


        @php
            $data = App\Models\Instute::where('status',1)->get();
            $data_classess = App\Models\Classess::get();
        @endphp

        <div class="justify-between half-view d-flex">
            <div class="form-style">
                <x-input-label for="school" :value="__('School')" />
                @if($institude_data != null)
                    <input type="text" class="block w-full mt-1" readonly value="{{ $institude_data->name }}" required />
                    <input type="hidden" value={{ $institude_data->id }} name="school" required />
                @else
                    <select id="school" class="block w-full mt-1" name="school" required>
                        <option value="" disabled selected>Select your School</option>
                        @foreach($data as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach

                    </select>
                @endif
                <x-input-error :messages="$errors->get('school')" class="mt-2" />
            </div>


            <div class="form-style">
                <x-input-label for="class" :value="__('Class')" />
                <select id="class" class="block w-full mt-1" name="class" required>
                    <option value="" disabled selected>Select your Class</option>
                    @foreach($data_classess as $val)
                        <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach

                </select>
                <x-input-error :messages="$errors->get('class')" class="mt-2" />
            </div>


            <div class="form-style">
                <x-input-label for="session_year" :value="__('Session Year')" />
                <input id="session_year" type="text" class="block w-full mt-1" name="session_year" required />
                <x-input-error :messages="$errors->get('session_year')" class="mt-2" />
            </div>




            <!-- Student Name -->
            <div class="form-style">
                <x-input-label for="student_name" :value="__('Student Name')" />
                <x-text-input id="student_name" class="block w-full mt-1" type="text" name="student_name" :value="old('student_name')" required
                    autofocus autocomplete="student_name" />
                <x-input-error :messages="$errors->get('student_name')" class="mt-2" />
            </div>
            <!-- Parent Name -->
            <div class="form-style">
                <x-input-label for="parent_name" :value="__('Parent Name')" />
                <x-text-input id="parent_name" class="block w-full mt-1" type="text" name="parent_name" :value="old('parent_name')" required
                    autofocus autocomplete="parent_name" />
                <x-input-error :messages="$errors->get('parent_name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="form-style">
                <x-input-label for="parent_email" :value="__('Parent Email')" />
                <x-text-input id="parent_email" class="block w-full mt-1" type="email" name="parent_email" :value="old('parent_email')"
                    required autocomplete="parent_email" />
                <x-input-error :messages="$errors->get('parent_email')" class="mt-2" />
            </div>

            <div class="form-style">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block w-full mt-1" type="text" name="phone" :value="old('phone')"
                    required autofocus autocomplete="phone" maxlength="10" oninput="validatePhoneInput(this)" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
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


            <div class="form-style">
                <x-input-label for="idcard" :value="__('School ID Card')" />
                <input id="idcard" type="file" class="block w-full mt-1" name="idcard" required />
                <x-input-error :messages="$errors->get('idcard')" class="mt-2" />
            </div>




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

