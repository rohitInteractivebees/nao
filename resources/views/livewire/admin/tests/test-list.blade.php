<div>
       <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white">
                <div class="form-style">
                    <div class="items-center justify-end gap-3 mt-4 item md:flex">
                        <div class="item">
                            <select class="w-full p-3 mb-3 text-sm leading-5 text-slate-600"
                                wire:model="quiz_id">
                                <option value="0">All School</option>
                                @foreach ($college as $quiz)
                                    <option value="{{ $quiz->id }}">{{ $quiz->name }}</option>
                                @endforeach
                                <option value="Other">Other</option>
                            </select>
                            <div class="mt-0 item filter-options form-style">
                                <select class="block w-full mt-1" wire:model="class_id" name="class_id">
                                    <option value="0">All Classes</option>
                                    @foreach(App\Models\Classess::all() as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                         </div>
                    </div>
                    <table class="table w-full mt-4 table-view">
                        <thead>
                            <tr>
                                <th width="100">
                                    Sr.No
                                </th>
                                <th width="200">
                                    Student Name
                                </th>
                                <th width="200">
                                    Parent Email
                                </th>
                                <th width="200">
                                    Class
                                </th>
                                <th width="300">
                                    School
                                </th>
                                <th width="100">
                                    Result
                                </th>

                                <th width="150">
                                    Time Spent
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
                                        {{ $test->user->name ?? 'Guest' }}
                                    </td>
                                    <td>{{ !empty($test->user->email) ? $test->user->email : 'N/A' }}</td>
                                    <td>
                                        {{ \App\Models\Classess::whereIn('id', json_decode($test->user->class))->pluck('name')->join(', ') }}
                                    </td>
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
                                        {{ $test->result . '/' . $test->questions_count }}
                                    </td>

                                    <td>
                                        {{ intval($test->time_spent / 60) >= $test->quiz->duration ? $test->quiz->duration : intval($test->time_spent / 60) }}:{{ intval($test->time_spent / 60) >= $test->quiz->duration ? '00' : gmdate('s', $test->time_spent) }} minutes
                                    </td>
                                    <td align="center">
                                        <a href="{{ route('results.show', $test) }}">
                                            <img src="{{ asset('/assets/images/icon-view.png') }}" alt="">
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
