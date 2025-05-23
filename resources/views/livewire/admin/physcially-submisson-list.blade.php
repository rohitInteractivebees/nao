<div class="common-sec">




    <div class="container">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white">
                <div class="">
                    @if(auth()->user()->is_admin == 1)
                                        <div class="w-100 gap d-flex sm:justify-between justify-center items-end">
                                        <!-- <div class="form-style sm:w-1/2">

                                        <label class="block font-medium text-sm text-gray-700" for="quiz">School</label>
                                        <select class="block mt-1 w-full" wire:model="quiz_id1" name="quiz">
                                            <option value="0">All School</option>
                                            @php
                                            $college = App\Models\Instute::get()
                                            @endphp
                                            @foreach ($college as $quiz)
                                            <option value="{{ $quiz->id }}">{{ $quiz->name }}</option>
                                            @endforeach
                                        </select>
                                        </div> -->

                                            <!-- Publish Button -->


                                            @php
                                                $isPublished = App\Models\User::where('is_admin', 1)->first();

                                               @endphp


                                            @if ($isPublished->level3result == 1)
                                                <!-- Unpublish Button -->

                                                <form action="{{ route('unpublish.level3.result') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="table-btn green">
                                                        <span>Unpublish Result Level 3</span>
                                                    </button>
                                                </form>
                                                <!-- Publish Button -->

                                            @else

                                                <form action="{{ route('publish.level3.result') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="table-btn red">
                                                        <span>Publish Result Level 3</span>
                                                    </button>
                                                </form>

                                            @endif

                                        </div>
                    @endif

                    <div class="mt-4 mb-4 min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">ID</th>
                                    <th width="300">School Name</th>
                                    <th width="200">Team Name</th>
                                    <th width="200">Team Lead Name</th>
                                    <th width="150" align="center">Prototype File</th>
                                    @php 
                                   $resultanc = App\Models\User::find(1);

                                @endphp

                                @if(auth()->user()->is_admin == 1)
                                <th width="150" align="center">Action</th>
                                @else
                                @if($resultanc->level2result == 1)
                               
                                @endif

                                   @endif 
                                </tr>
                            </thead>
                            @php $serial = 1; @endphp
                            <tbody>
                                @forelse($physicaly as $admin)
                                                                <tr>
                                                                    <td>{{ $serial }} @php    $serial++; @endphp</td>
                                                                    @php
                                                                        $teamName = App\Models\Teams::where('teamlead_id', $admin->student_id)->first();
                                                                        $leadname = App\Models\User::find(@$teamName->teamlead_id);
                                                                        $inst = App\Models\Instute::find(@$teamName->college_id);
                                                                    @endphp
                                                                    <td>{{ @$inst->name }}</td>
                                                                    <td>{{ @$teamName->name }}</td>
                                                                    <td>{{ @$leadname->name }}</td>
                                                                    <td align="center">
                                                                       
                                                                        <a data-fancybox href="#prototype-files{{$admin->id}}">
                                                                            <img src="{{ asset('/assets/images/icon-view.png') }}" alt="">
                                                                        </a>



                                                                        <div id="prototype-files{{$admin->id}}" style="display:none;max-width:700px;">
                                                                            <div class="heading short text-center mb-6">File</div>
                                                                            <ul>
                                                                                <li>
                                                                                    <strong>Title </strong>
                                                                                    <p>
                                                                                        {{ $admin->title }}
                                                                                    </p>
                                                                                </li>
                                                                                <li>
                                                                                    <strong>Description </strong>
                                                                                    <p> {{$admin->description}}
                                                                                </li>
                                                                                <li class="d-flex">
                                                                                    <a class="common-btn admin-btn d-flex items-center"
                                                                                        href="{{ url($admin->file) }}" download target="_blank">
                                                                                        <span class="reverse-pos"><img
                                                                                                src="{{ url('/assets/images/icon-upload.png') }}"
                                                                                                alt=""></span>
                                                                                        <span>Prototype File Download</span>
                                                                                    </a>
                                                                                </li>

                                                                            </ul>
                                                                        </div>



                                                                    </td>
                                                                    @if(auth()->user()->is_admin)
                                                                    @if(($teamName))
                                                                    <td align="center">
    @if($teamName->approved_level3 == 1)
        <button data-fancybox data-src="#dialog-contentss" type="button" class="table-btn green approve-button"
                data-team-id="{{ $teamName->id }}"
                data-college-id="{{ $teamName->college_id }}"
                onclick="showModal({{ $teamName->id }}, {{ $teamName->college_id }}, true)">
            Winner
        </button>
    @elseif($teamName->approved_level3 == 2)
        <button data-fancybox data-src="#dialog-contentss" type="button" class="table-btn red approve-button"
                data-team-id="{{ $teamName->id }}"
                data-college-id="{{ $teamName->college_id }}"
                onclick="showModal({{ $teamName->id }}, {{ $teamName->college_id }}, false)">
                1st Runner Up
        </button>
        @elseif($teamName->approved_level3 == 3)
        <button data-fancybox data-src="#dialog-contentss" type="button" class="table-btn red approve-button"
                data-team-id="{{ $teamName->id }}"
                data-college-id="{{ $teamName->college_id }}"
                onclick="showModal({{ $teamName->id }}, {{ $teamName->college_id }}, false)">
                2nd Runner Up
        </button>
        @else
        <button data-fancybox data-src="#dialog-contentss" type="button" class="table-btn approve-button"
                data-team-id="{{ $teamName->id }}"
                data-college-id="{{ $teamName->college_id }}"
                onclick="showModal({{ $teamName->id }}, {{ $teamName->college_id }}, false)">
            Select Team
        </button>
    @endif
