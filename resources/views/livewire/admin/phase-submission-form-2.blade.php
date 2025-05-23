<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Manage Submissions' }}
        </h2>
    </x-slot>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="mt-4">
            <x-input-label for="teamId" value="Team ID" />
            <x-text-input wire:model.defer="teamId" id="teamId" class="block mt-1 w-full" type="text" required />
            <x-input-error :messages="$errors->get('teamId')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="file" value="Upload File" />
            <input type="file" wire:model="file" id="file" class="block mt-1 w-full" required />
            <x-input-error :messages="$errors->get('file')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-primary-button>
                Save
            </x-primary-button>
        </div>
    </form>

    <div class="mt-12">
        <h3 class="text-lg font-semibold">Submissions</h3>
        <table class="table-auto w-full mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">File Name</th>
                    <th class="px-4 py-2">File Type</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submissions as $submission)
                    <tr>
                        <td class="border px-4 py-2">{{ $submission->SubmissionID }}</td>
                        <td class="border px-4 py-2">{{ $submission->FileName }}</td>
                        <td class="border px-4 py-2">{{ $submission->FileType }}</td>
                        <td class="border px-4 py-2">
                            <button wire:click="edit({{ $submission->SubmissionID }})" class="bg-blue-500 text-white px-4 py-2 rounded">Edit</button>
                            <button wire:click="delete({{ $submission->SubmissionID }})" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($selectedSubmission)
        <form wire:submit.prevent="update" enctype="multipart/form-data">
            <div class="mt-4">
                <x-input-label for="fileName" value="Edit File Name" />
                <x-text-input wire:model.defer="fileName" id="fileName" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('fileName')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="file" value="Upload New File (optional)" />
                <input type="file" wire:model="file" id="file" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('file')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-primary-button>
                    Update
                </x-primary-button>
            </div>
        </form>
    @endif
</div>
