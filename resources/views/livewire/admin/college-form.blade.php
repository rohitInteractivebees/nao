<section class="common-sec login-page">
    <div class="container d-flex justify-center">
        <div class="right question-create">
            <form wire:submit.prevent="save">
                <div class="form-style">
                    <x-input-label for="name" value="Name" />
                    <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="form-style">
                    <x-input-label for="email" value="Email Address" />
                    <x-text-input wire:model.defer="email" id="email" class="block mt-1 w-full" type="email" name="email" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="form-style">
                    <x-input-label for="password" value="Password" />
                    <x-text-input wire:model.defer="password" id="password" class="block mt-1 w-full" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                @php
                $data = App\Models\Instute::get();
                @endphp
                <div class="form-style">
                    <x-input-label for="institute" value="School" />
                    <select wire:model.defer="institute" id="institute" class="block mt-1 w-full" name="institute" required>
                        <option>Select your School</option>
                        @foreach($data as $val)
                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                        @endforeach
                    </select>
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
