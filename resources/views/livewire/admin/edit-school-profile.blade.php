
<section class="common-sec login-page">
    <div class="container">
        <div class="common-title">Edit School Profile</div>
        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<style>
    span.select2.select2-container.select2-container--default{
        border-color: #ccc !important;
    }
    .select2-container--default .select2-selection--single{
        height: 2.78rem;
    }
</style>
        <div class="justify-center w-100 d-flex">
            <div class="right question-create">
                @php
                    $countries = Illuminate\Support\Facades\DB::table('countries')
                                ->orderByRaw("CASE WHEN shortname = 'IN' THEN 0 ELSE 1 END")
                                ->orderBy('id', 'asc')
                                ->get();
                @endphp
                <form wire:submit.prevent="save">
                    <div class="">
                        <div class="form-style">
                            <x-input-label for="school_name" value="School Name" />
                            <x-text-input id="school_name" wire:model="school_name" class="block w-full mt-1" name="school_name" required></x-text-input>
                            <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="name" value="Principal Name" />
                            <x-text-input id="name" wire:model="name" class="block w-full mt-1" name="name" required></x-text-input>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="phone" value="Principal Phone" />
                            <div class="flex pincode-div items-end">
                            <select wire:model="country_code" name="country_code" class="block w-auto mt-1">
                                <option value="">Select Code</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->phonecode }}">
                                        +{{ $country->phonecode }} ({{ $country->shortname }})
                                    </option>
                                @endforeach
                            </select>
                            <x-text-input id="phone" wire:model="phone" class="block w-full mt-1" name="phone" required></x-text-input>
                            </div>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="parent_name" value="Spoc Name" />
                            <x-text-input id="parent_name" wire:model="parent_name" class="block w-full mt-1" name="parent_name" required></x-text-input>
                            <x-input-error :messages="$errors->get('parent_name')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="spoc_mobile" value="Spoc Mobile" />
                            <div class="flex pincode-div items-end">
                                <select id="spoc_country_code" wire:model="spoc_country_code" name="spoc_country_code" required class="block w-auto mt-1">
                                <option value="">Select Code</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->phonecode }}">
                                        +{{ $country->phonecode }} ({{ $country->shortname }})
                                    </option>
                                @endforeach
                            </select>
                            <x-text-input id="spoc_mobile" wire:model="spoc_mobile" class="block w-full mt-1" name="spoc_mobile" required></x-text-input>
                            </div>
                            
                            <x-input-error :messages="$errors->get('spoc_mobile')" class="mt-2" />
                        </div>
                        <div class="justify-center mt-8 d-flex">
                            <x-primary-button class="common-btn red short">Submit</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

