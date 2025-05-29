<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Quiz: {{ $quiz->title }}
        </h2>
    </x-slot>

    <x-slot name="title">
        {{ $quiz->title }}
    </x-slot>

    <section class="common-sec">
    <div class="container">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white">
                <div class="p-6 text-gray-900">
                    @if (!$quiz->public && !auth()->check())
                        <div class="relative px-6 py-4 mb-4 text-white bg-red-700 border-0 rounded">
                            <span class="inline-block mr-8 align-middle">
                                This test is available only for registered users. Please <a href="{{ route('login') }}"
                                    class="hover:underline">Log in</a> or <a href="{{ route('register') }}"
                                    class="hover:underline">Register</a>
                            </span>
                        </div>
                    @else
                     @php

                     $test = App\Models\Test::where('user_id',auth()->user()->id)->first();
                     @endphp

                       @if($test)
                       <div class="relative px-6 py-4 mb-4 text-white bg-red-700 border-0 rounded">
                            <span class="inline-block mr-8 align-middle">
                            You have already participated in the quiz, please wait for the result.
                            </span>
                        </div>

                        @else
                        @livewire('front.quizzes.show', ['quiz' => $quiz])
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    </section>
</x-app-layout>
