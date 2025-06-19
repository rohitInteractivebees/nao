<div>
    <div class="common-sec1">
        <div class="container">
            <div class="items-center justify-between md:flex">
                <div class="item">
                    <div class="mb-0 sub-title">Quiz Re-attempt</div>
                </div>
                <div class="item sm:w-3/4">
                    <div class="item md:flex gap-2 justify-center mt-4 items-center">
                        @if(auth()->user()->is_admin)
                        <div class=" filter-options form-style md:w-2/5 md:mt-0">
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
                        <div class="md:w-[25%]">
                            <button class="items-center mt-4 common-btn admin-btn d-flex common-btn-two md:mt-0 h-[40px] m-auto">
                                <!--<span><img src="https://naostag.asdc.org.in/assets/images/icon-view.png" alt=""></span>-->
                                <a href="{{ route('allow.reattemptstudentlistadmin') }}" ><span>View Re-attempted Users</span></a>
                            </button>
                            <!--<a href="{{ route('allow.reattemptstudentlistadmin') }}" class="">-->
                            <!--    View Re-attempted Users-->
                            <!--</a>-->
                        </div>
                </div>
                
            </div>
        </div>
            @if ($selectedStudents)
                <div class="mb-4">
                    <button wire:click="updateSelected"
                            wire:loading.attr="disabled"
                            class="px-4 py-2 text-white bg-red-500 rounded">
                        Allow ({{ count($selectedStudents) }})
                    </button>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                    {{ session('success') }}
                </div>


            @endif
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white">
                    <div class="loader-sec" wire:loading wire:target="updateSelected" id="loader-livewire">
                        <div class="inner livewire-loader">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                    </div>

                    <div class="min-w-full mt-6 mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">Sr.No</th>
                                    <th width="100"><input type="checkbox" wire:model="selectAll"></th>
                                    <th width="300">School Name</th>
                                    <th width="300">Student Name</th>
                                    <th width="300">Login ID</th>
                                    <th width="400">Parent Email</th>
                                    <th width="150">Parent Phone</th>
                                    <th width="150">Registration Date</th>
                                    <th align="center" width="100">Action</th>
                                </tr>
                            </thead>
                            @php
                                $serial = ($students->currentPage() - 1) * $students->perPage() + 1;
                            @endphp
                            <tbody>
                                @forelse($students as $student)

                                    <tr>
                                        <td>{{ $serial++ }}</td>
                                        <td><input type="checkbox" wire:model="selectedStudents" name="selectedStudents[]" value="{{ $student->id }}"></td>
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
                                        <td align="center">
                                            <button wire:click="confirmAllow({{ $student->id }})" class="btn btn-sm btn-success table-btn green">
                                                Allow
                                            </button>
                                    </td>

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
    <section class="loader-sec" id="loaders">
        <div class="inner">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </section>
    <style>
        .table-btn {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .no-hov {
            pointer-events: none;
        }

        .verify-sec {
            width: 700px;
            max-width: 96%;
            display: none;
        }

        .verify-sec img {
            max-width: 300px;
        }

        #loader {
            display: none;
            text-align: center;
            font-size: 1.5em;
            color: #333;
        }
                #loader-livewire {
            text-align: center;
            font-size: 1.5em;
            color: #333;

        }
        .livewire-loader {
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important;
            height: 100% !important;
        }

        #success-message {
            display: none;
            text-align: center;
            font-size: 1.5em;
            color: green;
        }

        @media screen and (max-width: 1023px) {

            .filter-data .left,
            .filter-data .right {
                width: 100%;
                text-align: center;
            }
        }
        .loader-sec{
            display: none;
        }
        .loader-sec.active{
            display: flex;
        }
    </style>
    <script>
    window.addEventListener('confirmAllow', event => {
        if (confirm('Do you want to allow reattempt for this user?')) {
            Livewire.emit('allowUser', event.detail.userId);
        }
    });
</script>
</div>
