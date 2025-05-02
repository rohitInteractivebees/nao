<x-app-layout>

    @auth




        @if(auth()->user()->is_admin == 1)

            @php
                $students = App\Models\User::where(function ($query) {
                    $query->where('is_college', 0)
                        ->orWhereNull('is_college');
                })->where(function ($query) {
                    $query->where('is_admin', 0);

                })->get();


                $verfystudents = App\Models\User::where(function ($query) {
                    $query->where('is_college', 0)
                        ->orWhereNull('is_college');
                })->where(function ($query) {
                    $query->where('is_admin', 0);

                })->where(function ($query) {
                    $query->where('is_verified', 1);

                })->get();

                
                $totalpartis = App\Models\Test::selectRaw('user_id, COUNT(*) as total_tests')
                    ->groupBy('user_id')
                    ->get();

                $mintime = App\Models\Test::orderBy('result', 'desc')
                    ->orderBy('time_spent', 'asc')
                    ->first();



                $totalpar = count($totalpartis);

                $total = count($students);
                $totalverystudent = count($verfystudents);
                 
                $totalNotverystudent = $total - $totalverystudent;

                $totalclg = App\Models\Instute::get();
           
                $sno = 1;
                
                $oldEndDateLevel2 = auth()->user()->level2enddate;
                $oldEndDateLevel3 = auth()->user()->level3enddate;

                $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
            @endphp
             
            <div id="quiz-blade1" style="display: none;">
                <div class="text-center">
                    <p><b>Are you sure to publish Quiz?</b></p>
                    <div class="buttons-sec d-flex justify-center gap w-100 links mt-6">
                        <button type="button" class="common-btn admin-btn green" onclick="updateStatus('quiz', 1)">Yes</button>
                        <button type="button" class="common-btn admin-btn red" onclick="updateStatus('quiz', 0)">NO</button>
                    </div>
                </div>
            </div>

            <div id="quiz-blade2" style="display: none;">
    <div class="text-center">
        <p><b>Are you sure to publish level 2?</b></p>
        <div class="form-style text-left" style="width: 80%;margin: 0 auto;">
            <label class="block font-medium text-sm text-gray-700" for="name">Select Submission End Date</label>
            <input type="date" id="end-date-level2" name="end-date-level2" class="form-control w-100"  value="{{ $oldEndDateLevel2 ?? '' }}" min="{{ $currentDate }}">
        </div>
        <div class="buttons-sec d-flex justify-center gap w-100 links mt-6">            
            <button type="button" class="common-btn admin-btn green" onclick="updateStatus('level2', 1)">Yes</button>
            <button type="button" class="common-btn admin-btn red" onclick="updateStatus('level2', 0)">No</button>
        </div>
    </div>
</div>

<div id="quiz-blade3" style="display: none;">
    <div class="text-center">
        <p><b>Are you sure to publish level 3?</b></p>
        <div class="form-style text-left" style="width: 80%;margin: 0 auto;">
            <label class="block font-medium text-sm text-gray-700" for="name">Select Submission End Date</label>
            <input type="date" id="end-date-level3" name="end-date-level3" class="form-control w-100"  value="{{ $oldEndDateLevel3 ?? '' }}" min="{{ $currentDate }}">
        </div>
        <div class="buttons-sec d-flex justify-center gap w-100 links mt-6">            
            <button type="button" class="common-btn admin-btn green" onclick="updateStatus('level3', 1)">Yes</button>
            <button type="button" class="common-btn admin-btn red" onclick="updateStatus('level3', 0)">No</button>
        </div>
    </div>
