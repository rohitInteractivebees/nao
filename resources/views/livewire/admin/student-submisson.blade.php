<section class="common-sec login-page validat-sec">
    <div class="container d-flex justify-center">
        <div class="right question-create">
            <form wire:submit.prevent="uploadPrototype" enctype="multipart/form-data" id="prototypeForm">
                @csrf

                <div class="form-style">
                    <label for="title" class="btn btn-primary">Title</label>
                    <input class="block mt-1 w-full" type="text" wire:model.debounce.500ms="title" id="title" maxlength="50">
                    <span id="titleError" class="text-danger"></span>
                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-style">
                    <label for="description" class="btn btn-primary">Description</label>
                    <textarea class="block mt-1 w-full" wire:model.debounce.500ms="description" id="description" maxlength="500"></textarea>
                    <span id="descriptionError" class="text-danger"></span>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-style">
                    <label for="prototype_file" class="btn btn-primary">Choose File</label>
                    <input class="block mt-1 w-full" type="file" wire:model="prototype_file" id="prototype_file">
                    <span id="prototypeFileError" class="text-danger"></span>
                    @error('prototype_file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-style">
                    @if($prototype)
                        Please note: You can update the prototype only once until the submission date ends.
                    @endif
                </div>
                <div class="d-flex justify-center mt-8">
                    <button type="submit" class="common-btn red" id="submitButton">Upload Prototype</button>
                </div>
            </form>
        </div>
    </div>
</section>
<section class="loader-sec no-require" id="loaders">
    <div class="inner">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</section>
<script>
    document.getElementById('prototype_file').addEventListener('change', function() {
    var loadersElement = document.getElementById("loaders");
    if (this.files && this.files.length > 0) {
        loadersElement.classList.remove("no-require");
        loadersElement.classList.add("d-flex");

        // Remove the class after 6 seconds
        setTimeout(function() {
            loadersElement.classList.add("no-require");
            loadersElement.classList.remove("d-flex");            
        }, 6000);
    } else {
        loadersElement.classList.remove("d-flex");
    }        
});
   
</script>


