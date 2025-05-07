<div class="common-sec">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Student</h2>
    </x-slot>

    <x-slot name="title">Student</x-slot>



    <div class="container">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white">
                <div class="items-end justify-center filter-data d-flex sm:justify-between">
                    <div class="left">
                        {{-- <a href="{{ route('student.create') }}" class="common-btn short">Create Student</a> --}}
                    </div>
                    <div class="items-end justify-center right d-flex sm:justify-end">
                        <form action="{{ route('upload.csv') }}" method="POST" enctype="multipart/form-data" id="csv-upload-form">
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
                            <a href="{{url('byd/student_sample.csv')}}" download><span>Download CSV</span></a>
                        </button>
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
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="mt-3 mb-6 filter-options form-style">
                    <select class="w-100" wire:model="quiz_id" name="quiz">
                        <option value="1">All</option>
                        <option value="2">Verified</option>
                        <option value="3">Not Verified</option>
                    </select>
                </div>

                <div class="min-w-full mt-6 mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                    <table class="min-w-full border divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th width="100">ID</th>
                                <th width="300">Name</th>
                                <th width="300">Login Id</th>
                                <th width="400">Email</th>
                                <th width="150">Phone</th>
                                <th width="150">Status</th>
                                <th align="center" width="100">Action</th>
                            </tr>
                        </thead>

                        @php
    $serial = 1;
                    @endphp

                        <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            @forelse($student as $index => $admin)
                            <tr>
                            <td>{{ $serial++ }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->loginId }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->phone }}</td>
                                <td>
                                    @if($admin->is_verified == 1)
                                    <button type="button" class="table-btn green no-hov no-pointer">Verified</button>
                                    @elseif($admin->is_verified == null)
                                    <button type="button" class="table-btn red no-hov no-pointer">Pending</button>
                                    @else
                                    <button type="button" class="table-btn red no-hov no-pointer">Not Verified</button>
                                    @endif
                                </td>
                                <td align="center">
                                    @if($admin->idcard)
                                    <a data-fancybox href="#dialog-content{{ $admin->id }}">
                                        <img src="{{ asset('/assets/images/icon-view.png') }}" alt="">
                                    </a>
                                    @else
                                    <img src="{{ asset('/assets/images/icon-view-closed.png') }}" alt="">
                                    @endif
                                    <div class="verify-sec" id="dialog-content{{ $admin->id }}">
                                        <div class="justify-center d-flex">
                                            <div class="image">
                                                <img src="{{ url('/'.$admin->idcard) }}" alt="">

                                            </div>
                                            <div class="justify-center mt-6 d-flex w-100 links">
                                                <a href="{{ url('/'.$admin->idcard) }}" class="items-center common-btn admin-btn d-flex" download>
                                                    <span class="reverse-pos"><img src="{{ asset('/assets/images/icon-upload.png') }}" alt=""></span>
                                                    <span>Download ID</span>
                                                </a>
                                            </div>
                                            @if($admin->is_verified != 1)
                                            <div class="justify-center mt-6 d-flex w-100 links">
                                                <button type="button" class="common-btn admin-btn green verify-button" data-admin-id="{{ $admin->id }}">Verify</button>
                                            </div>

                                            @endif
                                        </div>
                                    </div>
                                    <a data-fancybox href="#dialog-content-detail{{ $admin->id }}">
                                        <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="">
                                    </a>
                                    <div class="verify-sec" id="dialog-content-detail{{ $admin->id }}">
                                        <form action="{{ route('updateUserPassword') }}" method="POST">
                                            @csrf
                                            <div class="justify-center d-flex">
                                                <strong>Reset User Password</strong>

                                                <input type="hidden" class="block w-full mt-1" value="{{ $admin->id }}" name="user_id">
                                                <div class="form-style">
                                                    <label class="block text-sm font-medium text-gray-700" for="loginId">Login ID</label>
                                                    <input type="text" class="block w-full mt-1"  value="{{ $admin->loginId }}" readonly>
                                                </div>

                                                <div class="form-style">
                                                    <label class="block text-sm font-medium text-gray-700" for="password">New Password</label>
                                                    <input type="text" class="block w-full mt-1" name="password" required>
                                                </div>

                                                <div class="justify-center mt-6 d-flex w-100 links">
                                                    <button type="submit" class="common-btn admin-btn green">Update</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 leading-5 text-center text-gray-900 whitespace-no-wrap">
                                    No Student were found.
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

<style>
    .verify-sec {
        width: 700px;
        max-width: 96%;
        display: none;
    }
    .verify-sec  img{
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



    @media screen and (max-width:1023px) {

        .filter-data .left,
        .filter-data .right {
            width: 100%;
            text-align: center;
        }
    }
</style>

<script>


        document.querySelectorAll('.verify-button').forEach(button => {
            button.addEventListener('click', function(event) {
                let adminId = event.target.dataset.adminId;
                fetch(`/verify-admin/${adminId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            id: adminId,
                            verify: 1
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

        </script>

        <script>

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
    <script>
        function openModal(id) {
            setTimeout(() => {
                Fancybox.show([{ src: "#dialog-content-detail" + id, type: "inline" }]);
            }, 300); // Delay to allow Livewire to finish
        }
    </script>
