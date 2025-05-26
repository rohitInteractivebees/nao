<div class="common-sec1">
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white">
                <div class="">
                    <div class="min-w-full mb-4 overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>
                                        Sr.No
                                    </th>
                                    <th>
                                       Name
                                    </th>
                                    <th>
                                       Group
                                    </th>
                                    <th>
                                       Total Students
                                    </th>
                                    <th>
                                       Quiz Attempts
                                    </th>
                                    <th>
                                       Pending Attempts
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($classes as $index => $classes_name)
                                    <tr>
                                        <td>{{ $classes_name->id }}</td>
                                        <td>
                                            {{ $classes_name->name }}
                                        </td>
                                        <td>
                                            {{ $classes_name->group }}
                                        </td>
                                        <td>
                                            {{ $classes_name->user_count }}
                                        </td>
                                        <td>
                                            {{ $classes_name->quiz_attempts }}
                                        </td>
                                        <td>
                                            {{ $classes_name->user_count - $classes_name->quiz_attempts }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2"
                                            class="px-6 py-4 leading-5 text-center text-gray-900 whitespace-no-wrap">
                                            No Class were found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- {{ $admins->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>



