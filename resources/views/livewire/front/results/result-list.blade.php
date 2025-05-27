<section class="common-sec result-list-page">
    <div class="container">
        <!-- <div class="heading short">Dashboard</div> -->
        <div class="table-sec-outer">
            <table class="table-sec">
                <thead>
                    <tr>
                        <th width="200">
                            Quiz Title
                        </th>
                        <th width="120">
                            Marks
                        </th>
                        <th width="160">
                            Time Spent
                        </th>
                        <th width="200">
                            Date
                        </th>
                        <th align="center" width="100">
                            Action
                        </th>
                        <th align="center" width="110">
                            Result
                        </th>
                        <th align="center" width="140">
                            Download Certificate
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                    @foreach($tests as $test)
                        @if(\Carbon\Carbon::now()->gte(\Carbon\Carbon::parse($test->quiz->result_date)))
                            <tr>
                                <td>{{ $test->quiz->title }}</td>
                                <td>{{ $test->result . '/' . $test->questions_count; }}</td>
                                <td>{{ intval($test->time_spent / 60) }}:{{ intval($test->time_spent / 60) >= $test->quiz->duration ? '00' : gmdate('s', $test->time_spent) }}
                                        minutes</td>
                                <td>{{ $test->created_at->setTimezone('Asia/Kolkata')->format('d/m/Y h:i A') }}</td>
                                <td align="center">
                                    <a href="{{ route('results.show', $test) }}">
                                        <img src="{{ asset('/assets/images/icon-view.png') }}" width="28" height="17" alt="">
                                    </a>
                                </td>
                                <td align="center">
                                    @php
                                        $marks_percent = ($test->questions_count * $test->quiz->pass_fail_percent / 100 );
                                    @endphp
                                    @if($test->result >= $marks_percent)
                                        <div class="table-btn green no-hov">Pass</div>
                                    @else
                                        <div class="table-btn red no-hov">Fail</div>
                                    @endif
                                </td>
                                <td align="center">
                                    @if($test->result >= $marks_percent)
                                        <a href="{{ route('download.certificate', $test) }}" class="table-btn blue no-hov">Download</a>
                                    @else
                                        N/A
                                    @endif

                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="8" class="px-6 py-4 leading-5 text-center text-gray-900 whitespace-no-wrap">
                                    Coming soon.
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $tests->links() }}
    </div>
</section>
