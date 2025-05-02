<div class="common-sec">


    

<div class="container">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white">
            <div class="">
                <div class="w-100 gap d-flex sm:justify-between justify-center items-end">
                    <div class="form-style sm:w-1/2">
                        @if(auth()->user()->is_admin == 1)
                       
                        @endif
                    </div>
                   
                </div>

                @php
                     $userP =  App\Models\User::find(1);
                        $currentDate = \Carbon\Carbon::now()->format('Y-m-d'); // Format the current date
                    @endphp
               
                @forelse($prototypes as $admin)
               
                      
                    @empty

                    @php
                   $tml =  App\Models\Teams::where('teamlead_id', auth()->user()->id)->first();
                    @endphp
                    @if($tml)
                    @if($userP->level3enddate >= $currentDate)
                    <div class="mb-4">
                        <a href="{{ route('student-physcially-submisson') }}"
                            class="common-btn short">
                            Upload Prototype 
                        </a>
                    </div>
                    @endif
                    @endif
                            @endforelse


                <div class="mt-4 mb-4 min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                    <table class="min-w-full border divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th width="100">ID</th>
                                <th width="300">Institute Name</th>
                                <th width="200">Team Name</th>
                                <th width="200">Team Lead Name</th>
                                <th width="150" align="center">File</th>
                                @php 
                                   $resultanc = App\Models\User::find(1);
                                     $temld = App\Models\Teams::where('teamlead_id', auth()->user()->id)->first();
                                @endphp
                                @if($temld)
                               
                                <th width="150" align="center">Action</th>
                               
                               @endif
                               
                                <!-- <th width="150" align="center">Result</th> -->
                               
                            </tr>
                        </thead>
                        @php $serial = 1; @endphp
                        <tbody>
                            @forelse($prototypes as $admin)
                            <tr>
                                <td>{{ $serial }} @php $serial++; @endphp </td>
                                @php
                                $teamName = App\Models\Teams::where('teamlead_id', $admin->student_id)->first();
                                $leadname = App\Models\User::find(@$teamName->teamlead_id);
                                $inst = App\Models\Instute::find(@$teamName->college_id);
                                @endphp
                                <td>{{ @$inst->name }}</td>
                                <td>{{ @$teamName->name }}</td>
                                <td>{{ @$leadname->name }}</td>
                                <td align="center">
                                    <!--<a href="{{ url($admin->file) }}" download target="_blank">
                                        <img src="{{ asset('/assets/images/icon-download.png') }}" alt="">
                                    </a>-->
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
            <a class="common-btn admin-btn d-flex items-center"  href="{{ url($admin->file) }}" download target="_blank">
                <span class="reverse-pos"><img src="https://byd-innovate-a-thon.asdc.org.in/assets/images/icon-upload.png" alt=""></span>
                <span>File Download</span>
            </a>
        </li>
           
    </ul>
</div>


                                </td>
                                @if($temld)
                                
                                <td align="center">
                                    @if($admin->edited == 1)
                                    <button  class="table-btn green">Submitted</button>
                                    @else
                                    @if($userP->level3enddate >= $currentDate)
                                       <a class="table-btn red approve-button" href="{{ route('student-physcially-submisson.edit',  $admin->id ) }}">
                                      Edit
                                       </a>
                                       @else
                                       <button  class="table-btn green">Submitted</button>
                                       @endif
                                      

                                    @endif
                                </td>
                                
                                @endif
                                @if($resultanc->level2result == 1)
                            {{--    <td align="center">
                                @if(isset($teamName->approved_level2))
                                                                        
                                                                            @if($teamName->approved_level2 == 1)
                                                                                <span type="button" class="table-btn green no-hov">Selected</span>
                                                                            @else
                                                                                <button type="button" class="table-btn red approve-button">
                                                                                   
                                                                                    
                                                                                Not Selected
                                                                                </button>

                                                                            @endif
                                                                        
                                                                        @else
                                                                        <span type="button" class="table-btn green no-hov"> coming soon</span>
                                                                    @endif
                                                                    </td> --}}
                                                                    @endif
                              
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
                                    No Submisson were found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
              
            </div>
        </div>
    </div>
</div>



<style>
    .verify-sec{
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
        background: rgba(0,0,0,.8);
        z-index: 9999;
    }
    .verify-sec.show{
        display: flex;
    }
    .verify-sec .buttons-sec {
        gap: 20px;
    }
    .common-btn.green {
        background: green;
    }
    .common-btn.green:hover{
        background: #4E5255;
    }
    .verify-sec .inner{
        background: #fff;
        padding: 10px 25px 25px;
        text-align: center;
    }
    .buttons-sec{
        gap: 20px;
    }
</style>   
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedTeamId;
    let selectedCollegeId;

    document.querySelectorAll('.approve-button').forEach(button => {
        button.addEventListener('click', function(event) {
            selectedTeamId = event.target.dataset.teamId;
            selectedCollegeId = event.target.dataset.collegeId;
            $('#dialog-contents').addClass("show")
        });
    });
    
    
    document.getElementById('confirmApproveButton').addEventListener('click', function() {
        
        fetch(`/approve-team/${selectedTeamId}`, {
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
                //alert('Team approved successfully!');
                location.reload(); 
            } else {
                alert('Approval failed! Maximum 4 teams per Institute can be approved.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred!');
        });
    });
});
</script>




