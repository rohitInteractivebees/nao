<div class="">
<div class="common-sec1">
   
    <div class="container1">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white">
               
           
                    @if(auth()->user()->is_admin == 1)
                    <div class="w-100 gap d-flex sm:justify-between justify-center items-end">
                        <div class="form-style sm:w-1/2">

                            <label class="block font-medium text-sm text-gray-700" for="quiz">Institute</label>
                            <select class="block mt-1 w-full" wire:model="quiz_id1" name="quiz">
                                <option value="0">All Institute</option>
                               
                                @php
                                $college = App\Models\Instute::get()
                                @endphp
                                @foreach ($college as $clg)
                                <option value="{{ $clg->id }}">{{ $clg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                  </div>
                  @endif
                <div class="mt-6 mb-4 min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                    <table class="min-w-full border divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th width="100">ID</th>
                                <th width="300">Name</th>
                                <th width="400">Email</th>
                                <th width="150">Phone</th>
                                <th width="150">Status</th>
                                <th align="center" width="100">ID Card</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $admin)
                            <tr>
                                <td>{{ $admin->id}} </td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->phone }}</td>
                                <td>
                                    @if($admin->is_verified == 1)
                                    <button type="button" class="table-btn green no-hov no-pointer">Verified</button>
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
                                        <div class="d-flex justify-center">
                                            <div class="image">
                                                <img src="{{ url('/'.$admin->idcard) }}" alt="">

                                            </div>
                                            <div class="d-flex justify-center w-100 links mt-6">
                                                <a href="{{ url('/'.$admin->idcard) }}" class="common-btn admin-btn  d-flex items-center" download>
                                                    <span class="reverse-pos"><img src="{{ asset('/assets/images/icon-upload.png') }}" alt=""></span>
                                                    <span>Download ID</span>
                                                </a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </td>


                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
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

</div>
        