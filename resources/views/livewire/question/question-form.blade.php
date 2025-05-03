<section class="common-sec login-page">
    <div class="container">
        <div class="heading short">Create Question</div>
        <div class="justify-center w-100 d-flex">
            <div class="right question-create">
                <div class="text-center text-sec">
                    <div class="heading">Upload Questions for the Quiz</div>
                </div>
                <form wire:submit.prevent="save">
                    <div class="">
                        <div class="form-style">
                            <x-input-label for="selectedClassIds" value="Select Classes" />
                            <select wire:model.defer="selectedClassIds" id="selectedClassIds" multiple class="block w-full mt-1">
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('selectedClassIds')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="text" value="Question text" />
                            <x-textarea wire:model.defer="question.text" id="text" class="block w-full mt-1" name="text" required></x-textarea>
                            <x-input-error :messages="$errors->get('question.text')" class="mt-2" />
                        </div>

                        <div class="form-style">
                            <x-input-label for="image" value="Upload Image" />
                            <input wire:model="image" id="image" class="block w-full mt-1" type="file" name="image" accept="image/*" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                        
                        <div class="mt-4">
                            {{-- Option 1 --}}
                            <div class="items-end form-style d-flex add-form">
                                <div class="lefts">
                                    <label>Option 1</label>
                                    <x-text-input type="text" wire:model.defer="options.0.text" class="w-full" name="options_0" id="options_0" autocomplete="off" />
                                </div>
                                <div class="flex items-center rights">
                                    <input type="checkbox" class="ml-4 mr-1" wire:model.defer="options.0.correct"> Correct
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('options.0.text')" class="mt-2" />

                            {{-- Option 2 --}}
                            <div class="items-end form-style d-flex add-form">
                                <div class="lefts">
                                    <label>Option 2</label>
                                    <x-text-input type="text" wire:model.defer="options.1.text" class="w-full" name="options_1" id="options_1" autocomplete="off" />
                                </div>
                                <div class="flex items-center rights">
                                    <input type="checkbox" class="ml-4 mr-1" wire:model.defer="options.1.correct"> Correct
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('options.1.text')" class="mt-2" />

                            {{-- Option 3 --}}
                            <div class="items-end form-style d-flex add-form">
                                <div class="lefts">
                                    <label>Option 3</label>
                                    <x-text-input type="text" wire:model.defer="options.2.text" class="w-full" name="options_2" id="options_2" autocomplete="off" />
                                </div>
                                <div class="flex items-center rights">
                                    <input type="checkbox" class="ml-4 mr-1" wire:model.defer="options.2.correct"> Correct
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('options.2.text')" class="mt-2" />

                            {{-- Option 4 --}}
                            <div class="items-end form-style d-flex add-form">
                                <div class="lefts">
                                    <label>Option 4</label>
                                    <x-text-input type="text" wire:model.defer="options.3.text" class="w-full" name="options_3" id="options_3" autocomplete="off" />
                                </div>
                                <div class="flex items-center rights">
                                    <input type="checkbox" class="ml-4 mr-1" wire:model.defer="options.3.correct"> Correct
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('options.3.text')" class="mt-2" />
                        </div>


                        {{-- <div class="form-style">
                            <x-input-label for="code_snippet" value="Code snippet" />
                            <x-textarea wire:model.defer="question.code_snippet" id="code_snippet" class="block w-full mt-1" name="code_snippet"></x-textarea>
                            <x-input-error :messages="$errors->get('question.code_snippet')" class="mt-2" />
                        </div>

                        <div class="form-style">
                            <x-input-label for="answer_explanation" value="Answer explanation" />
                            <x-textarea wire:model.defer="question.answer_explanation" id="answer_explanation" class="block w-full mt-1" name="answer_explanation"></x-textarea>
                            <x-input-error :messages="$errors->get('question.answer_explanation')" class="mt-2" />
                        </div>

                        <div class="form-style">
                            <x-input-label for="more_info_link" value="More info link" />
                            <x-text-input wire:model.defer="question.more_info_link" id="more_info_link" class="block w-full mt-1" type="text" name="more_info_link" />
                            <x-input-error :messages="$errors->get('question.more_info_link')" class="mt-2" />
                        </div> --}}

                        <div class="justify-center mt-8 d-flex">
                            <x-primary-button>Submit</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
