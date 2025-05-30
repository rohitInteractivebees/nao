<div>
    <div class="common-sec1">
        <div class="container">
            <div class="items-end justify-between md:flex">
                <div class="item">
                    <div class="mb-0 sub-title">Student List</div>
                </div>
                <div class="item">
                    <div class="items-end justify-center gap-3 right d-flex sm:justify-end">
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
                        <form action="{{ route('student.upload.csv') }}" method="POST" enctype="multipart/form-data" id="csv-upload-form" class="student-upload-form">
                            @csrf
                            <div class="items-end justify-center half-view d-flex gap sm:justify-end">
                                <div class="form-style">
                                    <input type="file" name="csv_file" required>
                                </div>
                                <div class="links">
                                    <button class="items-center common-btn admin-btn d-flex" type="submit">
                                        <span class="reverse-pos"><img src="{{ asset('/assets/images/icon-download.png') }}" alt=""></span>
                                        <span>Upload CSV</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <button class="items-center common-btn admin-btn d-flex common-btn-two" type="submit">
                            <span><img src="{{ asset('/assets/images/icon-download.png') }}" alt=""></span>
                            <a href="{{url('sampleCsv/Student_Registration(Admin).csv')}}" download><span>Download Sample CSV</span></a>
                        </button>

                    </div>
                </div>
            </div>
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white">

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
                                    <th width="100">Sr.No</th>
                                    <th width="300">School Name</th>
                                    <th width="300">Student Name</th>
                                    <th width="400">Parent Email</th>
                                    <th width="150">Parent Phone</th>
                                    <th width="150">Registration Date</th>
                                    <!--<th width="150">Remark</th>-->
                                    <!--<th align="center" width="100">ID Card</th>-->
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
                                                                    <td>{{ $student->email }}</td>
                                                                     <td>+{{ $student->country_code.' '.$student->phone }}</td>
                                                                    <td> {{ $student->created_at->format('d-m-Y') }}</td>


                                                                    <!--<td>-->
                                                                    <!--    {{$student->remark}}-->
                                                                    <!--</td>-->
                                                                    <!--<td align="center">-->
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
                                                                    <!--</td>-->
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
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('loader').style.display = 'none';

                    alert(data.message);

                    // Trigger download
                    if (data.file_url) {
                        const link = document.createElement('a');
                        link.href = data.file_url;
                        link.download = ''; // Let browser use default filename
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                } else {
                    alert(data.message || 'Something went wrong.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong.');
            });
        });
    });
    </script>
</div>
