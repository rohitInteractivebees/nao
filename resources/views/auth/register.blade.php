<x-guest-layout>
   <section class="login-sec relative registration-page">
        <div class="login-banner">
            <div class="login-content">
                <div class="container mx-auto">
                    <div class="login-inner">
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <div class="common-title mb-0">Welcome,</div>
                        <p>Register to Participate</p>
                        <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data" class="register-form mt-10">
                            @csrf


                            @php
                                $data = App\Models\Instute::where('status',1)->get();
                                $data_classess = App\Models\Classess::get();
                                $countries = Illuminate\Support\Facades\DB::table('countries')
                                    ->orderByRaw("CASE WHEN shortname = 'IN' THEN 0 ELSE 1 END")
                                    ->orderBy('id', 'asc')
                                    ->get();
                            @endphp
                            <ul>
                                <li>
                                    <div class="input-group">
                                        <label for="user_id">School</label>
                                        @if($institude_data != null)
                                        <input type="text" class="requiredInput form-control w-full mt-1" readonly value="{{ $institude_data->name }}" required />
                                        <input type="hidden" value="{{ $institude_data->id }}" name="school" required />
                                        <span class="text-red-500 text-sm error-message">@error('school'){{ $message }}@enderror</span>
                                        @else
                                        <select id="school" class="requiredInput form-control" name="school" required onchange="toggleOtherSchool(this)">
                                            <option value="" disabled selected>Select your School</option>
                                            @foreach($data as $val)
                                                <option value="{{ $val->id }}" {{ old('school') == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>

                                            @endforeach
                                            <option value="Other" {{ old('school') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <span class="text-red-500 text-sm error-message">@error('school'){{ $message }}@enderror</span>
                                        @endif
                                    </div>
                                </li>
                                <li style="display:none;" id="other_school">
                                    <div class="input-group">
                                        <label for="class">School Name</label>
                                        <input type="text" id="school_name" class="requiredInput form-control" name="school_name" value="{{ old('school_name') }}" placeholder="Enter school name" autofocus autocomplete="school_name" />
                                        <span class="text-red-500 text-sm error-message">@error('school_name'){{ $message }}@enderror</span>
                                    </div>
                                    
                                </li>
                                <li>
                                    <div class="input-group">
                                        <label for="class">Class</label>
                                        <select id="class" class="requiredInput form-control" name="class" required>
                                            <option value="" disabled selected>Select your Class</option>
                                            @foreach($data_classess as $val)
                                                <option value="{{$val->id}}" {{ old('class') == $val->id ? 'selected' : '' }}>{{$val->name}}</option>
                                            @endforeach

                                        </select>
                                        <span class="text-red-500 text-sm error-message">@error('class'){{ $message }}@enderror</span>
                                    </div>
                                    
                                </li>
                                <li>
                                    <div class="input-group">
                                        <label for="session_year">Session Year</label>
                                        <input type="text" class="form-control"  id="session_year" name="session_year" value="{{ old('session_year') }}" placeholder="Enter Session Year"  required>
                                        <span class="text-red-500 text-sm error-message">@error('session_year'){{ $message }}@enderror</span>
                                    </div>
                                    
                                </li>
                                <li>
                                    <div class="input-group">
                                        <label for="student_name">Student Name</label>
                                        <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Enter student name" value="{{ old('student_name') }}" required autofocus autocomplete="student_name">
                                        <span class="text-red-500 text-sm error-message">@error('student_name'){{ $message }}@enderror</span>
                                    </div>
                                </li>

                                <li>
                                    <div class="input-group">
                                        <label for="parent_name">Parent Name</label>
                                        <input type="text" class="form-control" id="parent_name" name="parent_name" placeholder="Enter parent name" value="{{ old('parent_name') }}" required autofocus autocomplete="parent_name">
                                        <span class="text-red-500 text-sm error-message">@error('parent_name'){{ $message }}@enderror</span>
                                    </div>
                                </li>

                                <li>
                                    <div class="input-group">
                                        <label for="parent_email">Parent Email</label>
                                        <input type="email" class="form-control" id="parent_email" name="parent_email" placeholder="Enter parent email" value="{{ old('parent_email') }}" required autocomplete="parent_email">
                                        <div class="text-sm text-red-600" id="parent_email_error"></div>
                                        <span class="text-red-500 text-sm error-message">@error('parent_email'){{ $message }}@enderror</span>
                                    </div>
                                </li>

                                <li>
                                    <div class="input-group">
                                        <label for="parent_phone">Parent Phone</label>
                                        <div class="flex pincode-div">
                                            <select name="parent_country_code" id="parent_country_code" class="form-control select2">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->phonecode }}">+{{ $country->phonecode.'('.$country->shortname.')' }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control" id="parent_phone" name="parent_phone" placeholder="Enter parent phone number" value="{{ old('parent_phone') }}" required minlength="7" maxlength="12" pattern="\d{7,12}" title="Parent Phone number must be 7 to 12 digits" autofocus autocomplete="parent_phone" oninput="validatePhoneInput(this)">
                                            <span class="text-red-500 text-sm error-message">@error('parent_phone'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="input-group">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control" id="country" name="country" placeholder="Enter country" value="{{ old('country') }}" required autofocus autocomplete="country">
                                        <span class="text-red-500 text-sm error-message">@error('country'){{ $message }}@enderror</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="input-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" id="state" name="state" placeholder="Enter state" value="{{ old('state') }}" required autofocus autocomplete="state">
                                        <span class="text-red-500 text-sm error-message">@error('state'){{ $message }}@enderror</span>
                                    </div>
                                </li>

                                <li>
                                    <div class="input-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" value="{{ old('city') }}" required autofocus autocomplete="city">
                                        <span class="text-red-500 text-sm error-message">@error('city'){{ $message }}@enderror</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="input-group">
                                        <label for="pincode">Pincode</label>
                                        <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" value="{{ old('pincode') }}" required autofocus autocomplete="pincode" minlength="4" maxlength="10" pattern="\d{4,10}" title="Pincode must be 4 to 10 digits">
                                        <span class="text-red-500 text-sm error-message">@error('pincode'){{ $message }}@enderror</span>
                                    </div>
                                </li>
                                
                                <!-- OTP Field -->
                                <li id="otp-container" style="{{ $errors->any()  ? '' : 'display: none;' }}">
                                    <div class="input-group">
                                        <label for="otp">Enter OTP</label>
                                        <input type="text" class="form-control" maxlength="6" id="otp" name="otp" placeholder="Enter OTP" value="{{ old('otp') }}">
                                        <span class="text-red-500 text-sm error-message">@error('otp'){{ $message }}@enderror</span>
                                        <p id="otpMsg" style="color:green; {{ $errors->any()  ? 'display: none;' : '' }}">OTP sent to your parent email ID.</p>

                                    </div>
                                    
                                </li>
                                <li class="w-full mb-3">
                                     <label for="privacy" class="items-center privacy-center">
                                        <input id="privacy" type="checkbox" class="" name="privacy" required>
                                        <span class="ml-2 text-sm text-gray-600">By proceeding, you agree to our <a href="https://nao.asdc.org.in/privacy-policy" target="_blank">privacy policy</a> and consent to the collection and use of your data</span>
                                        <span class="text-red-500 text-sm error-message  block mt-0"></span>
                                    </label>
                                </li> 
                                <!-- Send OTP Button -->
                                <li class="w-full text-center" id="otpBtnContainer" style="{{ $errors->any()  ? 'display: none;' : '' }}">
                                    <button type="button" class="common-btn" id="send-otp-btn">
                                        Send OTP
                                    </button>
                                </li>
                            
                                <!-- Register Button -->
                                <li class="w-full text-center" id="submit-btn" style="{{ $errors->any()  ? '' : 'display: none;' }}">
                                    <button class="common-btn">
                                        {{ __('Register') }}
                                    </button>
                                </li>
                                <li class="w-full text-center">
                                    <div class="seprater-or">
                                        Or
                                    </div>
                                </li>
                                <li class="w-full text-center">
                                    <div class="register-account mb-2">
                                        <a href="{{ route('login') }}" class="login-btn">
                                            Already Registered? <span>{{ __('Sign in!') }}</span>
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

<script>
function validatePhoneInput(input) {
    // Allow only numbers
    input.value = input.value.replace(/\D/g, '');

    // Limit to 10 digits
    if (input.value.length > 12) {
        input.value = input.value.slice(0, 12);
    }
}
function toggleOtherSchool(select) {
    const otherSchool = document.getElementById('other_school');
    const schoolNameInput = document.getElementById('school_name');
    
    if (select.value === 'Other') {
        otherSchool.style.display = 'block';
        schoolNameInput.setAttribute('required', 'required');
    } else {
        otherSchool.style.display = 'none';
        schoolNameInput.removeAttribute('required');
    }
}
// Optional: handle old input (in case of validation failure)
document.addEventListener('DOMContentLoaded', function () {
    const selectedValue = document.getElementById('school').value;
    toggleOtherSchool({ value: selectedValue });
});
document.getElementById('send-otp-btn').addEventListener('click', function () {
    const requiredInputs = document.querySelectorAll('.register-form input[required], .register-form select[required]');
    
    let isValid = true;
    
    const alphaOnlyFields = ['student_name', 'parent_name', 'state', 'city'];
    const nameRegex = /^[A-Za-z\s]+$/;
    
    const phoneFieldName = 'parent_phone';
    const phoneRegex = /^[0-9]{7,12}$/;
    
    const pincodeFieldName = 'pincode';
    const pincodeRegex = /^[0-9]{4,10}$/;
    
    const emailFields = ['parent_email']; // Add your email field names here
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    
    requiredInputs.forEach(input => {
        const errorSpan = input.parentElement.querySelector('.error-message');
        const name = input.getAttribute('name');
        const value = input.value.trim();
        
        if (!value) {
            errorSpan.textContent = 'This field is required.';
            isValid = false;
        } else if (alphaOnlyFields.includes(name) && !nameRegex.test(value)) {
            errorSpan.textContent = 'Only letters and spaces are allowed.';
            isValid = false;
        } else if (name === phoneFieldName && !phoneRegex.test(value)) {
            errorSpan.textContent = 'Phone number must be 7 to 12 digits.';
            isValid = false;
        } else if (name === pincodeFieldName && !pincodeRegex.test(value)) {
            errorSpan.textContent = 'Pincode must be 4 to 10 digits.';
            isValid = false;
        } else if (emailFields.includes(name) && !emailRegex.test(value)) {
            errorSpan.textContent = 'Please enter a valid email address.';
            isValid = false;
        } else {
            errorSpan.textContent = '';
        }
    });
    // checkbox validation
    const privacyCheckbox = document.getElementById('privacy');
    const privacyError = privacyCheckbox.closest('label').querySelector('.error-message');
    if (!privacyCheckbox.checked) {
        privacyError.textContent = 'You must agree to the privacy policy.';
        isValid = false;
    } else {
        privacyError.textContent = '';
    }
    if (!isValid) {
        return;
    }
    
  //  $(this).attr('disabled',true);
    
    var email = document.getElementById('parent_email').value;
    var student_name = document.getElementById('student_name').value;
    const emailError = document.getElementById('parent_email_error');

    // Clear any previous error
    emailError.textContent = '';
    fetch("{{ route('send.otp') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ parent_email: email, student_name:student_name })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                if (data.errors && data.errors.parent_email) {
                    emailError.textContent = data.errors.parent_email[0];
                    $(this).attr('disabled',false);
                }
                throw new Error('Validation failed');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.message === 'OTP sent to your email') {
            // Show OTP field and Register button
            const otpInput = document.getElementById('otp');
            otpInput.setAttribute('required', 'required');
            document.getElementById('otpBtnContainer').style.display = 'none';
            document.getElementById('otp-container').style.display = 'block';
            document.getElementById('submit-btn').style.display = 'block';
        }
    })
    .catch(error => console.log(error));
});
</script>
