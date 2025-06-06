<div>

    <div class="py-12 pt-4 pb-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6 text-gray-900">
                    <div class="item">
                        <div class="sub-title">School Details</div>
                    </div>
                    {{-- <div class="mb-4">
                        <a href="{{ route('institute.create') }}"
                            class="common-btn short">
                            Create School
                        </a>
                    </div> --}}

                    <div class="min-w-full mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md pb-6">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">
                                        Sr.No
                                    </th>
                                    <th width="900">
                                        Name
                                    </th>
                                    <th width="900">
                                        Code
                                    </th>
                                    <th width="900">
                                        Register Link
                                    </th>
                                    <th width="900">
                                        Total Student
                                    </th>
                                    <th width="900">
                                        Participant Student
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
                                            {{ $admin->code }}
                                        </td>
                                        <td>
                                            @php
                                                $baseUrl = url('/register/')
                                            @endphp
                                            {{ $baseUrl . '/' . $admin->code }}
                                        </td>
                                        <td>
                                            @php
                                                $studenclg = App\Models\User::where('institute', $admin->id)->where('is_college', null)->get();
                                            @endphp
                                            {{count($studenclg)}}
                                        </td>
                                        <td>
                                            @php
                                                $partstudentCount = App\Models\Test::whereIn('user_id', $studenclg->pluck('id'))->distinct('user_id')->count('user_id');
                                            @endphp

                                            {{ $partstudentCount }}
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
