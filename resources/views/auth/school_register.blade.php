<x-guest-layout>
    
    <section class="login-sec relative registration-page">
        <div class="login-banner">
            <div class="login-content">
                <div class="container mx-auto">
                    <div class="login-inner">
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <div class="common-title mb-0">Welcome,</div>
                        <p>Register to Participate</p>
                        <form method="POST" action="{{ route('school_register') }}" enctype="multipart/form-data" class="register-form mt-10">
                            @csrf
                    
                    
                            @php
                                $countries = Illuminate\Support\Facades\DB::table('countries')
                                    ->orderByRaw("CASE WHEN shortname = 'IN' THEN 0 ELSE 1 END")
                                    ->orderBy('id', 'asc')
                                    ->get();
                            @endphp
                            <ul>
                                <li>
                                    <div class="input-group">
                                        <label for="school">School Name</label>
                                        <input type="text" class="form-control" id="school" name="school" placeholder="Enter school name" value="{{ old('school') }}" required autofocus autocomplete="school">
                                        <span class="text-red-500 text-sm error-message">@error('school'){{ $message }}@enderror</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="input-group">
                                        <label for="principal_name">Principal Name</label>
                                        <input type="text" class="form-control" id="principal_name" name="principal_name" placeholder="Enter principal name" value="{{ old('principal_name') }}" required autofocus autocomplete="principal_name">
                                        <span class="text-red-500 text-sm error-message">@error('principal_name'){{ $message }}@enderror</span>
                                    </div>
                                </li>
                            
                                <li>
                                    <div class="input-group">
                                        <label for="principal_mobile">Principal Mobile</label>
                                        <div class="flex pincode-div">
                                            <select name="principal_country_code" id="principal_country_code" class="form-control select2">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->phonecode }}">+{{ $country->phonecode.'('.$country->shortname.')' }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control" id="principal_mobile" name="principal_mobile" placeholder="Enter principal mobile number" value="{{ old('principal_mobile') }}" required autofocus autocomplete="principal_mobile"  minlength="7" maxlength="12" pattern="\d{7,12}" title="Principal mobile number must be 7 to 12 digits" oninput="validatePhoneInput(this)">
                                            <span class="text-red-500 text-sm error-message">@error('principal_mobile'){{ $message }}@enderror</span>
                                        </div>
                                        
                                    </div>
                                </li>
                                <li>
                                    <div class="input-group">
                                        <label for="principal_email">Principal Email</label>
                                        <input type="email" class="form-control" id="principal_email" name="principal_email" placeholder="Enter principal email" value="{{ old('principal_email') }}" required autofocus autocomplete="principal_email">
                                        <span class="text-red-500 text-sm error-message">@error('principal_email'){{ $message }}@enderror</span>
                                        <div class="text-sm text-red-600" id="principal_email_error"></div>
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
                                        <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" value="{{ old('pincode') }}" required autofocus autocomplete="pincode"  minlength="4" maxlength="10" pattern="\d{4,10}" title="Pincode must be 4 to 10 digits">
                                        <span class="text-red-500 text-sm error-message">@error('pincode'){{ $message }}@enderror</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="input-group">
                                        <label for="spoc_name">SPOC Name</label>
                                        <input type="text" class="form-control" id="spoc_name" name="spoc_name" placeholder="Enter SPOC name" value="{{ old('spoc_name') }}" required autofocus autocomplete="spoc_name">
                                        <span class="text-red-500 text-sm error-message">@error('spoc_name'){{ $message }}@enderror</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="input-group">
                                        <label for="spoc_mobile">SPOC Mobile</label>
                                        <div class="flex pincode-div">
                                            <select name="spoc_country_code" id="spoc_country_code" class="form-control select2">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->phonecode }}">+{{ $country->phonecode.'('.$country->shortname.')' }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control" id="spoc_mobile" name="spoc_mobile" placeholder="Enter SPOC mobile" value="{{ old('spoc_mobile') }}" required autofocus autocomplete="spoc_mobile"  minlength="7" maxlength="12" pattern="\d{7,12}" title="Spoc mobile number must be 7 to 12 digits" oninput="validatePhoneInput(this)">
                                            <span class="text-red-500 text-sm error-message">@error('spoc_mobile'){{ $message }}@enderror</span>
                                        </div>
                                        
                                    </div>
                                </li>
                            
                                <li>
                                    <div class="input-group">
                                        <label for="spoc_email">SPOC Email</label>
                                        <input type="email" class="form-control" id="spoc_email" name="spoc_email" placeholder="Enter SPOC email" value="{{ old('spoc_email') }}" required autocomplete="spoc_email">
                                        <span class="text-red-500 text-sm error-message">@error('spoc_email'){{ $message }}@enderror</span>
                                    </div>
                                </li>
                                <li id="otp-container" style="{{ $errors->any() ? '' : 'display: none;' }}">
                                    <div class="input-group">
                                        <label for="otp">Enter OTP</label>
                                        <input type="text" class="form-control" maxlength="6" id="otp" name="otp" placeholder="Enter OTP" value="{{ old('otp') }}">
                                        <span class="text-red-500 text-sm error-message">@error('otp'){{ $message }}@enderror</span>
                                        <p id="otpMsg" style="color:green; {{ $errors->any()  ? 'display: none;' : '' }}">OTP send to your principal email id.</p>
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
                                <li class="w-full text-center" id="otpBtnContainer" style="{{ $errors->any() ? 'display: none;' : '' }}">
                                    <button type="button" class="common-btn" id="send-otp-btn">
                                        Send OTP
                                    </button>
                                </li>
                            
                                <!-- Register Button -->
                                <li class="w-full text-center" id="submit-btn" style="{{ $errors->any() ? '' : 'display: none;' }}">
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

document.getElementById('send-otp-btn').addEventListener('click', function () {
    
    const requiredInputs = document.querySelectorAll('.register-form input[required]');

    let isValid = true;
    
    const alphaOnlyFields = ['principal_name', 'country', 'state','city','spoc_name'];
    const nameRegex = /^[A-Za-z\s]+$/;
    
    const phoneFieldName = ['spoc_mobile', 'principal_mobile'];
    const phoneRegex = /^[0-9]{7,12}$/;
    
    const pincodeFieldName = 'pincode';
    const pincodeRegex = /^[0-9]{4,10}$/;
    
    const emailFields = ['spoc_email', 'principal_email']; // Add your email field names here
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
        } else if (phoneFieldName.includes(name) && !phoneRegex.test(value)) {
            errorSpan.textContent = 'Mobile number must be 7 to 12 digits';
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
    
    $(this).attr('disabled',true);
    
    var email = document.getElementById('principal_email').value;
    var school = document.getElementById('school').value;
    const emailError = document.getElementById('principal_email_error');

    // Clear any previous error
    emailError.textContent = '';
    fetch("{{ route('send.otp.school') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ principal_email: email, school:school })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                if (data.errors && data.errors.principal_email) {
                    emailError.textContent = data.errors.principal_email[0];
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

