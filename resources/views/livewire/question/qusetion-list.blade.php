<div>
    <div class="common-sec1">
        <div class="container">
            <div class="items-center flex-wrap justify-between mt-5 md:flex">
                <div class="mb-0 sub-title">Question Bank</div>
                <a href="{{ route('question.create') }}" class="common-btn short"> Create Question</a>
                <form action="{{ route('question.upload.csv') }}" method="POST" enctype="multipart/form-data" id="csv-upload-form" class="student-upload-form">
                    @csrf
                    <div class="d-flex gap ">
                        <div class="form-style mt-0">
                            <input type="file" name="csv_file" required>
                        </div>
                    </div>
                </form>
                <button class="items-center common-btn admin-btn d-flex" type="submit">
                    <span class="reverse-pos"><img src="{{ asset('/assets/images/icon-download.png') }}" alt=""></span>
                    <span>Upload CSV</span>
                </button>
                <button class="items-center common-btn admin-btn d-flex common-btn-two" type="submit">
                    <span><img src="{{ asset('/assets/images/icon-download.png') }}" alt=""></span>
                    <a href="{{url('sampleCsv/admin_question_sample.csv')}}" download><span>Download Sample CSV</span></a>
                </button>
                <div class="mt-4 md:mt-0">
                        <input type="text" wire:model.debounce.500ms="search" placeholder="Search by questions,group or level..." class="form-control" style="border: 1px solid #ccc !important;">
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
                                    <th width="100">
                                        Sr.No
                                    </th>
                                    <th width="400">
                                    Questions
                                    </th>
                                    <th width="400">
                                        Group
                                    </th>
                                    <th width="400">
                                        Level
                                    </th>
                                    <th width="100" align="center">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @forelse($questions as $index => $question)
                                    <tr>
                                        <td>{{ $questions->firstItem() + $index }}</td>
                                        <td>
                                            {{ $question->text }}
                                        </td>
                                        <td>
                                            {{ 'Group ' . $question->class_ids }}
                                        </td>
                                        <td>
                                            {{ $question->level == 1 ? 'Easy' : ($question->level == 2 ? 'Medium' : ($question->level == 3 ? 'Hard' : '')) }}
                                        </td>
                                        <td align="center">
                                            <a href="{{ route('question.edit', $question->id) }}">
                                                <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="">
                                            </a>
                                            {{-- <button wire:click="delete({{ $question }})">
                                                <img src="{{ asset('/assets/images/icon-delete.png') }}" alt="">
                                            </button> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-4 leading-5 text-center text-gray-900 whitespace-no-wrap">
                                            No questions were found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $questions->links() }}
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


