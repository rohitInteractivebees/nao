<div>
       <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="overflow-hidden bg-white">
                <div class="mt-0 form-style">
                    <div class="items-center justify-between gap-3 px-3 mt-4 item md:flex md:px-0">
                        <div class="item">
                            <div class="text-center md:mb-0 sub-title">Quiz Attempt Tracker</div>
                        </div>
                        <div class="items-center justify-end gap-3 text-center item md:flex md:w-3/5">
                            <select class="p-3 m-auto md:w-auto md:m-0"
                                wire:model="quiz_id">
                                <option value="0">All School</option>
                                @foreach ($college as $quiz)
                                    <option value="{{ $quiz->id }}">{{ $quiz->name }}</option>
                                @endforeach
                                <option value="Other">Other</option>
                            </select>

                            <div class="mt-0 text-center item filter-options form-style">
                                <select class="block m-auto mt-3 md:m-0 " wire:model="class_id" name="class_id">
                                    <option value="0">All Classes</option>
                                    @foreach(App\Models\Classess::all() as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="item md:w-2/5">
                                <div class="mt-4 md:mt-0">
                                    <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name, email, phone or parent name..." class="form-control" style="border: 1px solid #ccc !important;">
                                </div>
                            </div>
                         </div>
                    </div>
                    <div class="min-w-full mt-6 mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                    <table class="table w-full mt-4 table-view">
                        <thead>
                            <tr>
                                <th width="100">
                                    Sr.No
                                </th>
                                <th width="300">School Name</th>
                                <th width="200">
                                    Student Name
                                </th>
                                <th width="300">Student ID</th>
                                <th width="200">
                                    Class
                                </th>
                                <th width="200">
                                    Parent Email
                                </th>
                                <th width="200">
                                    Parent Phone
                                </th>
                                <th width="100">
                                    Marks
                                </th>

                                <th width="150">
                                    Time Spent
                                </th>
                                <th width="150">
                                    Result
                                </th>
                                <th width="100" align="center">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($tests as $index => $test)
                                <tr>
                                    <td>{{ $tests->firstItem() + $index }}</td>
                                    <td>
                                    @php
                                        if($test->user->institute != 'Other')
                                        {
                                            $instituteName = App\Models\Instute::where('id', $test->user->institute)->value('name');

                                        }else{
                                            $instituteName = $test->user->institute.' ('.$test->user->school_name.')';
                                        }
                                        @endphp
                                        {{ $instituteName }}
                                    </td>
                                    <td>
                                        {{ $test->user->name ?? 'Guest' }}
                                    </td>
                                    <td>
                                        {{ $test->user->loginId }}
                                    </td>
                                    <td>{{ !empty($test->user->email) ? $test->user->email : 'N/A' }}</td>
                                    <td>
                                        {{ \App\Models\Classess::whereIn('id', json_decode($test->user->class))->pluck('name')->join(', ') }}
                                    </td>
                                    <td>
                                        @if($test->user->country_code || $test->user->phone)
                                            +{{ trim($test->user->country_code.' '.$test->user->phone) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <td>
                                        {{ $test->result . '/' . $test->questions_count }}
                                    </td>

                                    <td>
                                        {{ intval($test->time_spent / 60) >= $test->quiz->duration ? $test->quiz->duration : intval($test->time_spent / 60) }}:{{ intval($test->time_spent / 60) >= $test->quiz->duration ? '00' : gmdate('s', $test->time_spent) }} minutes
                                    </td>
                                    <td>
                                        @php
                                            $marks_percent = ($test->questions_count * $test->quiz->pass_fail_percent / 100 );
                                        @endphp
                                        @if($test->result >= $marks_percent)
                                            <div class="table-btn green no-hov"><span class="">Pass</span></div>
                                        @else
                                            <div class="table-btn red no-hov"><span class="">Fail </span></div>
                                        @endif
                                    </td>
                                    <td align="center">
                                        <a href="{{ route('results.show', $test) }}">
                                            <img src="{{ asset('/assets/images/icon-view.png') }}" alt="" class="w-6 h-auto">
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8"
                                        class="px-6 py-4 leading-5 text-center text-gray-900 whitespace-no-wrap">
                                        No tests were found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                    <div class="mt-3">
                        {{ $tests->links() }}
                    </div>
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
