<div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6 text-gray-900">
                    {{-- <div class="mb-4">
                        <a href="{{ route('institute.create') }}"
                            class="common-btn short">
                            Create School
                        </a>
                    </div> --}}

                    <div class="min-w-full mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">
                                        ID
                                    </th>
                                    <th width="900">
                                        Name
                                    </th>
                                    <th width="900">
                                        Status
                                    </th>
                                    <th width="100" align="center">
                                        Action
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
                                        <td>
                                            @if($admin->status == 0)
                                                <button type="button" class="table-btn red no-hov no-pointer">Not Verified</button>
                                            @elseif($admin->status == 1)
                                                <button type="button" class="table-btn green no-hov no-pointer">Verified</button>
                                            @endif
                                        </td>
                                        <td>
                                        <a href="{{ route('institute.edit',  $admin->id ) }}">
                                            <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="">
                                        </a>
                                            {{-- <a href="{{ route('institute.delete',  $admin->id ) }}">
                                                <img src="{{ asset('/assets/images/icon-delete.png') }}" alt="">
                                            </a> --}}
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
