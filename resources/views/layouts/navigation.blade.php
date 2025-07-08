@php
    $routeName = Route::currentRouteName();
    $routeArr =  ['home','login','register','school_register','thankyou','password.request','password.reset','gallery','testimonial','notice','privacy_policy','press_release'];
@endphp

@if(in_array($routeName, $routeArr))
    @auth
        @include('layouts.assets_file.navigation.old_navigation_up')

    @else
        @include('layouts.assets_file.navigation.new_navigation_up')
    @endauth
@else
    @include('layouts.assets_file.navigation.old_navigation_up')
@endif

                    @auth
                        @if(auth()->user()->is_admin != 1)
                            @php
                                $classIds = json_decode(auth()->user()->class, true);
                                $matchedGroup = '';

                                if (!empty($classIds)) {
                                    $classNames = \App\Models\Classess::whereIn('id', $classIds)->pluck('group')->toArray();
                                    $matchedGroup = implode(', ', $classNames);
                                }
                                $userId = (string) Auth::user()->id;
                                $myrslt = App\Models\Test::where('user_id', Auth::user()->id)->first();
                                $resultpublish = App\Models\Quiz::whereHas('questions')
                                ->withCount('questions')
                                ->when(auth()->check() && !auth()->user()->is_admin && is_null(auth()->user()->is_college), function ($query) use ($matchedGroup) {
                                    $userClasses = json_decode(auth()->user()->class ?? '[]', true);

                                    if (!empty($userClasses)) {
                                        $query->where('class_ids', $matchedGroup);
                                    }

                                    $query->where('status', 1);
                                })
                                ->limit(1)
                                ->first();
                            @endphp
                        @endif
                        <li class="submenu"><a href="javascript:void(0)"> Welcome, {{ Auth::user()->name }}</a>
                            <ul class="dropdown">
                                <li><a href="{{ route('home') }}">Home </a></li>
                                <li><a href="{{ route('profile.edit') }}">My Profile </a></li>

                                @if(auth()->user()->is_college != 1 && auth()->user()->is_admin != 1)
                                    @if($resultpublish && \Carbon\Carbon::now()->gte(\Carbon\Carbon::parse($resultpublish->result_date)))
                                        @if(auth()->user()->is_college != 1 && auth()->user()->is_admin != 1 && $myrslt)
                                            <li><a href="{{ route('myresults') }}">My Result</a></li>
                                        @endif
                                    @endif
                                @endif


                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                            Log Out
                                        </a>
                                    </li>
                                </form>
                            </ul>
                        </li>
                        @if(auth()->user()->is_college == 1 )
                            <li><a href="{{ route('leaderboard') }}">Leaderboard </a></li>
                            <li class="submenu"><a href="javascript:void(0)"> Manage </a>
                                <ul class="dropdown">
                                    <li><a href="{{ route('student') }}"> Student </a></li>
                                    <li><a href="{{ route('class.list') }}"> Classes </a></li>
                                </ul>
                            </li>
                        @endif
                        @if(auth()->user()->is_admin != 1 )
                            <li><a href="https://courses.asdc.org.in/" target="_blank">ASDC Courses </a></li>
                            @if(auth()->user()->is_college == 1 )
                                <li class="submenu"><a href="javascript:void(0)"> Sample Paper </a>
                                    <ul class="dropdown">
                                        <li><a href="{{ url('sampleCsv/Olympiad_Questionnaire_Group1.pdf') }}" download> Group-1 </a></li>
                                        <li><a href="{{ url('sampleCsv/Olympiad_Questionnaire_Group2.pdf') }}" download> Group-2 </a></li>
                                        <li><a href="{{ url('sampleCsv/Olympiad_Questionnaire_Group3.pdf') }}" download> Group-3 </a></li>
                                    </ul>
                                </li>
                            @else
                                @php
                                    $pdf = '';
                                    $classIds = json_decode(auth()->user()->class, true);

                                    if (!empty($classIds)) {
                                        $classNames = \App\Models\Classess::whereIn('id', $classIds)->pluck('group')->toArray();
                                        $matchedGroup = implode(', ', $classNames);
                                        $pdf = 'Olympiad_Questionnaire_Group'.$matchedGroup.'.pdf';
                                    }

                                @endphp
                                <li><a href="{{ url('sampleCsv/'.$pdf) }}" download target="_blank">Sample Paper </a></li>
                            @endif
                        @endif
                    @else
                    <li class="close-icon">
                        <a href="javascript:void(0);" class="">X</a>
                    </li>
                        <li class="">
                            <a href="#" onclick="event.preventDefault();" class="flex items-center">About NAO
                                <svg class="w-4 h-4 ml-2 -rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            </a>
                            <ul class="sub-dropdown">
                               <li><a href="{{url('/#about-nao')}}">Overview</a></li>
                                <li><a href="{{url('/#eligibility-criteria')}}">Eligibility Criteria</a></li>
                                <li><a href="{{url('/#important-dates')}}">Important Dates</a></li>

                                <li><a href="{{url('/#benefits')}}">Benefits</a></li>
                                <li><a href="{{url('/#process')}}">Registration Process</a></li>


                                <li><a href="{{url('/#sponsors')}}">Sponsors</a></li>

                            </ul>
                        </li>
                        <li><a href="{{url('/#nao-winners')}}">NAO Winner</a></li>
                        <li><a href="{{url('/testimonial')}}">Write a Testimonial</a></li>
                        <li class="">
                            <a href="#" onclick="event.preventDefault();" class="flex items-center">Courses
                                <svg class="w-4 h-4 ml-2 -rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            </a>
                            <ul class="sub-dropdown">
                                <li><a href="https://courses.asdc.org.in/" target="_blank" class="">ASDC Courses</a></li>
                            </ul>
                        </li>
                        <li class="">
                            <a href="#" onclick="event.preventDefault();" class="flex items-center">Media
                                <svg class="w-4 h-4 ml-2 -rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            </a>
                            <ul class="sub-dropdown">
                                <li><a href="{{url('/press-release')}}">Press Release</a></li>
                                <li><a href="{{url('/gallery')}}">Gallery</a></li>
                                <li><a href="javascript:void(0);" class="flex items-center justify-between" style="display: flex;">Report
                                <svg class="w-4 h-4 ml-2 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                                </a>
                                <ul class="sub-sub-dropdown">
                                    <li><a href="{{ asset('/images/ASDC-Monthly-Report-for-Dec-2024.pdf') }}" target="_blank">2024</a></li>
                                    <li><a href="{{ asset('/images/ASDC _NationalAutomobileOlympiad_2023-1.pdf') }}" target="_blank">2023</a></li>
                                    <li><a href="{{ asset('/images/ASDC_National_Automobile_Olympiad_2022.pdf') }}" target="_blank">2022</a></li>
                                </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a href="#" onclick="event.preventDefault();" class="flex items-center">Sample Paper
                                <svg class="w-4 h-4 ml-2 -rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            </a>
                            <ul class="sub-dropdown">
                                <li><a href="{{ url('sampleCsv/Olympiad_Questionnaire_Group1.pdf') }}" download> Group 1 </a></li>
                                <li><a href="{{ url('sampleCsv/Olympiad_Questionnaire_Group2.pdf') }}" download> Group 2 </a></li>
                                <li><a href="{{ url('sampleCsv/Olympiad_Questionnaire_Group3.pdf') }}" download> Group 3 </a></li>

                            </ul>
                        </li>



                        <!--<li><a href="#eligibility-criteria" class="">Eligibility Criteria-->
                        <!--<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
                        <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>-->
                        <!--</svg>-->
                        <!--</a></li>-->
                        <!--<li><a href="#important-dates" class="">Stages</a></li>-->
                        <!--<li><a href="#benefits" class="">Benefits</a></li>-->
                        <!--<li><a href="#process" class="">Registration Process</a></li>-->
                        <!--<li><a href="#sponsors" class="">Sponsors</a></li>-->
                        <!--<li><a href="#nao-winners" class="">Winners</a></li>-->
                        <!--<li><a href="https://courses.asdc.org.in/" target="_blank" class="">ASDC Courses</a></li>-->


                        <!--<li><a href="./about_competition">About Competition </a></li>-->
                        <!--<li><a href="./guidelines">Guidelines</a></li>-->
                        <!--<li><a href="./rewards">Rewards</a></li>-->
                        <!--<li><a href="./institutes">School</a></li>-->
                        <!--<li class="btn"><a href="{{ route('login') }}">Participate Now</a></li>-->
                    @endauth

                    @admin
                        <li><a href="{{ route('leaderboard') }}">Leaderboard </a></li>
                        <li class="submenu"><a href="javascript:void(0)"> Manage </a>
                            <ul class="dropdown">
                                <li><a href="{{ route('institute_login') }}">  School Register </a></li>
                                {{-- <li><a href="{{ route('institute') }}">  School Details</a></li> --}}
                                <li><a href="{{ route('all_schools') }}">  All Schools</a></li>
                                <li><a href="{{ route('studentlistadmin') }}"> Student Register</a></li>
                                <li><a href="{{ route('questions') }}"> Question Bank</a></li>
                                <li><a href="{{ route('class.list') }}"> Class Insights </a></li>
                                <li><a href="{{ route('quizzes') }}"> Quizzes </a></li>
                                <li><a href="{{ route('tests') }}">  Quiz Attempt Tracker </a></li>
                                <li><a href="{{ route('reattemptstudentlistadmin') }}">Quiz Interrupted Students  </a></li>
                                <li><a href="{{ route('testimonial.list') }}">Testimonials  </a></li>
                            </ul>
                        </li>
                    @endadmin

@if(in_array($routeName, $routeArr))
    @auth
        @include('layouts.assets_file.navigation.old_navigation_down')

    @else
        @include('layouts.assets_file.navigation.new_navigation_down')
    @endauth
@else
    @include('layouts.assets_file.navigation.old_navigation_down')
@endif
