<section class="common-sec login-page">
    <div class="container">
        <div class="common-title">Create <span>Question</span></div>
        <div class="justify-center w-100 d-flex">
            <div class="right question-create">
                <div class="text-center text-sec mb-0">
                    <div class="sub-title mb-0">Upload Questions for the Quiz</div>
                </div>
                <form wire:submit.prevent="save">
                    <div class="">
                        <div class="form-style">
                            <x-input-label for="selectedGroup" value="Select Group" />
                            <select wire:model.defer="selectedGroup" id="selectedGroup" name="selectedGroup" required class="block w-full mt-1">
                                <option value="">Select Group</option>
                                @foreach($groups as $groupId)
                                    <option value="{{ $groupId }}">Group {{ $groupId }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('selectedGroup')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="level" value="Select Level" />
                            <select wire:model.defer="level" id="level" name="level" required class="block w-full mt-1">
                                <option value="">Select Level</option>
                                <option value="1">Easy</option>
                                <option value="2">Medium</option>
                                <option value="3">Hard</option>
                            </select>
                            <x-input-error :messages="$errors->get('selectedGroup')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="text" value="Question text" />
                            <x-textarea wire:model.defer="question.text" id="text" class="block w-full mt-1" name="text" required></x-textarea>
                            <x-input-error :messages="$errors->get('question.text')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            @foreach ([1, 2, 3, 4] as $index)
                                <div class="items-end form-style d-flex add-form">
                                    <div class="lefts">
                                        <label>Option {{ $index }}</label>
                                        <x-text-input type="text" class="w-full" maxlength="250" wire:model.defer="options.{{ $index - 1 }}.text" name="options_{{ $index - 1 }}" id="options_{{ $index - 1 }}" autocomplete="off" />
                                    </div>
                                    <div class="flex items-center rights">
                                        <input type="checkbox" class="ml-4 mr-1"
                                               wire:model.defer="options.{{ $index - 1 }}.correct"> Correct
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('options.' . ($index - 1) . '.text')" class="mt-2" />
                            @endforeach
                        
                            {{-- Show error if no option is marked correct --}}
                            @error('options_correct')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror
                            @error('options_text')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="justify-center mt-8 d-flex">
                            <x-primary-button class="common-btn red common-btn short">Submit</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
