<div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6 text-gray-900">
                    <div class="item">
                        <div class="mb-0 sub-title">All Schools</div>
                        <div class="item md:w-2/5">
                    <div class="mt-4 md:mt-0">
                        <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name" class="form-control" style="border: 1px solid #ccc !important;">
                    </div>
                </div>
                    </div>
                    <div class="min-w-full mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">
                                        Sr.No
                                    </th>
                                    <th width="900">
                                        Name
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($instute as $index => $admin)
                                    <tr>
                                        <td>{{ $instute->firstItem() + $index }}</td>
                                        <td>
                                            {{ $admin->name }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 leading-5 text-center text-gray-900 whitespace-no-wrap">
                                            No School were found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $instute->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    span.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.dark\:bg-gray-800.dark\:border-gray-600 {
    background: #ccc;
}
</style>
