<section class="common-sec login-page">
    <div class="container">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="">
                    <div class="mb-4">
                        <a href="{{ route('question.create') }}"
                            class="common-btn short">
                            Create Question
                        </a>
                    </div>

                    <div class="min-w-full mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th width="100">
                                        ID
                                    </th>
                                    <th width="400">
                                    Questions
                                    </th>
                                    <th width="400">
                                        Classes
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
                                            {{ \App\Models\Classess::whereIn('id', json_decode($question->class_ids))->pluck('name')->join(', ') }}
                                        </td>
                                        <td align="center">
                                            <a href="{{ route('question.edit', $question->id) }}">
                                                <img src="{{ asset('/assets/images/icon-edit.png') }}" alt="">
                                            </a>
                                            <button wire:click="delete({{ $question }})">
                                                <img src="{{ asset('/assets/images/icon-delete.png') }}" alt="">
                                            </button>
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
</section>
<style>
    span.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.dark\:bg-gray-800.dark\:border-gray-600 {
    background: #ccc;
}
</style>
