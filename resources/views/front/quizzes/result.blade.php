<x-app-layout>
    <section class="common-sec result-list-page">
        <div class="container">
            <div class="result-summary d-flex justify-between items-end">
                <div class="heading short">Results <span>Level 1</div>
                <div class="result-sumary-test">
                    <ul class="d-flex justify-between">
                        <li>
                            <span>Date : </span> {{ $test->created_at->setTimezone('Asia/Kolkata')->format('d/m/Y h:i A') }}

                        </li>
                        <li><span>Correct Answered : </span> {{ $test->result }} / {{ $questions_count }}</li>
                        <li><span>Time Taken : </span> @if ($test->time_spent)
                            {{ sprintf('%.2f', $test->time_spent / 60) }}
                            minutes
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

            <!--<table class="mt-4 table w-full table-view">
                <tbody class="bg-white">
                    @if (auth()->user()?->is_admin)
                    <tr class="w-28">
                        <th class="border border-solid bg-gray-100 px-6 py-3 text-left text-sm font-semibold uppercase text-slate-600">
                            User</th>
                        <td class="border border-solid px-6 py-3">{{ $test->user->name ?? '' }}
                            ({{ $test->user->email ?? '' }})</td>
                    </tr>
                    @endif
                    <tr class="w-28">
                        <th class="border border-solid bg-gray-100 px-6 py-3 text-left text-sm font-semibold uppercase text-slate-600">
                            Date</th>
                        <td class="border border-solid px-6 py-3">
                            {{ $test->created_at->format('D m/Y, h:m A') ?? '' }}
                        </td>
                    </tr>
                    <tr class="w-28">
                        <th class="border border-solid bg-gray-100 px-6 py-3 text-left text-sm font-semibold uppercase text-slate-600">
                            Result</th>
                        <td class="border border-solid px-6 py-3">
                            {{ $test->result }} / {{ $questions_count }}
                            @if ($test->time_spent)
                            (time: {{ sprintf('%.2f', $test->time_spent / 60) }}
                            minutes)
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>-->
            <br>
            @isset($leaderboard)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h6 class="text-xl font-bold">Leaderboard</h6>

                        <table class="table mt-4 w-full table-view">
                            <thead>
                                <th class="text-left">Rank</th>
                                <th class="text-left">Username</th>
                                <th class="text-left">Results</th>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($leaderboard as $test)
                                <tr @class([ 'bg-gray-100'=> auth()->user()->name == $test->user->name,
                                    ])>
                                    <td class="w-9">{{ $loop->iteration }}</td>
                                    <td class="w-1/2">{{ $test->user->name }}</td>
                                    <td>{{ $test->result }} / {{ $questions_count }} (time:
                                        {{ sprintf('%.2f', $test->time_spent / 60) }} minutes)
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endisset
            <br>
            <div class="result-question-answer">                
                <ul class="d-flex justify-between">
                    @foreach ($results as $result)
                    <li class="outer d-flex justify-between">
                        <div class="count">{{ $loop->iteration }}</div>
                        <div class="detail">
                            <div class="question">{!! nl2br($result->question->text) !!}</div>
                            <ul class="answer">
                                @foreach ($result->question->options as $option)
                                    <li @class([ 'underline'=> $result->option_id == $option->id,
                                        'font-bold' => $option->correct == 1,
                                        ])>
                                        {{ $option->text }}
                                        @if ($option->correct == 1)                                       
                                        @endif
                                        @if ($result->option_id == $option->id)                                        
                                        @endif
                                    </li>
                                    @endforeach
                                    @if (is_null($result->option_id))
                                    <li class="not-attend">Not Attempted</li>
                                    @endif
                            </ul>
                        </div>
                    </li>
                    @if(!$loop->last)                
                @endif
                @endforeach
                </ul>
                
             

                
            </div>
        </div>
    </section>
</x-app-layout>