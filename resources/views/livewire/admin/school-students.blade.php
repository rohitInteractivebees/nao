<div>
    <div class="pb-6 common-sec1">
        <div class="container">
            <div class="items-center justify-between mt-6 lg:flex">
                <div class="item md:w-3/5">
                    <div class="mb-0 sub-title">Total Students ({{ $schoolName }})</div>
                </div>
                <div class="item md:w-2/5">
                    <div class="mt-4 md:mt-0">
                        <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name, email, or phone..." class="form-control" style="border: 1px solid #ccc !important;">
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
                                    <th width="100">Class</th>
                                    <th width="400">Parent Email</th>
                                    <th width="200">Parent Phone</th>
                                    <th width="150">Registration Date</th>
                                    {{-- <th align="center" width="100">Action</th> --}}
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
                                        <td>
                                            {{ \App\Models\Classess::whereIn('id', json_decode($student->class))->pluck('name')->join(', ') }}
                                        </td>
                                        <td>{{ !empty($student->email) ? $student->email : 'N/A' }}</td>

                                        <td>
                                            @if($student->country_code || $student->phone)
                                                +{{ trim($student->country_code.' '.$student->phone) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td> {{ $student->created_at->format('d-m-Y') }}</td>
                                        {{-- <td align="center">
                                            <a data-fancybox href="#dialog-content-detail" onclick="dataAdd('{{ $student->id }}','{{ $student->loginId }}')">
                                                <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="" >
                                            </a>
                                        </td> --}}

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
    <div class="verify-sec" id="dialog-content-detail" style="display:none;">
        <div class="sub-title">Reset User Password</div>
        <form action="{{ route('updateUserPassword') }}" method="POST">
            @csrf
            <div class="gap-3 d-flex">

                <input type="hidden" class="block w-full mt-1" value="" name="user_id" id="student_id">
                <div class="form-style w-[48%]">
                    <label class="block text-sm font-medium text-gray-700" for="loginId">Login ID</label>
                    <input type="text" class="block w-full mt-1"  value="" id="login_id" readonly>
                </div>

                <div class="w-1/2 form-style">
                    <label class="block text-sm font-medium text-gray-700" for="password">New Password</label>
                    <input type="text" class="block w-full mt-1" name="password" required>
                </div>

                <div class="justify-center mt-6 d-flex w-100 links">
                    <button type="submit" class="w-full common-btn admin-btn green">Update</button>
                </div>
            </div>
        </form>

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
</div>
