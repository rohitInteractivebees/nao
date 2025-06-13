
<section class="common-sec login-page">
    <div class="container">
        <div class="common-title">Edit Student Profile</div>
        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
        <div class="justify-center w-100 d-flex">
            <div class="right question-create">
                @php
                    $countries = Illuminate\Support\Facades\DB::table('countries')
                                ->orderByRaw("CASE WHEN shortname = 'IN' THEN 0 ELSE 1 END")
                                ->orderBy('id', 'asc')
                                ->get();
                    $institudes = App\Models\Instute::orderBy('id', 'asc')->get();
                    $classes = App\Models\Classess::orderBy('id', 'asc')->get();
                @endphp
                <form wire:submit.prevent="save">
                    <div class="">
                        <div class="form-style">
                            <x-input-label for="school_name" value="School" />
                            <select wire:model="school_name" name="school_name" required class="block w-full mt-1">
                                @foreach($institudes as $institude)
                                    <option value="{{ $institude->id }}">{{ $institude->name }}</option>
                                @endforeach
                                @if($school_name_text)
                                    <option value="Other">Other {{ $school_name_text ?? '' }}</option>
                                @endif
                            </select>
                            <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="class" value="Class" />
                            <select wire:model="class" name="class" required class="block w-full mt-1">
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('class')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="session_year" value="Session Year" />
                            <x-text-input id="session_year" wire:model="session_year" class="block w-full mt-1" name="session_year" required></x-text-input>
                            <x-input-error :messages="$errors->get('session_year')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="name" value="Student Name" />
                            <x-text-input id="name" wire:model="name" class="block w-full mt-1" name="name" required></x-text-input>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="parent_name" value="Parent Name" />
                            <x-text-input id="parent_name" wire:model="parent_name" class="block w-full mt-1" name="parent_name" required></x-text-input>
                            <x-input-error :messages="$errors->get('parent_name')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="phone" value="Parent Phone" />
                            <select wire:model="country_code" name="country_code" class="block w-full mt-1">
                                <option value="">Select Code</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->phonecode }}">
                                        +{{ $country->phonecode }} ({{ $country->shortname }})
                                    </option>
                                @endforeach
                            </select>
                            <x-text-input id="phone" wire:model="phone" class="block w-full mt-1" name="phone" ></x-text-input>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <div class="form-style">
                            <x-input-label for="password" value="Password" />
                            <x-text-input id="password" wire:model="password" class="block w-full mt-1" name="password"></x-text-input>
                            <p class="mt-2 text-sm text-gray-500">Leave blank to keep the current password.</p>
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

