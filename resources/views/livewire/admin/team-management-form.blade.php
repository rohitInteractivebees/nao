<section class="common-sec login-page">
    <div class="container">
        <div class="w-100 d-flex justify-center">
            <div class="right question-create">

                @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif

                <form wire:submit.prevent="save" id="teamForm">
                    <div class="form-style">
                        <x-input-label for="name" value="Team Name" />
                        <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                                    <div class="form-style">
                    <label class="block font-medium text-sm text-gray-700 mb-2" for="teammember">Team Member</label>
                    <select wire:model.defer="teammember" id="teammember" class="block mt-1 w-full" multiple>
                        @foreach($students as $member)
                            <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->email }})</option>
                        @endforeach
                    </select>

                    <p id="min3" style="color:red; display: none;">Please select exactly 3 members*</p>
                    
                </div>

                    <div class="form-style">
                        <x-input-label for="mentorName" value="Mentor Name" />
                        <x-text-input wire:model.defer="mentorName" id="mentorName" class="block mt-1 w-full" type="text" required />
                        <x-input-error :messages="$errors->get('mentorName')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="mentorDetails" value="Mentor Details" />
                        <textarea wire:model.defer="mentorDetails" id="mentorDetails" class="block mt-1 w-full"></textarea>
                        <x-input-error :messages="$errors->get('mentorDetails')" class="mt-2" />
                    </div>

                    <div class="form-style">
                        <x-input-label for="mentorType" value="Mentor Type" />
                        <select wire:model.defer="mentorType" id="mentorType" class="block mt-1 w-full">
                            <option value="Internal">Internal</option>
                            <option value="External">External</option>
                        </select>
                        <x-input-error :messages="$errors->get('mentorType')" class="mt-2" />
                    </div>

                    <div class="d-flex justify-center mt-8">
    <x-primary-button id="submitBtn">
        Save
    </x-primary-button>
</div>
                </form>

            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script>
    function initSelect2() {
        let userInteracted = false;

        $('#teammember').select2({
            maximumSelectionLength: 3,
            placeholder: 'Select Team Member'
        }).on('change', function(e) {
            let selectedValues = $(this).val();
            @this.set('teammember', selectedValues);
            userInteracted = true;

            // Check the number of selected options
            if (selectedValues.length === 3) {
                $('#submitBtn').prop('disabled', false);
                $('#min3').hide();
            } else {
                $('#submitBtn').prop('disabled', true);
                if (userInteracted) {
                    //$('#min3').show();
                }
            }
        });

        // Initialize the submit button state and error message
        let initialSelectedValues = $('#teammember').val();
        if (initialSelectedValues.length === 3) {
            $('#submitBtn').prop('disabled', false);
            $('#min3').hide();
        } else {
            $('#submitBtn').prop('disabled', true);
            
            $('#min3').show(); // Do not show error initially
        }
    }

    document.addEventListener('livewire:load', function() {
        initSelect2();
    });

    document.addEventListener('livewire:update', function() {
        initSelect2();
    });
</script>