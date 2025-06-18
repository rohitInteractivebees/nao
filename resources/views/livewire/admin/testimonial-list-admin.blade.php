<div>
    <div class="common-sec1">
        <div class="container">
            <div class="items-end justify-between md:flex">
                <div class="item">
                    <div class="mb-0 sub-title">Testimonials</div>
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
                                    <th width="300">Name</th>
                                    <th width="300">School Name</th>
                                    <th width="300">Mobile Number</th>
                                    <th width="300">Email</th>
                                    <th width="400">Category</th>
                                    <th width="150">Message</th>
                                    <th width="300">Image</th>
                                    <th width="150">Date</th>
                                    <th width="150">Status</th>
                                    <th align="center" width="100">Action</th>
                                </tr>
                            </thead>
                            @php
                                $serial = ($data->currentPage() - 1) * $data->perPage() + 1;
                            @endphp
                            <tbody>
                                @forelse($data as $row)

                                    <tr>
                                        <td>{{ $serial++ }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->school_name }}</td>
                                        <td>
                                            @if($row->country_code || $row->mobile_number)
                                                +{{ trim($row->country_code.' '.$row->mobile_number) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ !empty($row->email) ? $row->email : 'N/A' }}</td>
                                        <td>{{ $row->category }}</td>
                                        <td>{!! $row->message !!}</td>
                                        <td>
                                             @if(!is_null($row->image) && $row->image)
                                             <a href="{{ asset($row->image) }}" class="fancybox" data-fancybox>
                                                 <img src="{{ asset($row->image) }}" class="w-auto h-auto"/>
                                             </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td> {{ $row->created_at->format('d-m-Y') }}</td>
                                        <td align="center">
                                            @if(!is_null($row->status) && $row->status)
                                                Post
                                            @else
                                                Hide
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if(!is_null($row->status) && $row->status)
                                                <button wire:click="confirmHide({{ $row->id }})" class="btn btn-sm btn-success table-btn red">Hide</button>
                                            @else
                                                <button wire:click="confirmPost({{ $row->id }})" class="btn btn-sm btn-success table-btn green">Post</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 leading-5 text-center text-gray-900 whitespace-no-wrap">
                                            No Record were found.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>

    </div>

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
    window.addEventListener('confirmPost', event => {
        if (confirm('Do you want to post this testimonial?')) {
            Livewire.emit('post', event.detail.id);
        }
    });
    window.addEventListener('confirmHide', event => {
        if (confirm('Do you want to hide this testimonial?')) {
            Livewire.emit('hide', event.detail.id);
        }
    });
</script>
</div>
