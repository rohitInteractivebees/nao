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
                        <th width="340">
                            Quiz Description
                        </th>
                        <th width="120">
                            Result
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
                        @if($test->quiz->result_show == 1)
                            <tr>
                                <td>{{ $test->quiz->title }}</td>
                                <td>{{ $test->quiz->description }}</td>
                                <td>{{ $test->result . '/' . 20 }}</td>
                                <td>{{ sprintf('%.2f', $test->time_spent / 60) }} minutes</td>
                                <td>{{ $test->created_at->setTimezone('Asia/Kolkata')->format('d/m/Y h:i A') }}</td>
                                <td align="center">
                                    <a href="{{ route('results.show', $test) }}">
                                        <img src="{{ asset('/assets/images/icon-view.png') }}" width="28" height="17" alt="">
                                    </a>
                                </td>
                                <td align="center">
                                    @php $userSelected = auth()->user()->is_selected; @endphp
                                    @if($userSelected == 1)
                                        <div class="table-btn green no-hov">Selected</div>
                                    @else
                                        <div class="table-btn red no-hov">Not Selected</div>
                                    @endif
                                </td>
                                <td align="center">
                                    <a href="{{ route('download.certificate', $test) }}" class="table-btn blue no-hov">Download</a>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
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
