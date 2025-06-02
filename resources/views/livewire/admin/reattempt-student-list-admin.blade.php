<div>
    <div class="common-sec1">
        <div class="container">
            <div class="items-end justify-between md:flex">
                <div class="item">
                    <div class="mb-0 sub-title">Re-Attempt Student List</div>
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
                    </div>
                    <div class="mb-4">
                        <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name, email, or phone..." class="form-control">
                    </div>
                </div>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success" id="success-message">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        let msg = document.getElementById('success-message');
                        if (msg) msg.style.display = 'none';
                    }, 3000);
                </script>
            @endif
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white">

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
                                        admin<td>{{ !empty($student->email) ? $student->email : 'N/A' }}</td>

                                        <td>
                                            @if($student->country_code || $student->phone)
                                                +{{ trim($student->country_code.' '.$student->phone) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td> {{ $student->created_at->format('d-m-Y') }}</td>
                                        <td align="center">
                                            <button wire:click="confirmAllow({{ $student->id }})" class="btn btn-sm btn-success">
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
