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

                $totalclg = App\Models\Instute::get()->take(10);

                $sno = 1;

                $oldEndDateLevel2 = auth()->user()->level2enddate;
                $oldEndDateLevel3 = auth()->user()->level3enddate;

                $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
                $total_school = App\Models\Instute::count();
            @endphp

            <section class="common-sec collage-dashboared common-sec1">
                <div class="container">
                    <div class="md:flex justify-between">
                        <div class="item md:w-1/4">
                            <div class="sub-title"><span class="text-black">Admin Dashboard</span></div>
                            </div>
                            <div class="item md:w-3/4">
                                <div class="dashboared-items d-flex md:justify-end md:gap-4">
                                    <div class="items-center justify-between item d-flex">
                                        <span class="icon"><img src="{{ asset('/assets/images/icon-participants.png') }}" alt=""></span>
                                        <div class="text">
                                            <div class="title">School Participants</div>
                                            <div class="total">{{$total_school}} Schools</div>
                                        </div>
                                    </div>
                                    <div class="items-center justify-between item d-flex">
                                        <span class="icon"><img src="{{ asset('/assets/images/icon-participants.png') }}" alt=""></span>
                                        <div class="text">
                                            <div class="title">Total Participants</div>
                                            <div class="total">{{$total}} Students</div>
                                        </div>
                                    </div>
                                    <div class="items-center justify-between item d-flex">
                                        <span class="icon"><img src="{{ asset('/assets/images/icon-quiz-attempts.png') }}" alt=""></span>
                                        <div class="text">
                                            <div class="title">Quiz Attempts</div>
                                            <div class="total">{{$totalpar}} Students</div>
                                        </div>
                                    </div>
                                    <div class="items-center justify-between item d-flex">
                                        <span class="icon"><img src="{{ asset('/assets/images/icon-participants.png') }}" alt=""></span>
                                        <div class="text">
                                            <div class="title">Pending Attempts</div>
                                            <div class="total">{{$total - $totalpar}} Students</div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- <div class="items-center justify-between filter-data d-flex">
                        <div class="items-end justify-center right w-100 d-flex sm:justify-between">
                            <div class="form-style">
                            </div>
                            <a class="items-center common-btn admin-btn d-flex" href="{{url('/admins/create')}}">
                                <span><img src="{{ asset('/assets/images/icon-addmore.png') }}" alt=""></span>
                                <span>Create Admin</span>
                            </a>
                        </div>
                    </div> -->
                    <div class="mt-6 table-sec-outer">
                        <table class="table-sec">
                            <thead>
                                <tr>
                                    <th width="200">
                                        S.No
                                    </th>
                                    <th width="440">
                                        School Name
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
                    @if(count($totalclg) > 9)
                        <div class="justify-center mt-6 links d-flex">
                            <a class="common-btn short" href="/school">View All</a>
                        </div>
                    @endif
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


