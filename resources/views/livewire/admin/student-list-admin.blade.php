<div>

    <div class="pb-6 common-sec1">
        <div class="container">
            <div class="flex-wrap items-center justify-between mt-5 lg:flex">
                <div class="item">
                <div class="mb-0 sub-title">Student Register</div>
                </div>
                <div class="items-center justify-center gap-3 item d-flex">
                    <form action="{{ route('student.upload.csv') }}" method="POST" enctype="multipart/form-data" id="csv-upload-form" class="flex flex-wrap items-center justify-center gap-2 student-upload-form">
                        @csrf
                        <div class="items-end justify-center half-view d-flex gap sm:justify-end">
                            <div class="w-auto mt-0 form-style md:w-auto w-100">
                                <input type="file" name="csv_file" required>
                            </div>
                        </div>
                        <button class="items-center common-btn admin-btn d-flex common-btn-two" type="submit">
                            <span class="reverse-pos"><img src="{{ asset('/assets/images/icon-download.png') }}" alt=""></span>
                            <span>Upload CSV</span>
                        </button>
                    </form>
                    <button class="items-center common-btn admin-btn d-flex common-btn-two" type="submit">
                        <span><img src="{{ asset('/assets/images/icon-download.png') }}" alt=""></span>
                        <a href="{{url('sampleCsv/Student_Registration(Admin).csv')}}" download><span>Download Sample CSV</span></a>
                    </button>

                </div>
            </div>

            <!--Export Div Starts here-->
            <div class="flex flex-wrap items-center justify-center gap-2 mt-2 md:justify-end item md:flex-nowrap">
                <div class="mt-0 md:min-w-[30%] min-w-full">
                    <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name, email, phone or parent name..." class="form-control" style="border: 1px solid #ccc !important;">
                </div>
                <div class="item md:max-w-[20%] mt-0">
                    @if(auth()->user()->is_admin)
                        <div class="mt-0 filter-options form-style">
                            <select class="block w-full" wire:model="quiz_id1" name="quiz">
                                <option value="0">All School</option>
                                @foreach(App\Models\Instute::all() as $college)
                                    <option value="{{ $college->id }}">{{ $college->name }}</option>
                                @endforeach
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        @endif
                </div>
                <div class="mt-0 item filter-options form-style">
                    <select class="block w-full mt-1" wire:model="class_id" name="class_id">
                        <option value="0">All Classes</option>
                        @foreach(App\Models\Classess::all() as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="items-center mt-4 common-btn admin-btn d-flex common-btn-two md:mt-0 " type="submit">
                        <span><img src="{{ asset('/assets/images/icon-download.png') }}" alt=""></span>
                        <a href="{{ route('admin.export.students', ['quiz_id1' => $quiz_id1, 'class_id' => $class_id]) }}" download><span>Export</span></a>
                    </button>


            </div>
            @if ($selectedStudents)
            <div class="md:flex justify-end mt-3 gap-2">
                <div class="mt-0 filter-options form-style md:w-2/5">
                    <select class="block w-full" wire:model="change_school" name="quiz">
                        <option value="0">Select School</option>
                        @foreach(App\Models\Instute::all() as $college)
                            <option value="{{ $college->id }}">{{ $college->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="md:mt-0 mt-4">
                    <button wire:click="updateSelected"
                            wire:loading.attr="disabled"
                            class="items-center common-btn admin-btn d-flex common-btn-two h-[40px] m-auto">
                        Change ({{ count($selectedStudents) }})
                    </button>
                </div>
            </div>    
            @endif
            <!--Export Div Ends here-->
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
                    <div class="loader-sec" id="loader" style="display: none;">
                        <div class="inner">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                    </div>
                    <div id="success-message" style="display: none;">CSV uploaded and emails sent successfully.</div>
                    @if (session()->has('success'))
                        <div class="px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                            {{ session('success') }}
                        </div>


                    @endif

                    <div class="min-w-full mt-6 mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">Sr.No</th>
                                    <th width="100"><input type="checkbox" wire:model="selectAll"></th>
                                    <th width="300">School Name</th>
                                    <th width="300">School Code</th>
                                    <th width="300">Student Name</th>
                                    <th width="300">Login ID</th>
                                    <th width="300">Class</th>
                                    <th width="300">Section</th>
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

                                    <tr wire:key="student-{{ $student->id }}">
                                        <td>{{ $serial++ }}</td>
                                        <td>
                                            @if($student->institute == 'Other')
                                                <input type="checkbox" wire:model="selectedStudents" name="selectedStudents[]" value="{{ $student->id }}">
                                            @endif
                                        </td>
                                        @php
                                            if($student->institute != 'Other')
                                            {
                                                $instituteNameData = App\Models\Instute::where('id', $student->institute)->first();
                                                $instituteName = $instituteNameData->name;
                                                $school_code = $instituteNameData->code;

                                            }else{
                                                $instituteName = $student->institute.' ('.$student->school_name.')';
                                                $school_code = explode("_",$student->reg_no)[0];
                                            }
                                        @endphp
                                        <td>{{ $instituteName }}</td>
                                        <td>{{ $school_code }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->loginId }}</td>
                                        <td>
                                            {{ \App\Models\Classess::whereIn('id', json_decode($student->class))->pluck('name')->join(', ') }}
                                        </td>
                                        <td>{{ !empty($student->section) ? $student->section : 'N/A' }}</td>
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
                                            {{-- <a data-fancybox href="#dialog-content-detail" onclick="dataAdd('{{ $student->id }}','{{ $student->loginId }}')">
                                                <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="" >
                                            </a> --}}
                                            <a href="{{ route('editstudentprofile',['id' => $student->id]) }}">
                                                <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="" >
                                            </a>
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
    {{-- <div class="verify-sec" id="dialog-content-detail" style="display:none;">
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

    </div> --}}
    <section class="loader-sec" id="loaders">
        <div class="inner">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </section>
    <style>
        .form-control{
            height: auto;
            padding: 10px !important;
            line-height: 22px;
        }

        input[type='file'] {
            font-size: 0.9rem;
            height: auto;
            padding: 10px;
            margin: 0;
        }
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


        document.querySelectorAll('.verify-button').forEach(button => {
            button.addEventListener('click', function (event) {
                let loaderanm = document.getElementById('loaders')
                let adminId = event.target.dataset.adminId;
                loaderanm.classList.add("active")
                fetch(`/verify-admin/${adminId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        id: adminId,
                        verify: 1,
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Reload the page to update the status
                        } else {
                            // alert('Verification failed!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        //alert('An error occurred!');
                    });
            });
        });


        document.querySelectorAll('.notverify-button').forEach(button => {
            button.addEventListener('click', function (event) {
                let adminId = event.target.dataset.adminId;
                let buttonContainer = event.target.parentElement;


                // Hide the "Not Verify" button
                event.target.style.display = 'none';

                // Create an input field for the remark
                let inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.classList.add('remark-input');
                inputField.placeholder = 'Enter remark';
                inputField.dataset.adminId = adminId;
                buttonContainer.appendChild(inputField);

                // Create the "Not Verified" button
                let submitButton = document.createElement('button');
                submitButton.textContent = 'Not Verified';
                submitButton.classList.add('common-btn', 'admin-btn', 'red', 'submit-notverify');
                submitButton.dataset.adminId = adminId;
                buttonContainer.appendChild(submitButton);

                // Add event listener to the "Not Verified" button
                submitButton.addEventListener('click', function () {
                    let loaderanm = document.getElementById('loaders')
                let adminId = event.target.dataset.adminId;
                loaderanm.classList.add("active")
                    let remark = inputField.value;

                    fetch(`/verify-admin/${adminId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            id: adminId,
                            verify: 0,
                            remark: remark
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload(); // Reload the page to update the status
                            } else {
                                alert('Action failed!');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // alert('An error occurred!');
                        });
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('csv-upload-form').addEventListener('submit', function(event) {
            event.preventDefault();
            let form = event.target;
            let formData = new FormData(form);

            document.getElementById('loader').style.display = 'flex';

            fetch(form.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loader').style.display = 'none';
                if (data.success) {

                    alert(data.message);

                    // Trigger download
                    if (data.file_url) {
                        const link = document.createElement('a');
                        link.href = data.file_url;
                        link.download = ''; // Let browser use default filename
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        window.location.reload();
                    }
                } else {
                    alert(data.message || 'Something went wrong.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong.');
                document.getElementById('loader').style.display = 'none';
            });
        });
    });
    // function dataAdd(student_id,login_id)
    // {
    //     document.getElementById('student_id').value = student_id;
    //     document.getElementById('login_id').value = login_id;
    // }
    </script>
</div>
