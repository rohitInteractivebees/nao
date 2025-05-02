<div>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white">
                <div class="">
                    {{-- <div class="mb-4">
                        <a href="{{ route('institute_login.create') }}"
                            class="common-btn short">
                            Create School
                        </a>
                    </div> --}}

                    <div class="min-w-full mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">
                                        ID
                                    </th>
                                    <th width="200">
                                        Name
                                    </th>
                                    <th width="300">
                                        Email
                                    </th>
                                    <th width="400">
                                        School
                                    </th>
                                    <th width="400">
                                        Status
                                    </th>
                                    {{-- <th width="100" align="center">
                                        Action
                                    </th> --}}
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($admins as $index => $admin)
                                    <tr>
                                        <td>{{ $admins->firstItem() + $index }}</td>
                                        <td>
                                            {{ $admin->name }}
                                        </td>
                                        <td>
                                            {{ $admin->email }}
                                        </td>
                                        @php
                                            $inst =  App\Models\Instute::find($admin->institute);
                                        @endphp

                                        <td>
                                            {{ @$inst->name }}
                                        </td>
                                        <td>
                                            @if($admin->is_verified == null)
                                            <button type="button" class="table-btn yellow verify-button" data-id="{{ $admin->id }}">Verify</button>

                                            @elseif($admin->is_verified == 1)
                                            <button type="button" class="table-btn green no-hov no-pointer">Verified</button>

                                            @else
                                            <button type="button" class="table-btn red no-hov no-pointer">Not Verified</button>
                                            @endif
                                        </td>
                                        {{-- <td align="center">
                                        <a href="{{ route('institute_login.edit',  $admin->id ) }}">
                                            <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="">
                                        </a>
                                            <button wire:click="delete({{ $admin->id }})">
                                                <img src="{{ asset('/assets/images/icon-delete.png') }}" alt="">
                                            </button>
                                        </td> --}}
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
    </script>



