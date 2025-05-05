<section class="common-sec login-page">

    <div class="container">
        <div class="justify-center w-100 d-flex">

            <div class="right question-create">
                @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
                <form wire:submit.prevent="save">
                    <div class="form-style">
                        <x-input-label for="class_ids" value="Select Class" />
                        <select wire:model="quiz.class_ids" id="class_ids" name="class_ids" required class="block w-full mt-1">
                            <option value="" >Select Class</option>
                            @foreach ($classes as $class)
                                @php
                                    $question_count = App\Models\Question::whereJsonContains('class_ids', (string)$class->id)->count();
                                @endphp
                                <option value="{{ $class->id }}" >{{ $class->name }} — {{ $question_count }} questions</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('quiz.class_ids')" class="mt-2" />
                    </div>
                    <div class="form-style">
                        <x-input-label for="title" value="Title" />
                        <x-text-input wire:model="quiz.title" id="title" class="block w-full mt-1" type="text" name="title" required />
                        <x-input-error :messages="$errors->get('quiz.title')" class="mt-2" />
                    </div>

                    {{-- <div class="form-style">
                        <x-input-label for="slug" value="Slug" />
                        <x-text-input wire:model="quiz.slug" id="slug" class="block w-full mt-1" type="text" name="slug" disabled />
                        <x-input-error :messages="$errors->get('quiz.slug')" class="mt-2" />
                    </div> --}}

                    <div class="form-style">
                        <x-input-label for="description" value="Description" />
                        <x-textarea wire:model="quiz.description" id="description" class="block w-full mt-1" type="text" name="description" />
                        <x-input-error :messages="$errors->get('quiz.description')" class="mt-2" />
                    </div>
                    <div class="form-style">
                        <x-input-label for="duration" value="Duration" />
                        <x-text-input type="number" wire:model="quiz.duration" id="duration" class="block w-full mt-1" name="duration" required />
                        <x-input-error :messages="$errors->get('quiz.duration')" class="mt-2" />
                    </div>
                    <div class="form-style">
                        <x-input-label for="start_date" value="Quiz Start Date & Time" />
                        <x-text-input wire:model="quiz.start_date" id="start_date" class="block w-full mt-1" type="datetime-local" name="start_date" required />
                        <x-input-error :messages="$errors->get('quiz.start_date')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="end_date" value="Quiz End Date & Time" />
                        <x-text-input wire:model="quiz.end_date" id="end_date" class="block w-full mt-1" type="datetime-local" name="end_date" required />
                        <x-input-error :messages="$errors->get('quiz.end_date')" class="mt-2" />
                    </div>
                    <div class="form-style">
                        <x-input-label for="result_date" value="Result Date & Time" />
                        <x-text-input wire:model="quiz.result_date" id="result_date" class="block w-full mt-1" type="datetime-local" name="result_date" required />
                        <x-input-error :messages="$errors->get('quiz.result_date')" class="mt-2" />
                    </div>
                    <div class="form-style">
                        <x-input-label for="total_question" value="Total Questions" />
                        <x-text-input wire:model="quiz.total_question" id="total_question" class="block w-full mt-1" type="number" name="total_question" required />
                        <x-input-error :messages="$errors->get('quiz.total_question')" class="mt-2" />
                    </div>

                    {{-- <div class="form-style">
                        <x-input-label for="questions" value="Questions" />

                        <div wire:key="questions-{{ implode(',', array_keys($questionOptions)) }}">
                            @if (!empty($questionOptions))
                                <x-select-list class="w-full" id="questions" name="questions"
                                    :options="$questionOptions" wire:model="questions" required multiple />
                            @else
                                <div class="mt-2 text-sm text-gray-500">
                                    Please select a class to load related questions.
                                </div>
                            @endif
                        </div>


                        <x-input-error :messages="$errors->get('questions')" class="mt-2" />
                    </div> --}}
                    {{-- <div class="form-style">
                        <x-input-label for="questions" value="Questions" />
                        <x-select-list class="w-full" id="questions" name="questions" :options="$this->listsForFields['questions']" wire:model="questions" required multiple />
                        <x-input-error :messages="$errors->get('questions')" class="mt-2" />
                    </div> --}}
                    {{-- <div class="w-100 d-flex item-center">
                        <div class="form-style">
                            <div class="flex items-center">
                                <input type="checkbox" id="published" class="ml-2 mr-1" wire:model="quiz.published">
                                <x-input-label for="published" value="Publish Quiz" />
                            </div>
                            <x-input-error :messages="$errors->get('quiz.published ')" class="mt-2" />
                        </div>

                        <div class="form-style">
                            <div class="flex items-center">
                                <input type="checkbox" id="public" class="ml-2 mr-1" wire:model="quiz.public">
                                <x-input-label for="public" value="Public" />
                            </div>
                            <x-input-error :messages="$errors->get('quiz.public')" class="mt-2" />
                        </div>

                        <div class="form-style">
                            <div class="flex items-center">
                                <input type="checkbox" id="result_show" class="ml-2 mr-1" wire:model="quiz.result_show">
                                <x-input-label for="result_show" value="Publish Result" />
                            </div>
                            <x-input-error :messages="$errors->get('quiz.result_show')" class="mt-2" />
                        </div>
                    </div> --}}


                    <div class="justify-center mt-8 d-flex">
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