<!--School Dashboard Start here-->

            <section class="common-sec collage-dashboared common-sec1">
                <div class="container">
                    <div class="md:flex justify-between">
                        <div class="item md:w-1/4">
                            <div class="sub-title"><span class="text-black">School Dashboard</span></div>
                            <div class="items-center justify-between filter-data d-flex">
                                <div class="right d-flex">
                                    {{-- <a class="items-center common-btn admin-btn d-flex" href="{{url('/student/create')}}">
                                        <span><img src="{{ asset('/assets/images/icon-addmore.png') }}" alt=""></span>
                                        <span>Add New</span>
                                    </a> --}}
                                    <a class="items-center common-btn admin-btn d-flex" href="{{url('student')}}">
                                        <span><img src="{{ asset('/assets/images/icon-addmore.png') }}" alt=""></span>
                                        <span>Bulk Upload</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item md:w-3/4">
                            <div class="dashboared-items d-flex md:justify-end md:gap-4">
                                <div class="items-center justify-between item d-flex">
                                    <span class="icon"><img src="{{ asset('/assets/images/icon-participants.png') }}" alt=""></span>
                                    <div class="text">
                                        <div class="title">Total Participants</div>
                                        <div class="total">{{$total}} Students</div>
                                    </div>
                                </div>
                                <div class="items-center justify-between item d-flex">
                                    <span class="icon"><img src="{{ asset('/assets/images/icon-quiz-attempts.png') }}" alt=""></span>
                                    <div class="text">
                                        <div class="title">Quiz Attempts</div>
                                        <div class="total">{{$totalpar}} Students</div>
                                    </div>
                                </div>
                                <div class="items-center justify-between item d-flex">
                                    <span class="icon"><img src="{{ asset('/assets/images/icon-participants.png') }}" alt=""></span>
                                    <div class="text">
                                        <div class="title">Pending Attempts</div>
                                        <div class="total">{{$total - $totalpar}} Students</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="mt-6 table-sec-outer">
                        <table class="table-sec">
                            <thead>
                                <tr>
                                    <th width="200">
                                        Sr.No
                                    </th>
                                    <th width="440">
                                        Student Name
                                    </th>
                                    <th width="440">
                                        Class
                                    </th>
                                    <th width="220">
                                        Parent Email
                                    </th>
                                    <th width="160">
                                        Parent Phone
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
                                            {{ \App\Models\Classess::whereIn('id', json_decode($stu->class))->pluck('name')->join(', ') }}
                                        </td>
                                        <td>
                                            {{$stu->email}}
                                        </td>
                                         <td>+{{ $stu->country_code.' '.$stu->phone }}</td>
                                        

                                    </tr>
                                    @php            $sno1++; @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    @if(count($students) > 9)
                        <div class="justify-center mt-6 links d-flex">
                            <a class="common-btn short" href="/student">View All</a>
                        </div>
                    @endif
                </div>
            </section>

        @else

            @php
                $classIds = json_decode(auth()->user()->class, true);
                $matchedGroup = '';
            
                if (!empty($classIds)) {
                    $classNames = \App\Models\Classess::whereIn('id', $classIds)->pluck('group')->toArray();
                    $matchedGroup = implode(', ', $classNames);
                }
                $testuser = App\Models\Test::where('user_id', auth()->user()->id)->first();
                $resultpublished = App\Models\Quiz::where('class_ids', $matchedGroup)->first();

                $result2show = App\Models\User::where('is_admin', 1)->where('level2show', 1)->first();
                $resultFshow = App\Models\User::where('is_admin', 1)->where('level3show', 1)->first();

                $result2 = App\Models\User::where('is_admin', 1)->where('level2result', 1)->first();
                $resultF = App\Models\User::where('is_admin', 1)->where('level3result', 1)->first();
            @endphp

            @if (@$resultpublished->result_show == 1)

                @if(@$resultpublished->result_show == 1 && $testuser)
                    @if($result2show)
                        @if($result2)
                            @if($resultFshow)
                                @if($resultF)
                                    <!-- level 3 result -->
                                    <section class="common-sec thankyou-page congrats-sec">
                                        <div class="container justify-center d-flex">
                                            <div class="image">
                                                <img class="thanks-image" src="{{ asset('/assets/images/congrats-certificate-bg.jpg') }}" alt="">
                                                <div class="text-center text">
                                                    <div class="justify-center text-thanks d-flex">
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
                                        <div class="container justify-between d-flex">
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
                                                        <ol class="mt-3 mb-6 common-list">
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
                                    <div class="container justify-center d-flex">
                                        <div class="image">
                                            <img class="thanks-image" src="{{ asset('/assets/images/congrats-certificate-bg.jpg') }}" alt="">
                                            <div class="text-center text">
                                                <div class="justify-center text-thanks d-flex">
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
                                <div class="container justify-between d-flex">
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
                                                <ol class="mt-3 mb-6 common-list">
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
                            <div class="container justify-center d-flex">
                                <div class="image">
                                    <img class="thanks-image" src="{{ asset('/assets/images/congrats-certificate-bg.jpg') }}" alt="">
                                    <div class="text-center text">
                                        <div class="justify-center text-thanks d-flex">
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
                    <section class="common-sec levels-sec quiz-main-page common-sec1 d-flex items-center flex-wrap">
                        <div class="container justify-center d-flex">
                            <div class="quiz-body">
                                <div class="items-center justify-center min-h-full heading d-flex">The quiz has been closed.</div>
                            </div>
                        </div>
                    </section>
                    <!-- end quiz closed -->
                @endif
            <!-- #region-->
            @elseif($testuser && @$resultpublished->result_show != 1)

                <section class="common-sec congrats-sec">
                    <div class="container">
                        <div class="certificate">
                            <img src="{{ asset('/assets/images/congrats-certificate.jpg') }}" width="1114" height="615" alt="">
                        </div>
                    </div>
                </section>

            @else
                <section class="common-sec levels-sec quiz-main-page common-sec1">
                    
                    @if(!empty($liveQuiz) && count($liveQuiz) > 0 && $liveQuiz != null && $liveQuiz != '')
                    <div class="container justify-between d-flex">
                        <div class="quiz-type-sec levels-item">
                            <div class="item">
                                <div class="icon">
                                    <img src="{{ asset('/assets/images/icon-level1.png') }}" alt="">
                                </div>
                                <div class="detail">
                                    <div class="title">Quiz Round 1</div>
                                    <div class="duration">

                                        <span><b>Start Date:</b> {{ Carbon\Carbon::parse($liveQuiz[0]->start_date)->format('d-m-Y h:i A') }}</span>
                                        <span><b>End Date:</b> {{ Carbon\Carbon::parse($liveQuiz[0]->end_date)->format('d-m-Y h:i A') }}</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="quiz-body">
                            @foreach($liveQuiz as $quiz)
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $start = \Carbon\Carbon::parse($quiz->start_date);
                                    $end = \Carbon\Carbon::parse($quiz->end_date);
                                @endphp
                                @if ($end->isPast())
                                    <div class="items-center justify-center min-h-full heading d-flex">
                                        <div class="sub-title mb-0">
                                            The quiz has been closed.
                                        </div>
                                        
                                    </div>
                                @else
                                    <div class="common-title">Level 1</div>
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
                                                    <div class="count">30</div>
                                                </li>
                                                <li>
                                                    <p>Total Time</p>
                                                    <div class="count">{{ $quiz->duration }} <span>Minutes</span></div>
                                                </li>
                                                <li>
                                                    <p>All Questions are Mandatory</p>
                                                </li>
                                            </ul>

                                           @if (Carbon\Carbon::now()->between(Carbon\Carbon::parse($quiz->start_date), Carbon\Carbon::parse($quiz->end_date)))
                                                <div class="subtitle"> Good luck, and do your best!</div>
                                                <div class="links">
                                                    <a class="common-btn red short" href="{{ route('quiz.show', $quiz->slug) }}">Start
                                                        Now</a>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="common-sec1 d-flex items-center flex-wrap">
                        <div class="container d-flex justify-center">
                            <div class="quiz-body">
                                <div class="items-center justify-center min-h-full sub-title d-flex gap-2"><strong class="common-title mb-0">Quiz <span>Date:</span> </strong> Will commence from 23rd May to 31st July 2025</div>
                            </div>
                        </div>
                    </div>    
                    @endif
                </section>
            @endif

        @endif
    @else
        @include('layouts.guest_content')
        <!--<section class="banner-sec">-->
        <!--    <div class="item w-100">-->
        <!--        <img class="desktop w-100" src="{{ asset('/assets/images/login-bg-asdc.jpg') }}" style="height:700px;" alt="">-->
        <!--        <img class="mobile w-100" src="{{ asset('/assets/images/login-bg-asdc.jpg') }}" alt="">-->
        <!--        <div class="container">-->
        <!--            <div class="text">-->
        <!--                <img src="{{ asset('/assets/images/nao-logo.png') }}" width="360" />-->
        <!--                <div class="heading">-->
        <!--                    National Automobile Olympiad 2025-->
        <!--                </div>-->
        <!--                <div class="links">-->
        <!--                    <a class="common-btn red white-hov" href="{{ route('login') }}">Participate Now</a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</section>-->

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
