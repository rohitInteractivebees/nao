<section class="result-list-page">
    <div class="container">
        @php

            $totalSeconds = $quiz->duration * 60;
            $entangleKey = 'answersOfQuestions.' . $currentQuestionIndex;
        @endphp

        <div x-data="{
            secondsLeft: {{ $totalSeconds }},
            selectedAnswer: @entangle($entangleKey),
            submitDisabled: false
        }"
        x-init="
            setInterval(() => {
                if (secondsLeft > 0) {
                    secondsLeft--;
                } else {
                    if (!submitDisabled) {
                        submitDisabled = true;
                        $wire.submit();
                    }
                }
            }, 1000);
            window.onbeforeunload = function (e) {
                if (!submitDisabled) {
                    e.preventDefault();
                    e.returnValue = 'If you leave, all data will be lost.';
                }
            };
        "
        >
        <div class="items-end justify-between result-summary d-flex">
            <div class="heading short">Level 1 <span>Question {{ $currentQuestionIndex + 1 }} of {{ $this->questionsCount }}:</div>
            <div class="w-3/4 result-sumary-test">
                <ul class="justify-between d-flex">
                    <li>
                        <span>Date : </span> {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
                    </li>
                    <li>
                    <span>Time: </span>{{ \Carbon\Carbon::now('Asia/Kolkata')->format('h:i A') }}


                    </li>
                    <li>
                        <span>Time Left:</span>
                        <em
                            x-text="
                                String(Math.floor(secondsLeft / 3600)).padStart(2, '0') + ':' +
                                String(Math.floor((secondsLeft % 3600) / 60)).padStart(2, '0') + ':' +
                                String(secondsLeft % 60).padStart(2, '0')
                            "
                            class="font-bold"
                        ></em>
                    </li>

                </ul>
            </div>
        </div>
        <div class="result-question-answer step-first">
            <ul class="justify-center d-flex">
                <li class="justify-between outer d-flex">
                    <div class="count">{{ $currentQuestionIndex + 1 }}</div>
                    <div class="detail">
                        <div class="question">{{ $currentQuestion->text }}</div>
                        @if ($currentQuestion->image_path)
                        <div class="justify-center mt-2 mb-2 image d-flex">
                            <img src="{{url($currentQuestion->image_path)}}">
                        </div>
                        @endif
                        <ul class="answer">
                            @foreach ($currentQuestion->options as $option)
                            <li>
                                <input
                                    type="radio"
                                    id="option.{{ $option->id }}"
                                    wire:model.defer="answersOfQuestions.{{ $currentQuestionIndex }}"
                                    name="answersOfQuestions.{{ $currentQuestionIndex }}"
                                    value="{{ $option->id }}"
                                    x-on:change="selectedAnswer = '{{ $option->id }}'"
                                >
                                <label for="option.{{ $option->id }}">{{ $option->text }}</label>
                            </li>
                            @endforeach
                        </ul>

                    </div>
                </li>
            </ul>
        </div>
    <div class="justify-center mt-6 links d-flex">
        @if ($currentQuestionIndex < $this->questionsCount - 1)
            <div class="mt-4">
                <x-secondary-button
                    class="red"
                    x-on:click="$wire.nextQuestion()"
                    x-bind:disabled="!selectedAnswer"
                >
                    Next question
                </x-secondary-button>
            </div>
        @else
            <div class="mt-4">
                <x-primary-button
                    class="common-btn short red"
                    x-on:click="submitDisabled = true; window.onbeforeunload = null; $wire.submit();"
                    x-bind:disabled="submitDisabled"
                >
                    Submit
                </x-primary-button>
            </div>
        @endif
    </div>
</div>
</section>
