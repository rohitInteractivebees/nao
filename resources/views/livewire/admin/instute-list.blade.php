<div>

    <div class="py-12 pt-4 pb-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="px-6 text-gray-900">
                    <div class="items-center flex-wrap gap-2 justify-between my-4 md:flex">
                        <div class="sub-title mb-0 text-center">School Details</div>
                        <div class="md:mt-0 mt-4">
                            <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name or code" class="form-control" style="border: 1px solid #ccc !important;">
                        </div>
                    </div>
                    
                    {{-- <div class="mb-4">
                        <a href="{{ route('institute.create') }}"
                            class="common-btn short">
                            Create School
                        </a>
                    </div> --}}

                    <div class="min-w-full pb-6 mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md min-h-[60vh]">
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
                                            <a href="{{ route('schoolStudents') . '?school='.$admin->id }}">{{count($studenclg)}}</a>
                                        </td>
                                        <td>
                                            @php
                                                $partstudentCount = App\Models\Test::whereIn('user_id', $studenclg->pluck('id'))->distinct('user_id')->count('user_id');
                                            @endphp

                                            <a href="{{ route('schoolStudentsParticipents') . '?school='.$admin->id }}">{{ $partstudentCount }}</a>
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
