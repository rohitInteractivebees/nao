<div>
    <div class="common-sec1">
        <div class="container">
            <div class="items-end justify-between md:flex">
                <div class="item">
                    <div class="mb-0 sub-title">View Re-attempted Users</div>
                </div>
                <div class="item sm:w-3/4">
                    <div class="items-end justify-center gap-3 right md:flex sm:justify-end">
                        @if(auth()->user()->is_admin)
                        <div class=" filter-options form-style">
                            <select class="block w-full mt-1" wire:model="quiz_id1" name="quiz">
                                <option value="0">All School</option>
                                @foreach(App\Models\Instute::all() as $college)
                                    <option value="{{ $college->id }}">{{ $college->name }}</option>
                                @endforeach
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        @endif
                    <div class="mt-4 md:w-2/5 md:mt-0">
                        <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name, email, or phone..." class="form-control" style="border: 1px solid #ccc !important;">
                    </div>
                </div>
            </div>
        </div>

            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white">


                    <div class="min-w-full mt-6 mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">Sr.No</th>
                                    <th width="300">School Name</th>
                                    <th width="300">Student Name</th>
                                    <th width="300">Login ID</th>
                                    <th width="400">Parent Email</th>
                                    <th width="150">Parent Phone</th>
                                    <th width="150">Registration Date</th>
                                </tr>
                            </thead>
                            @php
                                $serial = ($students->currentPage() - 1) * $students->perPage() + 1;
                            @endphp
                            <tbody>
                                @forelse($students as $student)

                                    <tr>
                                        <td>{{ $serial++ }}</td>
                                        @php
                                            if($student->institute != 'Other')
                                            {
                                                $instituteName = App\Models\Instute::where('id', $student->institute)->value('name');

                                            }else{
                                                $instituteName = $student->institute.' ('.$student->school_name.')';
                                            }
                                        @endphp
                                        <td>{{ $instituteName }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->loginId }}</td>
                                        <td>{{ !empty($student->email) ? $student->email : 'N/A' }}</td>

                                        <td>
                                            @if($student->country_code || $student->phone)
                                                +{{ trim($student->country_code.' '.$student->phone) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td> {{ $student->created_at->format('d-m-Y') }}</td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 leading-5 text-center text-gray-900 whitespace-no-wrap">
                                            No Student were found.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    {{ $students->links() }}
                </div>
            </div>
        </div>

    </div>

</div>
