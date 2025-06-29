<div>
    <div class="pb-12">
        <div class="container">
            <div class="items-center flex-wrap gap-2 justify-between my-5 md:flex">
                <div class="item d-flex justify-center">
                    <div class="mb-0 sub-title">School Register</div>
                </div>
                <div class="item d-flex gap-2 justify-center mt-4 items-center">
                    <form action="{{ route('school.upload.csv') }}" method="POST" enctype="multipart/form-data" id="csv-upload-form" class="student-upload-form flex items-center gap-2 flex-wrap justify-center">
                        @csrf
                        <div class="items-center d-flex sm:justify-end">
                            <div class="form-style mt-0">
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
                        <a href="{{url('sampleCsv/School_Registration(Admin).csv')}}" download><span>Download Sample CSV</span></a>
                    </button>

                </div>
            </div>
            <div class="items-center flex-wrap gap-2 md:justify-end my-5 md:flex justify-center">
                <div class=" md:mt-0">
                <input type="text" wire:model.debounce.500ms="search" placeholder="Search " class="form-control" style="border: 1px solid #ccc !important;">
                </div>
                <div class="item">
                     <button class="items-center common-btn admin-btn d-flex common-btn-two md:mt-0 m-auto mt-4 " type="submit">
                        <span><img src="{{ asset('/assets/images/icon-download.png') }}" alt=""></span>
                        <a href="{{ route('admin.export.school') }}" download><span>Export</span></a>
                    </button>
                </div>
            </div>
        </div>



        <div class="mx-auto max-w-7xl">
            <div class="overflow-hidden bg-white">
                <div class="">
                    {{-- <div class="mb-4">
                        <a href="{{ route('institute_login.create') }}"
                            class="common-btn short">
                            Create School
                        </a>
                    </div> --}}
                    <div class="loader-sec" id="loader" style="display: none;">
                        <div class="inner">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                    </div>
                    <div id="success-message" style="display: none;">CSV uploaded and emails sent successfully.</div>
                    <div class="min-w-full mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">
                                        Sr.No
                                    </th>
                                    <th width="400">
                                        School
                                    </th>
                                    <th width="400">
                                        Code
                                    </th>
                                    <th width="900">
                                        Register Link
                                    </th>
                                    <th width="200">
                                       Principal Name
                                    </th>
                                    <th width="300">
                                        Principal Email
                                    </th>
                                    <th width="300">
                                        Principal Mobile
                                    </th>
                                     <th width="900">
                                        Total Student
                                    </th>
                                    <th width="900">
                                        Participant Student
                                    </th>
                                    <th align="center" width="100">Action</th>


                                </tr>
                            </thead>

                            <tbody>
                                @forelse($admins as $index => $admin)
                                    <tr>
                                        <td>{{ $admins->firstItem() + $index }}</td>
                                        @php
                                            if($admin->institute != 'Other')
                                            {
                                                $instituteName = App\Models\Instute::where('id', $admin->institute)->value('name');

                                            }else{
                                                $instituteName = $admin->institute.' ('.$admin->school_name.')';
                                            }
                                        @endphp
                                        <td>{{ $instituteName }}</td>
                                        <td>
                                            {{ $admin->code }}
                                        </td>
                                        <td>
                                            @php
                                                $baseUrl = url('/register/')
                                            @endphp
                                            {{ $baseUrl . '/' . $admin->code }}
                                        </td>
                                        <td>
                                            {{ $admin->name }}
                                        </td>
                                        <td>{{ !empty($admin->email) ? $admin->email : 'N/A' }}</td>

                                        <td>
                                            @if($admin->country_code || $admin->phone)
                                                +{{ trim($admin->country_code.' '.$admin->phone) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $studenclg = App\Models\User::where('institute', $admin->institute)->where('is_college', null)->get();
                                            @endphp
                                            <a href="{{ route('schoolStudents') . '?school='.$admin->schoolID }}">{{count($studenclg)}}</a>
                                        </td>
                                        <td>
                                            @php
                                                $partstudentCount = App\Models\Test::whereIn('user_id', $studenclg->pluck('id'))->distinct('user_id')->count('user_id');
                                            @endphp

                                            <a href="{{ route('schoolStudentsParticipents') . '?school='.$admin->schoolID }}">{{ $partstudentCount }}</a>
                                        </td>
                                        <td align="center">
                                            <a href="{{ route('editschoolprofile',['id' => $admin->id]) }}">
                                                <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="" >
                                            </a>
                                        </td>



                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 leading-5 text-center text-gray-900 whitespace-no-wrap">
                                            No School were found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $admins->links() }}
                </div>
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
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('verify-button')) {
        const button = event.target;
        const adminId = button.dataset.id;
        const loaderanm = document.getElementById('loaders');

        loaderanm?.classList.add("active");

        const verifySchoolUrl = "{{ url('/verify-school/__ID__') }}".replace('__ID__', adminId);

        fetch(verifySchoolUrl, {
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
            loaderanm?.classList.remove("active");

            if (data.success) {
                button.classList.remove('yellow');
                button.classList.add('green', 'no-pointer');
                button.textContent = 'Verified';
                button.disabled = true;
            } else {
                alert('Verification failed!');
            }
        })
        .catch(error => {
            loaderanm?.classList.remove("active");
            console.error('Error:', error);
            alert('An error occurred!');
        });
    }
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




