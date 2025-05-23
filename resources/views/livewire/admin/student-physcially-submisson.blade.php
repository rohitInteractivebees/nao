<section class="common-sec login-page validat-sec">
    <div class="container d-flex justify-center">
        <div class="right question-create">
            <form wire:submit.prevent="save" enctype="multipart/form-data" id="prototypeForm">
                @csrf
          
                <div class="form-style">
                    <label for="title3" class="btn btn-primary">Title</label>
                    <input class="block mt-1 w-full" type="text" wire:model.debounce.500ms="title3" id="title" maxlength="50">
                    <span id="titleError" class="text-danger"></span>
                   
                    @error('title3') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
               
                <div class="form-style">
                    <label for="description3" class="btn btn-primary">Description</label>
                    <textarea class="block mt-1 w-full" wire:model.debounce.500ms="description3" id="description" maxlength="500" ></textarea>
                    <span id="descriptionError" class="text-danger"></span>
                    @error('description3') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                <!-- <div class="form-style">
                    <label for="image3" class="btn btn-primary">Choose Image</label>
                    <input class="block mt-1 w-full" type="file" wire:model="image3">
                    <span id="image3" class="text-danger"></span>
                    @error('image3') <span class="text-danger">{{ $message }}</span> @enderror
                </div> -->
                
                <div class="form-style">
                    <label for="file" class="btn btn-primary">Choose File</label>
                    <input class="block mt-1 w-full" type="file" wire:model="file" id="prototype_file_level3">
                    <span id="prototypeFileError" class="text-danger"></span>
                    @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
               
                <div class="form-style">
                    @if($physicaly)
                        Please note: You can update only once until the submission date ends.
                    @endif
                </div>
               
                <div class="d-flex justify-center mt-8">
                    <button type="submit" id="submitButton" class="common-btn red">Upload</button>
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
    document.getElementById('prototype_file_level3').addEventListener('change', function() {
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
