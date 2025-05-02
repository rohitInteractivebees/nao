<x-app-layout>
    <Section class="banner-sec inner-banner">
        <div class="item w-100">
            <img class="w-100" src="{{ asset('/assets/images/inner-banner.jpg') }}" alt="">
            <div class="container">
                <div class="text">
                    <div class="heading">Guidelines</div>
                    <div class="short">Your Blueprint for Success</div>
                </div>
            </div>
        </div>
    </Section>
    <section class="common-sec guidelines-sec">
        <div class="container">
            <div class="items d-flex justify-between">
                <div class="item">
                    <div class="heading short text-center">Round 1</div>
                    <ul class="common-list">
                        <li>
                            Participants must be registered students of the school as specified by the 
                            <span class="uppercase">NAO EV Innovate-a-thon</span> guidelines.
                        </li>
                        <li>
                            The competition is open for all students for participating school i.e.
                        </li>
                        <li>
                            The competition will be hybrid where the first 2 stages will be conducted online and the
                            finals will be conducted physically offline 
                        </li>
                        <li>
                            There is no age restriction for the students in the above classes.
                        </li>
                        <li>
                            There is no age restriction for the students in the above classes.
                        </li>
                        <li>
                            The medium of instruction will be in English 
                        </li>
                    </ul>
                </div>
                <div class="item">
                    <div class="heading short text-center">Round 2 & 3</div>
                    <ul class="common-list">
                        <li>
                            Teams must consist of a maximum of 4 members and all team members must have won in the first
                            round. 
                        </li>
                        <li>
                            Each participant can only be part of one team.
                        </li>
                        <li>
                            Projects must be original and developed specifically for the <span class="uppercase">NAO</span>.
                        </li>
                        <li>
                            Submissions must be made by the specified deadline.
                        </li>
                        <li>
                            All project materials, including prototypes and documentation, must adhere to the given
                            guidelines.
                        </li>
                        <li>
                            Participants retain ownership of their projects.
                        </li>
                        <li>
                            NAO reserves the right to use project details and participant information for promotional
                            purposes.
                        </li>
                    </ul>
                </div>

            </div>
            <div class="d-flex justify-center links">
                <a class="common-btn red" href="{{ route('login') }}">Participate Now</a>
            </div>
        </div>
    </section>
</x-app-layout>