<x-app-layout>
    <Section class="banner-sec inner-banner">
        <div class="container">
            <div class="inner-content">
                <h2>Write a Testimonial</h2>
                <p>Real stories from real customers—see how we’ve made a difference.</p>
            </div>
        </div>
    </Section>
    <section class="review-form">
        <div class="container mx-auto">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="review-content">
                @php
                    $countries = Illuminate\Support\Facades\DB::table('countries')
                        ->orderByRaw("CASE WHEN shortname = 'IN' THEN 0 ELSE 1 END")
                        ->orderBy('id', 'asc')
                        ->get();
                @endphp
                <form method="POST" action="{{ route('testimonial.store') }}" enctype="multipart/form-data" class="register-form" id="formId">
                    @csrf
                    <ul>
                        <li>
                            <div class="input-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" placeholder="Enter Your Name" name="name"  id="name" value="{{ old('name') }}" required>
                                <span class="text-red-500 text-sm error-message">@error('name'){{ $message }}@enderror</span>
                            </div>
                        </li>
                        <li>
                            <div class="input-group">
                                <label for="school_name">School Name</label>
                                <input type="text" class="form-control" placeholder="Enter School Name" name="school_name" id="school_name" value="{{ old('school_name') }}" required>
                                <span class="text-red-500 text-sm error-message">@error('school_name'){{ $message }}@enderror</span>
                            </div>
                        </li>
                        <li>
                            <div class="input-group">
                                <label for="school">Mobile number</label>
                                <div class="flex pincode-div">
                                    <select class="form-control select2" name="country_code" id="country_code">
                                        @foreach($countries as $country)
                                            <option value="{{ $country->phonecode }}">+{{ $country->phonecode.'('.$country->shortname.')' }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" placeholder="Enter Mobile number" value="{{ old('mobile_number') }}" name="mobile_number" id="mobile_number" required minlength="7" maxlength="12" pattern="\d{7,12}" title="Mobile number must be 7 to 12 digits" oninput="validatePhoneInput(this)">
                                </div>
                                 <span class="text-gray-500 text-sm my-2">“Mobile number will not be published”</span>
                                <span class="text-red-500 text-sm error-message">@error('mobile_number'){{ $message }}@enderror</span>
                            </div>
                           
                        </li>
                        <li>
                            <div class="input-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" placeholder="Enter Your Email" name="email" id="email" value="{{ old('email') }}" required>
                                <span class="text-red-500 text-sm error-message">@error('email'){{ $message }}@enderror</span>
                            </div>
                        </li>
                        <li>
                            <div class="input-group">
                                <label for="category">Category</label>
                                <input type="text" class="form-control" placeholder="Enter your category" name="category" id="category" value="{{ old('category') }}" required>
                                <span class="text-red-500 text-sm error-message">@error('category'){{ $message }}@enderror</span>
                            </div>
                        </li>
                        <li>
                            <div class="input-group">
                                <label for="image">Upload Image</label>
                                <input type="file" class="form-control" name="image" id="image" required="">
                                <span class="text-red-500 text-sm error-message">@error('image'){{ $message }}@enderror</span>
                            </div>
                        </li>
                        <li class="w-full textarea-sec mr-8">
                            <div class="input-group mb-4">
                                <label for="message">Testimonial <span><sm></span></sm></label>
                                <textarea class="form-control w-full" placeholder="We’d love a detailed response — just keep it between 50 and 250 words." name="message" id="message" required>{{ old('message') }}</textarea>
                                <span class="text-red-500 text-sm error-message">@error('message'){{ $message }}@enderror</span>
                            </div>
                        </li>
                        <li class="w-full mb-3">
                             <label for="privacy" class="items-center privacy-center">
                                <input id="privacy" type="checkbox" class="" name="privacy" required>
                                <span class="ml-2 text-sm text-gray-600">By proceeding, you agree to our <a href="https://nao.asdc.org.in/privacy-policy" target="_blank">privacy policy</a> and consent to the collection and use of your data</span>
                                <span class="text-red-500 text-sm error-message  block mt-0"></span>
                            </label>
                        </li>
                        <li class="w-full" id="submit-btn">
                            <button type="submit" class="common-btn">
                                Submit
                            </button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </section>
    
</x-app-layout>
<script>
document.getElementById('formId').addEventListener('submit', function (e) {
    let isValid = true;

    // Clear all previous errors
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

    // Name validation (letters and spaces only)
    const name = document.getElementById('name');
    const nameRegex = /^[A-Za-z\s]+$/;
    if (!name.value.trim().match(nameRegex)) {
        showError(name, "Name must contain only letters and spaces.");
        isValid = false;
    }

    // School name (required already handled by HTML)

    // Mobile number
    const mobile = document.getElementById('mobile_number');
    const mobileRegex = /^\d{7,12}$/;
    if (!mobile.value.match(mobileRegex)) {
        showError(mobile, "Mobile number must be between 7 to 12 digits.");
        isValid = false;
    }

    // Email validation
    const email = document.getElementById('email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value.match(emailRegex)) {
        showError(email, "Enter a valid email address.");
        isValid = false;
    }

    // Category validation (letters and spaces only)
    const category = document.getElementById('category');
    if (!category.value.trim().match(nameRegex)) {
        showError(category, "Category must contain only letters and spaces.");
        isValid = false;
    }

    // Image validation
    const image = document.getElementById('image');
    if (image.files.length > 0) {
        const file = image.files[0];
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            showError(image, "Image must be a JPG, JPEG, or PNG.");
            isValid = false;
        }
        if (file.size > 2 * 1024 * 1024) {
            showError(image, "Image must be less than or equal to 2MB.");
            isValid = false;
        }
    } else {
        showError(image, "Please upload an image.");
        isValid = false;
    }

    const message = document.getElementById('message');
    const charCount = message.value.trim().length;
    if (charCount < 100) {
        showError(message, "Testimonial must be at least 100 characters.");
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault(); // Prevent form submission if invalid
    }
});

function showError(input, message) {
    const errorSpan = input.closest('.input-group').querySelector('.error-message');
    if (errorSpan) {
        errorSpan.textContent = message;
    }
}

// Optional: Allow only digits in mobile field
function validatePhoneInput(input) {
    input.value = input.value.replace(/[^\d]/g, '');
}
</script>
