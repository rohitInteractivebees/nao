<div>
    <div class="common-sec1">
        <div class="container1">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white">
                    @if(auth()->user()->is_admin)
                        <div class="w-100 gap d-flex sm:justify-between justify-center items-end">
                            <div class="form-style sm:w-1/2">
                                <label class="block font-medium text-sm text-gray-700" for="quiz">School</label>
                                <select class="block mt-1 w-full" wire:model="quiz_id1" name="quiz">
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

                    <div class="mt-6 mb-4 min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
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
                                                                        <!--    <div class="d-flex justify-center">-->
                                                                        <!--        <div class="image">-->
                                                                        <!--            <img src="{{ url('/' . $student->idcard) }}" alt="">-->
                                                                        <!--        </div>-->
                                                                        <!--        <div class="d-flex justify-center w-100 links mt-6">-->
                                                                        <!--            <a href="{{ url('/' . $student->idcard) }}"-->
                                                                        <!--                class="common-btn admin-btn d-flex items-center" download>-->
                                                                        <!--                <span class="reverse-pos"><img-->
                                                                        <!--                        src="{{ asset('/assets/images/icon-upload.png') }}"-->
                                                                        <!--                        alt=""></span>-->
                                                                        <!--                <span>Download ID</span>-->
                                                                        <!--            </a>-->
                                                                        <!--        </div>-->

                                                                        <!--        <div class="d-flex justify-center w-100 links mt-6">-->
                                                                        <!--            <button type="button"-->
                                                                        <!--                class="common-btn admin-btn green verify-button"-->
                                                                        <!--                data-admin-id="{{ $student->id }}">Verify</button>-->
                                                                        <!--        </div>-->

                                                                        <!--        <div class="d-flex justify-center w-100 links mt-6">-->
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
                                            class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
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

    </script>
</div>