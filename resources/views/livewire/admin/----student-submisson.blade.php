<section class="common-sec login-page">
    <div class="container d-flex justify-center">
        <div class="right question-create">
            <form id="submissionForm" wire:submit.prevent="uploadPrototype" enctype="multipart/form-data">
                @csrf

                <div class="form-style">
                    <x-input-label for="title" value="Title" />
                    <x-text-input wire:model.defer="title" id="title" class="block mt-1 w-full" type="text" name="title" required />
                    <span id="titleError" class="text-danger"></span>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="form-style">
                    <x-input-label for="description" value="Description" />
                    <textarea wire:model.defer="description" id="description" class="block mt-1 w-full" name="description" required></textarea>
                    <span id="descriptionError" class="text-danger"></span>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="form-style">
                    <x-input-label for="prototype_file" value="Choose File" />
                    <x-text-input wire:model.defer="prototype_file" id="prototype_file" class="block mt-1 w-full" type="file" name="prototype_file" required />
                    <x-input-error :messages="$errors->get('prototype_file')" class="mt-2" />
                </div>

                <div class="d-flex justify-center mt-8">
                    <x-primary-button>
                        Upload Prototype
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.getElementById('submissionForm').addEventListener('submit', function(event) {
    let isValid = true;

    // Clear previous error messages
    document.getElementById('titleError').textContent = '';
    document.getElementById('descriptionError').textContent = '';

    // Validate title
    const title = document.getElementById('title').value;
    if (title.length > 50) {
        document.getElementById('titleError').textContent = 'Title must not exceed 50 characters.';
        isValid = false;
    }

    // Validate description
    const description = document.getElementById('description').value;
    if (description.length > 250) {
        document.getElementById('descriptionError').textContent = 'Description must not exceed 250 characters.';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
    }
});
</script>
