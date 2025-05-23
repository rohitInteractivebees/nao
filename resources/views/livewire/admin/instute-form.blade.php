<section class="common-sec login-page">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Create School
        </h2>
    </x-slot>

    <x-slot name="title">
        Create School
    </x-slot>

    <div class="container d-flex justify-center">
        <div class="right question-create">
            <form wire:submit.prevent="save">
                <div class="form-style">
                    <x-input-label for="name" value="Name" />
                    <x-text-input wire:model="instute.name" id="name" class="block mt-1 w-full" type="text" name="name" required />
                    
                </div>
                <div class="d-flex justify-center mt-8">
                    <x-primary-button>
                        Save
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</section>
