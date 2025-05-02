<section class="common-sec login-page">

    <div class="container">
        <div class="w-100 d-flex justify-center">
            <div class="right question-create">
                <form wire:submit.prevent="save">
                    <div class="form-style">
                        <x-input-label for="title" value="Title" />
                        <x-text-input wire:model="quiz.title" id="title" class="block mt-1 w-full" type="text" name="title" required />
                        <x-input-error :messages="$errors->get('quiz.title')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="slug" value="Slug" />
                        <x-text-input wire:model="quiz.slug" id="slug" class="block mt-1 w-full" type="text" name="slug" disabled />
                        <x-input-error :messages="$errors->get('quiz.slug')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="description" value="Description" />
                        <x-textarea wire:model="quiz.description" id="description" class="block mt-1 w-full" type="text" name="description" />
                        <x-input-error :messages="$errors->get('quiz.description')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="questions" value="Questions" />
                        <x-select-list class="w-full" id="questions" name="questions" :options="$this->listsForFields['questions']" wire:model="questions" multiple />
                        <x-input-error :messages="$errors->get('questions')" class="mt-2" />
                    </div>
                    <div class="w-100 d-flex item-center">
                        <div class="form-style">
                            <div class="flex items-center">                                
                                <input type="checkbox" id="published" class="mr-1 ml-2" wire:model="quiz.published">
                                <x-input-label for="published" value="Publish Quiz" />
                            </div>
                            <x-input-error :messages="$errors->get('quiz.published ')" class="mt-2" />
                        </div>

                        <!-- <div class="form-style">
                            <div class="flex items-center">                                
                                <input type="checkbox" id="public" class="mr-1 ml-2" wire:model="quiz.public">
                                <x-input-label for="public" value="Public" />
                            </div>
                            <x-input-error :messages="$errors->get('quiz.public')" class="mt-2" />
                        </div> -->

                        <div class="form-style">
                            <div class="flex items-center">                                
                                <input type="checkbox" id="result_show" class="mr-1 ml-2" wire:model="quiz.result_show">
                                <x-input-label for="result_show" value="Publish Result" />
                            </div>
                            <x-input-error :messages="$errors->get('quiz.result_show')" class="mt-2" />
                        </div>
                    </div>


                    <div class="d-flex justify-center mt-8">
                        <x-primary-button>
                            Save
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<style>
    body{
        overflow-x: hidden;
    }
</style>