</div>

            <section class="common-sec collage-dashboared">
                <div class="container">
                    <div class="heading short">Dashboard</div>
                    <div class="toggle-buttons d-flex justify-end mb-4">

                        @php
                            $result2 = App\Models\User::where('is_admin', 1)->where('level2show', 1)->first();
                            $result3 = App\Models\User::where('is_admin', 1)->where('level3show', 1)->first();
                            $result1 = App\Models\Quiz::where('published', 1)->first();
                        @endphp
                        <div class="item-btn d-flex items-center">
                            <span>Publish Quiz</span>
                            @if($result1)
                                <span data-fancybox data-src="#quiz-blade1" class="quiz-btn active">&nbsp;</span>
                            @else
                                <span data-fancybox data-src="#quiz-blade1" class="quiz-btn">&nbsp;</span>
                            @endif
                        </div>
                        <div class="item-btn d-flex items-center">
                            <span>Publish Level 2</span>
                            @if($result2)
                                <span data-fancybox data-src="#quiz-blade2" class="quiz-btn active">&nbsp;</span>
                            @else
                                <span data-fancybox data-src="#quiz-blade2" class="quiz-btn">&nbsp;</span>
                            @endif
                        </div>
                        <div class="item-btn d-flex items-center">
                            <span>Publish Level 3</span>
                            @if($result3)
                                <span data-fancybox data-src="#quiz-blade3" class="quiz-btn active">&nbsp;</span>
                            @else
                                <span data-fancybox data-src="#quiz-blade3" class="quiz-btn">&nbsp;</span>
                            @endif
                        </div>
                    </div>
                    <div class="dashboared-items d-flex">
                        <div class="item d-flex justify-between items-center">
                            <span class="icon"><img src="{{ asset('/assets/images/icon-participants.png') }}" alt=""></span>
                            <div class="text">
                                <div class="title">Total Participants</div>
                                <div class="total">{{$total}} Students</div>
                            </div>
                        </div>

                        <div class="item d-flex justify-between items-center">
                            <span class="icon"><img src="{{ asset('/assets/images/icon-participants.png') }}" alt=""></span>
                            <div class="text">
                                <div class="title">Total Verified Participants</div>
                                <div class="total">{{$totalverystudent}} Students</div>
                            </div>
                        </div>

                        <div class="item d-flex justify-between items-center">
                            <span class="icon"><img src="{{ asset('/assets/images/icon-participants.png') }}" alt=""></span>
                            <div class="text">
                                <div class="title">Total Not Verified Participants</div>
                                <div class="total">{{$totalNotverystudent}} Students</div>
                            </div>
                        </div>

                        <div class="item d-flex justify-between items-center">
                            <span class="icon"><img src="{{ asset('/assets/images/icon-quiz-attempts.png') }}" alt=""></span>
                            <div class="text">
                                <div class="title">Quiz Attempts</div>
                                <div class="total">{{$totalpar}} Students</div>
                            </div>
                        </div>
                        <div class="item d-flex justify-between items-center">
                            <span class="icon"><img src="{{ asset('/assets/images/icon-time-taken.png') }}" alt=""></span>
                            <div class="text">
                                <div class="title">Min. Time Taken</div>
                                <div class="total">{{sprintf('%.2f', @$mintime->time_spent / 60)}} Min</div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="filter-data d-flex justify-between items-center">
                        <div class="right w-100 d-flex sm:justify-between justify-center items-end">
                            <div class="form-style">
                            </div>
                            <a class="common-btn admin-btn d-flex items-center" href="{{url('/admins/create')}}">
                                <span><img src="{{ asset('/assets/images/icon-addmore.png') }}" alt=""></span>
                                <span>Create Admin</span>
                            </a>
                        </div>
                    </div> -->
                    <div class="table-sec-outer mt-6">
                        <table class="table-sec">
                            <thead>
                                <tr>
                                    <th width="200">
                                        ID
                                    </th>
                                    <th width="440">
                                        Institute Name
                                    </th>
                                    <th width="220">
                                        Total Student
                                    </th>
                                    <th width="160">
                                        Participant Student
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach($totalclg as $clg)

                                                @php

                                                    $studenclg = App\Models\User::where('institute', $clg->id)->where('is_college', null)->get();


                                                @endphp
                                                <tr>
                                                    <td>
                                                        {{$sno}}
                                                    </td>
                                                    <td>
                                                        {{$clg->name}}
                                                    </td>
                                                    <td>
                                                        {{count($studenclg)}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $partstudentCount = App\Models\Test::whereIn('user_id', $studenclg->pluck('id'))->distinct('user_id')->count('user_id');
                                                        @endphp

                                                        {{ $partstudentCount }}



                                                    </td>

                                                </tr>

                                                @php            $sno++ @endphp

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        @elseif(auth()->user()->is_college == 1)


            @php
                $student = App\Models\User::where(function ($query) {
                    $query->where('is_college', 0)
                        ->orWhereNull('is_college');
                })->where(function ($query) {
                    $query->where('is_admin', 0);

                })->where('institute', auth()->user()->institute)->get();

                $students = App\Models\User::where(function ($query) {
                    $query->where('is_college', 0)
                        ->orWhereNull('is_college');
                })->where(function ($query) {
                    $query->where('is_admin', 0);

                })->where('institute', auth()->user()->institute)->get()->take(10);




                // Get the IDs of the students that match the criteria
                $studentIds = App\Models\User::where(function ($query) {
                    $query->where('is_college', 0)
                        ->orWhereNull('is_college');
                })->where(function ($query) {
                    $query->where('is_admin', 0);
                })->where('institute', auth()->user()->institute)
                    ->pluck('id');

                // Get the test records for these students
                $totalpartis = App\Models\Test::selectRaw('user_id, COUNT(*) as total_tests')
                    ->whereIn('user_id', $studentIds)
                    ->groupBy('user_id')
                    ->get();


                $mintime = App\Models\Test::whereIn('user_id', $studentIds)
                    ->orderBy('result', 'desc')
                    ->orderBy('time_spent', 'asc')
                    ->first();



                $totalpar = count($totalpartis);

                $total = count($student);


                $totalclg = App\Models\Instute::get();

                $sno1 = 1;
            @endphp


            <section class="common-sec collage-dashboared">
                <div class="container">
                    <div class="heading short">Dashboard</div>
                    <div class="dashboared-items d-flex">
                        <div class="item d-flex justify-between items-center">
                            <span class="icon"><img src="{{ asset('/assets/images/icon-participants.png') }}" alt=""></span>
                            <div class="text">
                                <div class="title">Total Participants</div>
                                <div class="total">{{$total}} Students</div>
                            </div>
                        </div>
                        <div class="item d-flex justify-between items-center">
                            <span class="icon"><img src="{{ asset('/assets/images/icon-quiz-attempts.png') }}" alt=""></span>
                            <div class="text">
                                <div class="title">Quiz Attempts</div>
                                <div class="total">{{$totalpar}} Students</div>
                            </div>
                        </div>
                        <div class="item d-flex justify-between items-center">
                            <span class="icon"><img src="{{ asset('/assets/images/icon-time-taken.png') }}" alt=""></span>
                            <div class="text">
                                <div class="title">Min. Time Taken</div>
                                <div class="total">{{sprintf('%.2f', @$mintime->time_spent / 60)}} Min</div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-data d-flex justify-between items-center">

                        <div class="right d-flex">
                            <a class="common-btn admin-btn d-flex items-center" href="{{url('/student/create')}}">
                                <span><img src="{{ asset('/assets/images/icon-addmore.png') }}" alt=""></span>
                                <span>Add New</span>
                            </a>
                            <a class="common-btn admin-btn d-flex items-center" href="{{url('student')}}">
                                <span><img src="{{ asset('/assets/images/icon-addmore.png') }}" alt=""></span>
                                <span>Bulk Upload</span>
                            </a>
                        </div>
                    </div>
                    <div class="table-sec-outer mt-6">
                        <table class="table-sec">
                            <thead>
                                <tr>
                                    <th width="200">
                                        ID
                                    </th>
                                    <th width="440">
                                        Student Name
                                    </th>
                                    <th width="220">
                                        Email ID
                                    </th>
                                    <th width="160">
                                        Phone No.
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach($students as $stu)
                                    <tr>
                                        <td>
                                            {{$sno1}}
                                        </td>
                                        <td>
                                            {{$stu->name}}
                                        </td>
                                        <td>
                                            {{$stu->email}}
                                        </td>
                                        <td>
                                            {{$stu->phone}}
                                        </td>

                                    </tr>
                                    @php            $sno1++; @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    @if(count($students) > 9)
                        <div class="links mt-6 d-flex justify-center">
                            <a class="common-btn short" href="/student">View All</a>
                        </div>
                    @endif
                </div>
            </section>

        @else

        @php
    $testuser = App\Models\Test::where('user_id', auth()->user()->id)->first();
    $resultpublished = App\Models\Quiz::where('id', 2)->first();

    $result2show = App\Models\User::where('is_admin', 1)->where('level2show', 1)->first();
    $resultFshow = App\Models\User::where('is_admin', 1)->where('level3show', 1)->first();

    $result2 = App\Models\User::where('is_admin', 1)->where('level2result', 1)->first();
    $resultF = App\Models\User::where('is_admin', 1)->where('level3result', 1)->first();
@endphp


          

            @if ($resultpublished->result_show == 1)

            @if($resultpublished->result_show == 1 && $testuser)
    @if($result2show)
        @if($result2)
            @if($resultFshow)
                @if($resultF)
                    <!-- level 3 result -->
                    <section class="common-sec thankyou-page congrats-sec">
                        <div class="container d-flex justify-center">
                            <div class="image">
                                <img class="thanks-image" src="{{ asset('/assets/images/congrats-certificate-bg.jpg') }}" alt="">
                                <div class="text text-center">
                                    <div class="text-thanks d-flex justify-center">
                                        <img src="{{ asset('/assets/images/result-text.png') }}" alt="">
                                    </div>
                                    <div class="title">Please click below to view your level 3 result</div>
                                    <div class="links">
                                        <a class="common-btn red small" href="{{ url('register-team') }}">View Result</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- end level 3 result -->
                @else
                    <!-- level 3 show -->
                    <section class="common-sec levels-sec quiz-main-page">
                        <div class="container d-flex justify-between">
                            <div class="quiz-type-sec levels-item">
                                <div class="item">
                                    <div class="icon">
                                        <img src="{{ asset('/assets/images/icon-level3.png') }}" alt="">
                                    </div>
                                    <div class="detail">
                                        <div class="title">Physical Prototype and Sales Presentation</div>
                                        <div class="duration">
                                            <span><b>Mode :</b> Offline</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quiz-body">
                                <div class="heading">Level 3</div>
                                <div class="description">
                                    <p>
                                        Welcome to the Physical Prototype and Sales Presentation! Please carefully read and
                                        adhere to the following guidelines to ensure a smooth and fair testing experience.
                                    </p>
                                    <div class="detail-sec">
                                        <div class="subtitle">Guidelines</div>
                                        <ol class="common-list mt-3 mb-6">
                                            <li>Only the team lead has the authority to upload the prototype.</li>
                                            <li>The prototype can only be updated once until the final submission date.</li>
                                            <li>The prototype must be submitted in one of the following formats: PDF, PPT, PNG or JPG.
                                            </li>
                                        </ol>
                                        <div class="subtitle"> Good luck, and do your best!</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- end level 3 show -->
                @endif
            @else
            
                <!-- level 2 result -->
                <section class="common-sec thankyou-page congrats-sec">
                    <div class="container d-flex justify-center">
                        <div class="image">
                            <img class="thanks-image" src="{{ asset('/assets/images/congrats-certificate-bg.jpg') }}" alt="">
                            <div class="text text-center">
                                <div class="text-thanks d-flex justify-center">
                                    <img src="{{ asset('/assets/images/result-text.png') }}" alt="">
                                </div>
                                <div class="title">Please click below to view your level 2 result</div>
                                <div class="links">
                                    <a class="common-btn red small" href="{{ url('register-team') }}">View Result</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- end level 2 result -->
            @endif
        @else
            <!-- level 2 show -->
            <section class="common-sec levels-sec quiz-main-page">
                <div class="container d-flex justify-between">
                    <div class="quiz-type-sec levels-item">
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('/assets/images/icon-level2.png') }}" alt="">
                            </div>
                            <div class="detail">
                                <div class="title">Digital Prototype Round</div>
                                <div class="duration">
                                    <span><b>Mode :</b> Online</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="quiz-body">
                        <div class="heading">Level 2</div>
                        <div class="description">
                            <p>
                                Welcome to the Digital Prototype Round! Please carefully read and
                                adhere to the following guidelines to ensure a smooth and fair testing experience.
                            </p>
                            <div class="detail-sec">
                                <div class="subtitle">Guidelines</div>
                                <ol class="common-list mt-3 mb-6">
                                    <li>The student who initiates the creation of the team will automatically become the team
                                        lead.</li>
                                    <li>A team can only be created once, and its composition cannot be altered after creation.
                                    </li>
                                    <li>Only the team lead has the authority to upload the prototype.</li>
                                    <li>The prototype can only be updated once until the final submission date.</li>
                                    <li>The prototype must be submitted in one of the following formats: PDF, PPT, or MOV.</li>
                                </ol>
                                <div class="subtitle"> Good luck, and do your best!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end level 2 show -->
        @endif
    @else
        <!-- result 1 -->
        <section class="common-sec thankyou-page congrats-sec">
            <div class="container d-flex justify-center">
                <div class="image">
                    <img class="thanks-image" src="{{ asset('/assets/images/congrats-certificate-bg.jpg') }}" alt="">
                    <div class="text text-center">
                        <div class="text-thanks d-flex justify-center">
                            <img src="{{ asset('/assets/images/result-text.png') }}" alt="">
                        </div>
                        <div class="title">Please click below to view your level 1 result</div>
                        <div class="links">
                            <a class="common-btn red small" href="{{ url('myresults') }}">View Result</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end result 1 -->
    @endif
