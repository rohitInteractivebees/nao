<div>
       <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden">
                <div class="form-style">
                    <label>Select School</label>
                    <select class="p-3 w-full text-sm leading-5 mb-3 text-slate-600"
                        wire:model="quiz_id">
                        <option value="0">All School</option>
                        @foreach ($college as $quiz)
                            <option value="{{ $quiz->id }}">{{ $quiz->name }}</option>
                        @endforeach
                    </select>
                    <table class="table mt-4 w-full table-view">
                        <thead>
                            <tr>
                                <th width="100">
                                    ID
                                </th>
                                <th width="200">
                                    User
                                </th>
                                <th width="300">
                                    School
                                </th>
                                <th width="100">
                                    Result
                                </th>
                                <th width="200">
                                    IP Address
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
                                    <td>
                                    @php
                                          $clgname = App\Models\Instute::find($test->user->institute);
                                        @endphp
                                        {{ @$clgname->name }}
                                    </td>
                                    <td>
                                        {{ $test->result . '/' . 20 }}
                                    </td>
                                    <td>
                                        {{ $test->ip_address }}
                                    </td>
                                    <td>
                                        {{ intval($test->time_spent / 60) }}:{{ gmdate('s', $test->time_spent) }}
                                        minutes
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
                                        class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
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