<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Team Management
        </h2>
    </x-slot>

    <x-slot name="title">
        Teams
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
             <!-- filter -->
        
             @if(auth()->user()->is_admin == 1)
                                        
                                            <div class="form-style sm:w-1/2">

                                                <label class="block font-medium text-sm text-gray-700" for="quiz">School</label>
                                                <select class="block mt-1 w-full" wire:model="quiz_id" name="quiz">
                                                    <option value="0">All School</option>
                                                    @php
                                                        $college = App\Models\Instute::get()
                                                    @endphp
                                                    @foreach ($college as $quiz)
                                                        <option value="{{ $quiz->id }}">{{ $quiz->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
@endif
             <!-- end filter -->
            <div class="overflow-hidden bg-white">
                <div class="">
                   @php
                   
                   $userId = auth()->user()->id;

$tea = App\Models\Teams::where(function ($query) use ($userId) {
        $query->whereRaw('JSON_CONTAINS(teamMembers, \'["' . $userId . '"]\')');
    })
    ->first();

    $tea1 = App\Models\Teams::where('teamlead_id',$userId)->first();

      


                   
                   @endphp
                   @if(!$tea && !$tea1 && auth()->user()->is_college != 1 &&  auth()->user()->is_admin != 1)
                    <div class="mb-4">
                        <a href="{{ route('team.create') }}"
                            class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                            Create Team
                        </a>
                    </div>
                    @endif
                    <!-- <div class="form-style">
                        <label>Select School</label>
                        <select class="p-3 w-full text-sm leading-5 mb-3 text-slate-600">
                            <option value="0">All School</option>
                            <option value="15">National School of Technology</option>
                        </select>     
                    </div>                    -->
                    <div class="mt-4 mb-4 min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="50">
                                        ID
                                    </th>
                                    <th width="200">
                                        School Name
                                    </th>
                                    <th width="200">
                                        Team Name
                                    </th>
                                    <th width="150">
                                        Mentor Name
                                    </th>
                                    <th width="150">
                                        Mentor Details
                                    </th>
                                    <th width="200">
                                        Team member
                                    </th>

                                    @php
                   $isPublished =  App\Models\User::where('is_admin', 1)->first();
                     
                   @endphp

                   
                   @if ($isPublished->level2result == 1)

                                    <th width="100" align="center">
                                        Level 2
                                    </th>
                                   @endif 
                                   @if ($isPublished->level3result == 1)

                                    <th width="100" align="center">
                                       Final Result
                                    </th>
                                   @endif 
                                   
                                </tr>
                            </thead>
                            @php $serial = 1; @endphp
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @forelse($student as $admin)
                                    <tr>
                                        <td>
                                            {{ $serial }}
                                            @php $serial++; @endphp
                                        </td>
                                        <td>
                                        @php
                             $clgname = App\Models\Instute::find($admin->college_id);
                             @endphp
                             {{ @$clgname->name }}
                                        </td>
                                        <td>
                                            {{ @$admin->name }}
                                        </td>
                                        <td>
                                            {{ $admin->mentorname }}
                                        </td>
                                        <td>
                                            {{ $admin->mentordetails }}
                                        </td>
                                        @php 
                                        
                                        $teammembers= App\Models\User::whereIn('id',json_decode($admin->teamMembers))->get(); 
                                        $tealead =  App\Models\User::where('id',json_decode($admin->teamlead_id))->first(); 
                                        
                                        @endphp
                                         
                                        <td>
                                        <div><b>{{@$tealead->name}} (Team lead)</b></div> {{@$tealead->email}}<br>
                                            @foreach($teammembers as $member)
                                            <div><b>{{ $member->name }}</b></div> {{$member->email}} <br>
                                            @endforeach
                                            
                                        </td>

                                        @if ($isPublished->level2result == 1)
                                        <td align="center">

                                       @if($admin->approved_level2 == 1)
                                       <button type="button" class="table-btn green no-hov no-pointer">
                                        Selected
                                        </button>
                                       @else
                                       <button type="button" class="table-btn red no-hov no-pointer">
                                       Not Selected
                                        </button>
                                       @endif
                                           
                                        </td>
                                        @endif


                                        @if ($isPublished->level3result == 1)
                                        <td align="center">

                                       @if($admin->approved_level3 == 1)
                                       <button type="button" class="table-btn green no-hov no-pointer">
                                        Winner
                                        </button>
                                       @elseif($admin->approved_level3 == 2)
                                       <button type="button" class="table-btn green no-hov no-pointer">
                                       1st Runner Up
                                        </button>
                                        @elseif($admin->approved_level3 == 3)
                                       <button type="button" class="table-btn green no-hov no-pointer">
                                       2nd Runner Up
                                        </button>
                                        @else
                                       
                                       <button type="button" class="table-btn red no-hov no-pointer">
                                       Not Selected
                                        </button>
                                       @endif
                                           
                                        </td>
                                        @endif


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
                                            No Teams were found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $student->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
