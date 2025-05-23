<x-app-layout>
    <section class="common-sec thankyou-page">
        <div class="container justify-center d-flex">
            <div class="image ">
                <!--<img class="thanks-image" src="{{ asset('/assets/images/thank-you-image.jpg') }}" alt="">-->
                <div class="text-center text">
                    <div class="justify-center text-thanks flex"><img src="{{ asset('/assets/images/thank-you-text.png') }}" alt=""></div>
                    <div class="title">For Registration</div>
                    @if(@$id)
                        @php
                            $user = App\Models\User::find($id);
                        @endphp
                        @if($user->is_college == 1)
                            <div class="description">
                                @php
                                    $institute = $user ? App\Models\Instute::find($user->institute) : null;
                                    $baseUrl = url('/register/'); // Gets the current domain, e.g., http://127.0.0.1:8000
                                @endphp

                                @if ($user && $institute)
                                    <p>User ID : <strong> {{ $user->loginId }}</strong></p>
                                    <p>Password : <strong> @if (session('password')){{ session('password') }}@endif</strong></p>
                                    <p>Your Referral Link :
                                        <strong>
                                            <a href="{{ $baseUrl . '/' . $institute->code }}" target="_blank">
                                                {{ $baseUrl . '/' . $institute->code }}
                                            </a>
                                        </strong>
                                    </p>
                                @else
                                    <p>User or School not found.</p>
                                @endif
                            </div>
                        @else
                            <div class="description">
                                @if ($user)
                                    <p>User ID : <strong> {{ $user->loginId }}</strong></p>
                                    <p>Password : <strong> @if (session('password')){{ session('password') }}@endif</strong></p>
                                @else
                                    <p>User or Institute not found.</p>
                                @endif
                            </div>
                            <div class="description">
                                
                                Click <a href="{{ url('sampleCsv/sample_paper.pdf') }}" download target="_blank">here </a> to download sample paper
                            </div>
                        @endif
                    @endif
                    
                    <div class="links">
                        <div class="common-btn small">We look forward to your participation!</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
