<section class="common-sec login-page">
    <div class="container">
        <div class="w-100 d-flex justify-center">
            <div class="right question-create">
                <div class="text-sec text-center">
                    <div class="heading">Create Student</div>
                </div>
                <form wire:submit.prevent="save">
                    <div class="form-style">
                        <x-input-label for="name" value="Name" />
                        <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="email" value="Email" />
                        <x-text-input wire:model.defer="email"  class="block mt-1 w-full" type="email" name="email" required autocomplete="off"  />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="phone" value="Phone" />
                        <x-text-input wire:model.defer="phone" id="phone" maxlength="10" oninput="validatePhoneInput(this)"  class="block mt-1 w-full" type="text" name="phone" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="password" value="Password" />
                        <x-text-input wire:model.defer="password" id="password" class="block mt-1 w-full" type="password" name="password" required  autocomplete="off"  />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="streams" value="Streams" />
                        <select wire:model="streams" id="streams" class="block mt-1 w-full" name="streams">
                            <option value="" >Select Stream</option>
                            <option value="Aerospace Engineering">Aerospace Engineering</option>
                            <option value="Agricultural Engineering">Agricultural Engineering</option>
                            <option value="Biomedical Engineering">Biomedical Engineering</option>
                            <option value="Chemical Engineering">Chemical Engineering</option>
                            <option value="Civil Engineering">Civil Engineering</option>
                            <option value="Computer Engineering">Computer Engineering</option>
                            <option value="Electrical Engineering">Electrical Engineering</option>
                            <option value="Environmental Engineering">Environmental Engineering</option>
                            <option value="Industrial Engineering">Industrial Engineering</option>
                            <option value="Materials Engineering">Materials Engineering</option>
                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                            <option value="Software Engineering">Software Engineering</option>
                        </select>
                        <x-input-error :messages="$errors->get('streams')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="session_year" value="Session Year" />
                        <x-text-input wire:model.defer="session_year" id="session_year" class="block mt-1 w-full" type="text" name="session_year" />
                        <x-input-error :messages="$errors->get('session_year')" class="mt-2" />
                    </div>

                    <div class="d-flex justify-center mt-8">
                        <x-primary-button>Save</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

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
