<div class="py-4 common-sec">
    <div class="container">
        <div class="items-end justify-between md:flex">
            <div class="item">
                <div class="mb-0 sub-title">Student List</div>
            </div>
            <div class="item">
                <div class="items-end justify-center gap-3 right d-flex sm:justify-end">
                    <div class=" filter-options form-style">
                        <select class="w-100" wire:model="class_id" name="class_id">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <form action="{{ route('upload.csv') }}" method="POST" enctype="multipart/form-data" id="csv-upload-form" class="student-upload-form">
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
                        <a href="{{url('sampleCsv/Student_Registration(School).csv')}}" download><span>Download Sample CSV</span></a>
                    </button>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl">
            <div class="overflow-hidden bg-white">
                <div class="items-end justify-center filter-data d-flex sm:justify-between">
                    <div class="left">
                        {{-- <a href="{{ route('student.create') }}" class="common-btn short">Create Student</a> --}}
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
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function () {
            let alertBox = document.getElementById('success-alert');
            if (alertBox) {
                alertBox.style.transition = 'opacity 0.5s ease';
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500); // Fully remove after fade out
            }
        }, 3000); // 3 seconds
    </script>
@endif



                <div class="min-w-full mt-6 mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                    <table class="min-w-full border divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th width="100">Sr.No</th>
                                <th width="300">Student Name</th>
                                <th width="300">Class</th>
                                <th width="400">Parent Email</th>
                                <th width="150">Parent Phone</th>
                                <!--<th width="150">Status</th>-->
                                <th align="center" width="100">Action</th>
                            </tr>
                        </thead>

                        @php
    $serial = 1;
                    @endphp

                        <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            @forelse($student as $index => $admin)
                            <tr>
                            <td>{{ ($student->currentPage() - 1) * $student->perPage() + $loop->iteration }}</td>

                                <td>{{ $admin->name }}</td>
                                <td>
                                    {{ \App\Models\Classess::whereIn('id', json_decode($admin->class))->pluck('name')->join(', ') }}
                                </td>
                                <td>{{ !empty($admin->email) ? $admin->email : 'N/A' }}</td>

                                <td>
                                    @if($admin->country_code || $admin->phone)
                                        +{{ trim($admin->country_code.' '.$admin->phone) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <!--<td>-->
                                <!--    @if($admin->is_verified == 1)-->
                                <!--    <button type="button" class="table-btn green no-hov no-pointer">Verified</button>-->
                                <!--    @else-->
                                <!--    <button type="button" class="table-btn red no-hov no-pointer">Not Verified</button>-->
                                <!--    @endif-->
                                <!--</td>-->
                                <td align="center">
                                    <!--@if($admin->idcard)-->
                                    <!--<a data-fancybox href="#dialog-content{{ $admin->id }}">-->
                                    <!--    <img src="{{ asset('/assets/images/icon-view.png') }}" alt="">-->
                                    <!--</a>-->
                                    <!--@else-->
                                    <!--<img src="{{ asset('/assets/images/icon-view-closed.png') }}" alt="">-->
                                    <!--@endif-->
                                    <!--<div class="verify-sec" id="dialog-content{{ $admin->id }}">-->
                                    <!--    <div class="justify-center d-flex">-->
                                    <!--        <div class="image">-->
                                    <!--            <img src="{{ url('/'.$admin->idcard) }}" alt="">-->

                                    <!--        </div>-->
                                    <!--        <div class="justify-center mt-6 d-flex w-100 links">-->
                                    <!--            <a href="{{ url('/'.$admin->idcard) }}" class="items-center common-btn admin-btn d-flex" download>-->
                                    <!--                <span class="reverse-pos"><img src="{{ asset('/assets/images/icon-upload.png') }}" alt=""></span>-->
                                    <!--                <span>Download ID</span>-->
                                    <!--            </a>-->
                                    <!--        </div>-->
                                    <!--        @if($admin->is_verified != 1)-->
                                    <!--        <div class="justify-center mt-6 d-flex w-100 links">-->
                                    <!--            <button type="button" class="common-btn admin-btn green verify-button" data-admin-id="{{ $admin->id }}">Verify</button>-->
                                    <!--        </div>-->

                                    <!--        @endif-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <a data-fancybox href="#dialog-content-detail{{ $admin->id }}">
                                        <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="" >
                                    </a>
                                    <div class="verify-sec" id="dialog-content-detail{{ $admin->id }}">
                                        <div class="sub-title">Reset User Password</div>
                                        <form action="{{ route('updateUserPassword') }}" method="POST">
                                            @csrf
                                            <div class="gap-3 d-flex">

                                                <input type="hidden" class="block w-full mt-1" value="{{ $admin->id }}" name="user_id">
                                                <div class="form-style w-[48%]">
                                                    <label class="block text-sm font-medium text-gray-700" for="loginId">Login ID</label>
                                                    <input type="text" class="block w-full mt-1"  value="{{ $admin->loginId }}" readonly>
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
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="">
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
    </script>
    <script>
        function openModal(id) {
            setTimeout(() => {
                Fancybox.show([{ src: "#dialog-content-detail" + id, type: "inline" }]);
            }, 300); // Delay to allow Livewire to finish
        }
    </script>
