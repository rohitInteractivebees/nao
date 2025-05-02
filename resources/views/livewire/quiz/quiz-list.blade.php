<div class="common-sec">
    <div class="container">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="">
                    <div class="mb-4">
                        <!-- <a href="{{ route('quiz.create') }}"
                            class="common-btn short">
                            Create Quiz
                        </a> -->
                    </div>

                    <div class="mb-4 min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
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
                                        Slug
                                    </th>
                                    <th width="250">
                                        Description
                                    </th>
                                    <th width="150">
                                        Questions Count
                                    </th>
                                    <th width="120">
                                        Publish Quiz
                                    </th>
                                    
                                    <!-- <th width="100">
                                        Public
                                    </th> -->
                                    <th width="150"> 
                                        Publish Result
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
                                            {{ $quiz->slug }}
                                        </td>
                                        <td>
                                            {{ $quiz->description }}
                                        </td>
                                        <td>
                                            {{ $quiz->questions_count }}
                                        </td>
                                        <td>
                                            <input class="disabled:opacity-50 disabled:cursor-not-allowed"
                                                type="checkbox" disabled @checked($quiz->published)>
                                        </td>
                                        <!-- <td>
                                            <input class="disabled:opacity-50 disabled:cursor-not-allowed"
                                                type="checkbox" disabled @checked($quiz->public)>
                                        </td> -->
                                        <td>
                                            <input class="disabled:opacity-50 disabled:cursor-not-allowed"
                                                type="checkbox" disabled @checked($quiz->result_show)>
                                        </td>
                                        <td align="center">
                                            <a href="{{ route('quiz.edit', $quiz) }}">
                                                <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="">
                                            </a>
                                            <!-- <button wire:click="delete({{ $quiz->id }})">
                                                <img src="{{ asset('/assets/images/icon-delete.png') }}" alt="">
                                            </button> -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
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
