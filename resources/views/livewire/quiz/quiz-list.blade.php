<div class="common-sec">
    <div class="container">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="">
                    @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                    <div class="mb-4">
                        <a href="{{ route('quiz.create') }}"
                            class="common-btn short">
                            Create Quiz
                        </a>
                    </div>

                    <div class="min-w-full mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">
                                        ID
                                    </th>
                                    <th width="200">
                                        Title
                                    </th>
                                    <th width="100">
                                        Class
                                    </th>
                                    <th width="250">
                                        Description
                                    </th>
                                    <th width="150">
                                        Questions Count
                                    </th>
                                    <th width="150">
                                        Duration
                                    </th>
                                    <th width="120">
                                        Start Date
                                    </th>
                                    <th width="100">
                                        End Date
                                    </th>
                                    <th width="150">
                                        Result Date
                                    </th>
                                    <th width="150">
                                        Status
                                    </th>
                                    <th width="100" align="center">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @forelse($quizzes as $index => $quiz)
                                    <tr>
                                        <td>{{ $quizzes->firstItem() + $index }}</td>
                                        <td>
                                            {{ $quiz->title }}
                                        </td>
                                        <td>
                                            @php
                                                $class = \App\Models\Classess::find($quiz->class_ids);
                                            @endphp
                                             {{ $class?->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $quiz->description }}
                                        </td>
                                        <td>
                                            {{ $quiz->questions_count }}
                                        </td>
                                        <td>
                                            {{ $quiz->duration }} Mins
                                        </td>
                                        <td>
                                            {{ $quiz->start_date }}
                                        </td>
                                        <td>
                                            {{ $quiz->end_date }}
                                        </td>
                                        <td>
                                            {{ $quiz->result_date }}
                                        </td>
                                        <td>
                                            {{ ($quiz->status == 1) ? 'Active':'In-Active'  }}
                                        </td>
                                        {{-- <td>
                                            <input class="disabled:opacity-50 disabled:cursor-not-allowed"
                                                type="checkbox" disabled @checked($quiz->published)>
                                        </td> --}}
                                        <!-- <td>
                                            <input class="disabled:opacity-50 disabled:cursor-not-allowed"
                                                type="checkbox" disabled @checked($quiz->public)>
                                        </td> -->
                                        {{-- <td>
                                            <input class="disabled:opacity-50 disabled:cursor-not-allowed"
                                                type="checkbox" disabled @checked($quiz->result_show)>
                                        </td> --}}
                                        <td align="center">
                                            <a href="{{ route('quiz.edit', $quiz) }}">
                                                <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="">
                                            </a>
                                            <button wire:click="copy({{ $quiz->id }})">
                                                    <img src="{{ asset('/assets/images/icon-copy.png') }}" alt="Copy">
                                            </button>

                                            <!-- <button wire:click="delete({{ $quiz->id }})">
                                                <img src="{{ asset('/assets/images/icon-delete.png') }}" alt="">
                                            </button> -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 leading-5 text-center text-gray-900 whitespace-no-wrap">
                                            No quizzes were found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $quizzes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