@else
    <!-- Quiz closed -->
    <section class="common-sec levels-sec quiz-main-page">
        <div class="container d-flex justify-between">
            <div class="quiz-body">
                <div class="heading min-h-full d-flex justify-center items-center">The quiz has been closed.</div>
            </div>
        </div>
    </section>
    <!-- end quiz closed -->
@endif
          <!-- #region-->
            @elseif($testuser && $resultpublished->result_show != 1)

                <section class="common-sec congrats-sec">
                    <div class="container">
                        <div class="certificate">
                            <img src="{{ asset('/assets/images/congrats-certificate.jpg') }}" width="1114" height="615" alt="">
                        </div>
                    </div>
                </section>

            @else
                <section class="common-sec levels-sec quiz-main-page">
                    <div class="container d-flex justify-between">
                        <div class="quiz-type-sec levels-item">
                            <div class="item">
                                <div class="icon">
                                    <img src="{{ asset('/assets/images/icon-level1.png') }}" alt="">
                                </div>
                                <div class="detail">
                                    <div class="title">Digital Quiz Round</div>
                                    <div class="duration">
                                        <span><b>Duration :</b> 1 Week</span>
                                        <span><b>Mode :</b> Online</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="quiz-body">
                            @forelse($registered_only_quizzes as $quiz)
                                <div class="heading">Level 1</div>
                                <div class="description">
                                    <p>
                                        Welcome to the <span class="uppercase">NAO</span>! Please carefully read and
                                        adhere to the following guidelines to ensure a smooth and fair testing experience.
                                    </p>
                                    <div class="detail-sec">
                                        <div class="subtitle">Guidelines</div>
                                        <ul class="d-flex">
                                            <li>
                                                <p>Number of Questions</p>
                                                <div class="count">20</div>
                                            </li>
                                            <li>
                                                <p>Time per Question</p>
                                                <div class="count">60 <span>Seconds</span></div>
                                            </li>
                                            <li>
                                                <p>Total Time</p>
                                                <div class="count">20 <span>Minutes</span></div>
                                            </li>
                                            <li>
                                                <p>All Questions are Mandatory</p>
                                            </li>
                                        </ul>
                                        <div class="subtitle"> Good luck, and do your best!</div>
                                        <div class="links">
                                            <a class="common-btn red white-hov" href="{{ route('quiz.show', $quiz->slug) }}">Start
                                                Now</a>
                                        </div>

                                    </div>
                                </div>
                            @empty


                                @php
                                    $showq = App\Models\Quiz::where('published', 2)->first();
                                @endphp

                                @if($showq)
                                    <div class="heading min-h-full d-flex justify-center items-center"><strong>Quiz Date:</strong>
                                        To be announced soon.</div>
                                @else
                                    <!-- Optional message if there are no quizzes -->
                                    <div class="heading min-h-full d-flex justify-center items-center">The quiz has been closed.</div>
                                @endif
                            @endforelse
                        </div>
                    </div>
                </section>
            @endif

        @endif
    @else
        <section class="banner-sec">
            <div class="item w-100">
                <img class="desktop w-100" src="{{ asset('/assets/images/login-bg-asdc.jpg') }}" style="height:700px;" alt="">
                <img class="mobile w-100" src="{{ asset('/assets/images/login-bg-asdc.jpg') }}" alt="">
                <div class="container">
                    <div class="text">
                        <img src="{{ asset('/assets/images/nao-logo.png') }}" width="360" />
                        <div class="heading">
                            National Automobile Olympiad 2025
                        </div>
                        <div class="links">
                            <a class="common-btn red white-hov" href="{{ route('login') }}">Participate Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    @endauth
</x-app-layout>

<script>
    function updateStatus(type, status) {
        let url = '';
        let endDate = '';

        switch (type) {
            case 'quiz':
                url = '/update-quiz-status';
                break;
            case 'level2':
                url = '/update-level2-status';
                endDate = document.getElementById('end-date-level2').value;
                break;
            case 'level3':
                url = '/update-level3-status';
                endDate = document.getElementById('end-date-level3').value;
                break;
        }

        if (type !== 'quiz' && !endDate) {
            alert('Please select the end date of submission.');
            return;
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: status,
                endDate: endDate
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Update failed!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred!');
        });
    }
</script>