</td>
                                                                       
                                                                    @endif

                                                                    @else

                                                                    @if($resultanc->level2result == 1)                  
                              
                                                                    @endif
                                                                    @endif
                                                                   
                                                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
                                            No Submisson were found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $physicaly->links() }}
                </div>
            </div>
        </div>
    </div>

   
<div id="dialog-contentss" style="display: none;">
    <div class="text-center">
        <p><b>Select Winner of Final Round!</b></p>
        <div class="buttons-sec d-flex justify-center w-100 links mt-6">
            <button type="button" class="common-btn admin-btn green" id="confirmApproveButton" onclick="approveTeam()">Winner</button>
            <button type="button" class="common-btn admin-btn red" id="notconfirmApproveButton" onclick="notApproveTeam()">1st Runner Up</button>
            <button type="button" class="common-btn admin-btn red" id="notconfirmApproveButton" onclick="notApproveTeam1()">2nd Runner Up</button>
        </div>
    </div>
</div>

    <style>
        .verify-sec {
            width: 100%;
            CONTAIN-INTRINSIC-BLOCK-SIZE: AUTO 100PX;
            display: none;
            position: fixed;
            left: 0;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            top: 0;
            background: rgba(0, 0, 0, .8);
            z-index: 9999;
        }

        .verify-sec.show {
            display: flex;
        }

        .verify-sec .buttons-sec {
            gap: 20px;
        }

        .common-btn.green {
            background: green;
        }

        .common-btn.green:hover {
            background: #4E5255;
        }

        .verify-sec .inner {
            background: #fff;
            padding: 10px 25px 25px;
            text-align: center;
        }

        .buttons-sec {
            gap: 20px;
        }
    </style>
    <script>
        let selectedTeamId;
let selectedCollegeId;

function showModal(teamId, collegeId, isApproved) {
    selectedTeamId = teamId;
    selectedCollegeId = collegeId;
    $.fancybox.open({
        src: '#dialog-contentss',
        type: 'inline',
        opts: {
            afterShow: function () {
                // You can customize behavior after showing the modal if needed
            },
            afterClose: function () {
                // Reset selected IDs after closing the modal if needed
                selectedTeamId = null;
                selectedCollegeId = null;
            }
        }
    });
}

function approveTeam() {
    fetch(`/finalapprove-team/${selectedTeamId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            team_id: selectedTeamId,
            college_id: selectedCollegeId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Approval failed! Maximum 4 teams per School can be approved.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred!');
    });
}

function notApproveTeam() {
    fetch(`/finalnotapprove-team/${selectedTeamId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            team_id: selectedTeamId,
            college_id: selectedCollegeId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Approval failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred!');
    });
}

function notApproveTeam1() {
    fetch(`/finalnotapprove-team1/${selectedTeamId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            team_id: selectedTeamId,
            college_id: selectedCollegeId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Approval failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred!');
    });
}

    </script>




