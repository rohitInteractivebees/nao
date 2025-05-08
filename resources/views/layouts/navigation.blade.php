<header class="header">
    <div class="container items-center justify-between d-flex">
        <div class="logo">
            <a href="{{url('')}}" aria-label="NAO">
                <img src="{{ asset('/assets/images/logo.jpg') }}" width="164px" height="64px" alt="">
            </a>
            <a href="{{url('')}}" aria-label="NAO">
                <img src="{{ asset('/assets/images/logo.png') }}" width="85px" style="height:100px;"  alt="">
            </a>
        </div>
        <div class="items-center justify-between nav-sec d-flex">
            <div class="menu-sec">
                <button type="button" class="close-btn">X</button>
                <ul class="d-flex">
                    @auth
                        <li class="submenu"><a href="javascript:void(0)"> Welcome, {{ Auth::user()->name }}</a>
                            <ul class="dropdown">
                                <li><a href="{{ route('profile.edit') }}">My Profile </a></li>
                                @php
                                    $temex = App\Models\Teams::where('teamlead_id',Auth::user()->id)->first();
                                    $userId = (string) Auth::user()->id;
                                    $teamy = App\Models\Teams::whereJsonContains('teamMembers', $userId)->first();
                                    $myrslt = App\Models\Test::where('user_id', Auth::user()->id)->first();
                                    $resultpublish = App\Models\Quiz::whereHas('questions')
                                    ->withCount('questions')
                                    ->when(auth()->check() && !auth()->user()->is_admin && is_null(auth()->user()->is_college), function ($query) {
                                        $userClasses = json_decode(auth()->user()->class ?? '[]', true); // e.g., [1, 2]

                                        if (!empty($userClasses)) {
                                            $query->whereIn('class_ids', $userClasses);
                                        }

                                        $query->where('status', 1);
                                    })
                                    ->limit(1)
                                    ->first();
                                @endphp

                                @if($resultpublish && \Carbon\Carbon::now()->gte(\Carbon\Carbon::parse($resultpublish->result_date)))
                                    @if(auth()->user()->is_college != 1 && auth()->user()->is_admin != 1 && $myrslt)
                                        <li><a href="{{ route('myresults') }}">My Result</a></li>
                                    @endif
                                @endif

                                {{-- @php
                                    $result = App\Models\User::where('is_admin', 1)->where('level2show', 1)->first();;
                                    $resultF = App\Models\User::where('is_admin', 1)->where('level3show', 1)->first();
                                    $resultUser = App\Models\Test::where('user_id',auth()->user()->id)->first();
                                @endphp

                                @if($result && $resultUser && auth()->user()->is_college != 1 && auth()->user()->is_admin != 1)
                                    <li><a href="{{ route('register-team') }}"> Team  </a></li>
                                @endif
                                @if($result && $resultUser && auth()->user()->is_college != 1 && auth()->user()->is_admin != 1)
                                    <li><a href="{{ route('prototypelist') }}">Prototype Submission</a></li>
                                @endif
                                @if( $resultF && $resultUser && auth()->user()->is_college != 1 && auth()->user()->is_admin != 1)
                                    <li><a href="{{ route('physciallylist') }}">Physical Prototype and Sales Presentation</a></li>
                                @endif --}}
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
                            @if($result)
                                <li><a href="{{ route('leaderboard') }}">Leaderboard </a></li>

                            @endif
                            <li class="submenu"><a href="javascript:void(0)"> Manage </a>
                                <ul class="dropdown">
                                    <li><a href="{{ route('student') }}"> Student </a></li>
                                    <li><a href="{{ route('class.list') }}"> Classes </a></li>
                                    <!-- <li><a href="{{ route('register-team') }}"> Team Registration </a></li> -->
                                    <!-- <li><a href="{{ route('submissions') }}"> Digital Prototype Submissions </a></li> -->
                                    <!-- <li><a href="{{ route('student') }}">  Sales Presentation Submissions </a></li> -->
                                    <!-- <li><a href="{{ route('student') }}">  Preliminary Results </a></li>             -->
                                    <!-- <li><a href="{{ route('student') }}">  Digital Results </a></li> -->
                                    <!-- <li><a href="{{ route('student') }}"> Sales  Results </a></li> -->
                                    <li><a href="{{ route('register-team') }}"> Team  </a></li>
                                        <li><a href="{{ route('submissonlist') }}"> Digital Prototype Submissions List </a></li>


                                        <li><a href="{{ route('physciallysubmissonlist') }}"> Physical Prototype and Sales Presentation List</a></li>

                                    </ul>
                            </li>
                        @endif
                    @else
                        <li><a href="./about_competition">About Competition </a></li>
                        <li><a href="./guidelines">Guidelines</a></li>
                        <li><a href="./rewards">Rewards</a></li>
                        <li><a href="./institutes">School</a></li>
                        <li class="btn"><a href="{{ route('login') }}">Participate Now</a></li>
                    @endauth

                    @admin
                        <li><a href="{{ route('leaderboard') }}">Leaderboard </a></li>
                        <li class="submenu"><a href="javascript:void(0)"> Manage </a>
                            <ul class="dropdown">
                                <!-- <li><a href="{{ route('admins') }}"> Admins </a></li> -->
                                <li><a href="{{ route('questions') }}"> Questions</a></li>
                                <li><a href="{{ route('class.list') }}"> Classes </a></li>
                                <li><a href="{{ route('quizzes') }}"> Quizzes </a></li>
                                <li><a href="{{ route('studentlistadmin') }}"> Student </a></li>

                                <li><a href="{{ route('tests') }}">  Tests </a></li>
                                <li><a href="{{ route('institute') }}">  School </a></li>
                                <li><a href="{{ route('institute_login') }}">  School Login </a></li>
                                <li><a href="{{ route('register-team') }}"> Team  </a></li>
                                <li><a href="{{ route('submissonlist') }}"> Digital Prototype Submissions List </a></li>


                                <li><a href="{{ route('physciallysubmissonlist') }}"> Physical Prototype and Sales Presentation List</a></li>

                            </ul>
                        </li>
                    @endadmin
                </ul>
            </div>
            <!--<div class="right">-->
            <!--    <div class="logo">-->
            <!--            <img src="{{ asset('/assets/images/nao-logo.png') }}" alt="CBSE" style="width: 200px; height: 80px;">-->

            <!--        </div>-->

            <!--</div>-->
            <div class="menu-toggle">
                <span>&nbsp;</span>
                <span>&nbsp;</span>
                <span>&nbsp;</span>
            </div>
        </div>
    </div>
</header>
