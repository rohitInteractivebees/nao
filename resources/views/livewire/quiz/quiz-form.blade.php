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
                        <select wire:model="selectedGroup" id="selectedGroup" name="selectedGroup" required class="block w-full mt-1">
                            <option value="" >Select Group</option>
                            @foreach($groups as $groupId)
                                <option value="{{ $groupId }}">Group {{ $groupId }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('selectedGroup')" class="mt-2" />
                    </div>
                    <div class="form-style">
                        <x-input-label for="title" value="Title" />
                        <x-text-input wire:model="quiz.title" id="title" class="block w-full mt-1" type="text" name="title" required />
                        <x-input-error :messages="$errors->get('quiz.title')" class="mt-2" />
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
                    <div class="justify-center mt-8 d-flex">
                        <x-primary-button class="common-btn red common-btn short">
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
