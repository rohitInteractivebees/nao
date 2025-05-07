<div>
    <div class="common-sec1">
        <div class="container1">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white">
                    <div class="items-end justify-center filter-data d-flex sm:justify-between">
                        <div class="left">
                            {{-- <a href="{{ route('student.create') }}" class="common-btn short">Create Student</a> --}}
                        </div>
                        <div class="items-end justify-center right d-flex sm:justify-end">
                            <form action="{{ route('student.upload.csv') }}" method="POST" enctype="multipart/form-data" id="csv-upload-form">
                                @csrf
                                <div class="items-end justify-center half-view d-flex gap sm:justify-end">
                                    <div class="form-style">
                                        <input type="file" name="csv_file">
                                    </div>
                                    <div class="links">
                                        <button class="items-center common-btn admin-btn text d-flex" type="submit">
                                            <span class="reverse-pos"><img src="{{ asset('/assets/images/icon-download.png') }}" alt=""></span>
                                            <span>Upload CSV</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <button class="items-center common-btn admin-btn text d-flex" type="submit">
                                <span><img src="{{ asset('/assets/images/icon-download.png') }}" alt=""></span>
                                <a href="{{url('byd/admin_student_sample.csv')}}" download><span>Download CSV</span></a>
                            </button>
                        </div>
                    </div>
                    @if(auth()->user()->is_admin)
                        <div class="items-end justify-center w-100 gap d-flex sm:justify-between">
                            <div class="form-style sm:w-1/2">
                                <label class="block text-sm font-medium text-gray-700" for="quiz">School</label>
                                <select class="block w-full mt-1" wire:model="quiz_id1" name="quiz">
                                    <option value="0">All School</option>
                                    @foreach(App\Models\Instute::all() as $college)
                                        <option value="{{ $college->id }}">{{ $college->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-style sm:w-1/2">

                                <a href="#" class="table-btn">Download Excel</a>
                                <!--<a href="{{url('download-student')}}" class="table-btn">Download Excel</a>-->
                            </div>

                        </div>

                    @endif
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
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="min-w-full mt-6 mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">ID</th>
                                    <th width="300">School Name</th>
                                    <th width="300">Name</th>
                                    <th width="400">Email</th>
                                    <th width="150">Phone</th>
                                    <th width="150">Registration Date</th>
                                    <th width="150">Status</th>
                                    <th width="150">Remark</th>
                                    <th align="center" width="100">ID Card</th>
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
                                                                        $inst = App\Models\Instute::find(@$student->institute);
                                                                    @endphp
                                                                    <td>{{ @$inst->name }}</td>
                                                                    <td>{{ $student->name }}</td>
                                                                    <td>{{ $student->email }}</td>
                                                                    <td>{{ $student->phone }}</td>
                                                                    <td> {{ $student->created_at->format('d-m-Y h:i a') }}</td>


                                                                    <td>

@if($student->is_verified == null)
<button type="button" class="table-btn yellow no-hov no-pointer">Verify</button>

@elseif($student->is_verified == 1)
<button type="button" class="table-btn green no-hov no-pointer">Verified</button>

@else
<button type="button" class="table-btn red no-hov no-pointer">Not Verified</button>
@endif

                                                                    </td>
                                                                    <td>
                                                                        {{$student->remark}}
                                                                    </td>
                                                                    <td align="center">
                                                                        <!--@if($student->idcard)-->
                                                                        <!--    <a data-fancybox href="#dialog-content{{ $student->id }}">-->
                                                                        <!--        <img src="{{ asset('/assets/images/icon-view.png') }}" alt="">-->
                                                                        <!--    </a>-->
                                                                        <!--@else-->
                                                                        <!--    <img src="{{ asset('/assets/images/icon-view-closed.png') }}" alt="">-->
                                                                        <!--@endif-->
                                                                        <!--<div class="verify-sec" id="dialog-content{{ $student->id }}">-->
                                                                        <!--    <div class="justify-center d-flex">-->
                                                                        <!--        <div class="image">-->
                                                                        <!--            <img src="{{ url('/' . $student->idcard) }}" alt="">-->
                                                                        <!--        </div>-->
                                                                        <!--        <div class="justify-center mt-6 d-flex w-100 links">-->
                                                                        <!--            <a href="{{ url('/' . $student->idcard) }}"-->
                                                                        <!--                class="items-center common-btn admin-btn d-flex" download>-->
                                                                        <!--                <span class="reverse-pos"><img-->
                                                                        <!--                        src="{{ asset('/assets/images/icon-upload.png') }}"-->
                                                                        <!--                        alt=""></span>-->
                                                                        <!--                <span>Download ID</span>-->
                                                                        <!--            </a>-->
                                                                        <!--        </div>-->

                                                                        <!--        <div class="justify-center mt-6 d-flex w-100 links">-->
                                                                        <!--            <button type="button"-->
                                                                        <!--                class="common-btn admin-btn green verify-button"-->
                                                                        <!--                data-admin-id="{{ $student->id }}">Verify</button>-->
                                                                        <!--        </div>-->

                                                                        <!--        <div class="justify-center mt-6 d-flex w-100 links">-->
                                                                        <!--            <button type="button"-->
                                                                        <!--                class="common-btn admin-btn green notverify-button"-->
                                                                        <!--                data-admin-id="{{ $student->id }}">Not Verify</button>-->
                                                                        <!--        </div>-->

                                                                        <!--    </div>-->
                                                                        <!--</div>-->
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
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(async (response) => {
                    document.getElementById('loader').style.display = 'none';

                    const data = await response.json();

                    if (!response.ok) {
                        // Handle validation or server errors
                        throw new Error(data.message || 'An error occurred');
                    }

                    // Success
                    alert(data.message || 'Upload successful!');
                    form.reset(); // Optional
                    window.location.reload(); // Optional
                })
                .catch(error => {
                    document.getElementById('loader').style.display = 'none';
                    alert(error.message || 'An unexpected error occurred');
                });
        });
    });
    </script>
</div>
