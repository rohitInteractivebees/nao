<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Admins
        </h2>
    </x-slot>

    <x-slot name="title">
        Admins
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white sm:rounded-lg">
                <div class="">
                    <div class="mb-4">
                        <a href="{{ route('admin.create') }}"
                            class="common-btn short">
                            Create Admin
                        </a>
                    </div>

                    <div class="mt-4 mb-4 min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">
                                        ID
                                    </th>
                                    <th width="400">
                                        Name
                                    </th>
                                    <th width="400">
                                        Email
                                    </th>
                                    <th width="100" align="center">      
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @forelse($admins as $admin)
                                    <tr>
                                        <td>
                                            {{ $admin->id }}
                                        </td>
                                        <td>
                                            {{ $admin->name }}
                                        </td>
                                        <td>
                                            {{ $admin->email }}
                                        </td>
                                        <td align="center">
                                            <button wire:click="delete({{ $admin->id }})">
                                                <img src="{{ asset('/assets/images/icon-delete.png') }}" alt="">
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
                                            No admins were found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
