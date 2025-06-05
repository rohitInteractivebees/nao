 <section class="pt-0 common-sec collage-dashboared common-sec1">
     <div class="container">
         <div class="items-center justify-between filter-data d-flex">
             <div class="left">
                 <div class="justify-between half-view d-flex">
                 @if(auth()->user()->is_admin == 1)
                     <div class="pt-0 form-style">
                         <label class="block text-sm font-medium text-gray-700" for="quiz">School</label>

                         <select class="block w-full mt-1" wire:model="quiz_id" name="quiz">
                             <option value="0">All School</option>
                             @foreach ($college as $quiz)
                             <option value="{{ $quiz->id }}">{{ $quiz->name }}</option>
                             @endforeach
                             <option value="Other">Other</option>
                         </select>

                     </div>
                     @endif
                 </div>
             </div>
         </div>
         <div class="mt-6 table-sec-outer">
             <table class="table-sec">
                 <thead>
                     <tr>
                         <th width="100">S. No</th>
                         <th width="300">Student Name</th>
                         <th width="300">Class</th>
                         <th width="300">Parent Email</th>
                         @if(auth()->user()->is_admin == 1)
                            <th width="500">School</th>
                        @endif
                         <th width="300">Correct Answers</th>
                         @if(auth()->user()->is_college == 1)
                            <th width="150">Result</th>
                        @endif
                     </tr>
                 </thead>
                 <tbody>
                     @forelse ($tests as $test)
                     <tr @class([ ''=> auth()->check() && $test->user->name == auth()->user()->name,
                         ])>
                         <td>
                             {{ $loop->iteration }}
                         </td>
                         <td>
                             {{ $test->user->name }}
                         </td>
                         <td>
                            {{ \App\Models\Classess::whereIn('id', json_decode($test->user->class))->pluck('name')->join(', ') }}
                        </td>
                        <td>{{ !empty($test->user->email) ? $test->user->email : 'N/A' }}</td>

                         @if(auth()->user()->is_admin == 1)
                         <td>
                            @php
                            if($test->user->institute != 'Other')
                            {
                                $instituteName = App\Models\Instute::where('id', $test->user->institute)->value('name');

                            }else{
                                $instituteName = $test->user->institute.' ('.$test->user->school_name.')';
                            }
                            @endphp
                            {{ $instituteName }}
                         </td>
                         @endif
                         @php
                         $qus_count = $test->questions_count;
                         @endphp

                         <td>
                             {{ $test->result }} /
                             {{ $qus_count }}
                             (Time:
                             {{ intval($test->time_spent / 60) >= $test->quiz->duration ? $test->quiz->duration : intval($test->time_spent / 60) }}:{{ intval($test->time_spent / 60) >= $test->quiz->duration ? '00' : gmdate('s', $test->time_spent) }}
                                        minutes)
                         </td>
                         @if(auth()->user()->is_college == 1)
                         <td>
                                @php
                                        $marks_percent = ($qus_count * $test->quiz->pass_fail_percent / 100 );
                                    @endphp
                                    @if($test->result >= $marks_percent)
                                        <div class="table-btn green no-hov"><span class="">Pass</span></div>
                                    @else
                                        <div class="table-btn red no-hov"><span class="">Fail </span></div>
                                    @endif
                         </td>
                         @endif
                     </tr>
                     @empty
                     <tr>
                         <td colspan="4" align="center">No results.</td>
                     </tr>
                     @endforelse
                     {{-- @forelse ($users as $user)
                                @foreach ($user->tests as $test)
                                    <tr @class([
                                        '' => auth()->check() && $user->name == auth()->user()->name,
                                    ])>
                                        <td>
                                            {{ $loop->iteration }}
                     </td>
                     <td>
                         {{ $user->name }}
                     </td>
                     <td>
                         {{ $test->quiz->title }}
                     </td>
                     <td>
                         {{ $test->result }} /
                         {{ $test->quiz->questions_count }}
                         (time:
                         {{ sprintf('%.2f', $test->time_spent / 60) }}
                         minutes)
                     </td>
                     </tr>
                     @endforeach
                     @empty
                     <tr>
                         <td colspan="4" align="center">No results.</td>
                     </tr>
                     @endforelse --}}
                 </tbody>
             </table>
         </div>
         {{ $tests->links() }}
     </div>
 </section>
