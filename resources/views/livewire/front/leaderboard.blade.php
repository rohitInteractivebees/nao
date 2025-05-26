 <section class="common-sec collage-dashboared common-sec1">
     <div class="container">
         <div class="filter-data d-flex justify-between items-center">
             <div class="left">
                 <div class="half-view d-flex justify-between">
                 @if(auth()->user()->is_admin == 1)
                     <div class="form-style">
                         <label class="block font-medium text-sm text-gray-700" for="quiz">School</label>
                         
                         <select class="block mt-1 w-full" wire:model="quiz_id" name="quiz">
                             <option value="0">All School</option>
                             @foreach ($college as $quiz)
                             <option value="{{ $quiz->id }}">{{ $quiz->name }}</option>
                             @endforeach
                         </select>
                        
                     </div>
                     @endif
                 </div>
             </div>
         </div>
         <div class="table-sec-outer mt-6">
             <table class="table-sec">
                 <thead>
                     <tr>
                         <th width="100">S. No</th>
                         <th width="300">Username</th>
                         @if(auth()->user()->is_admin == 1)
                            <th width="500">School</th>
                        @endif
                         <th width="300">Correct Answers</th>
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
                         @if(auth()->user()->is_admin == 1)
                         <td>
                             @php
                             $clgname = App\Models\Instute::find($test->user->institute);
                             @endphp
                             {{ @$clgname->name }}
                         </td>
                         @endif
                         @php
                         $qus_count = 20;
                         @endphp

                         <td>
                             {{ $test->result }} /
                             {{ $qus_count }}
                             (time:
                             {{ sprintf('%.2f', $test->time_spent / 60) }}
                             minutes)
                         </td>
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
     </div>
 </section>