<x-app-layout>
    <Section class="banner-sec inner-banner">
        <div class="item w-100">
            <img class="w-100" src="{{ asset('/assets/images/inner-banner.jpg') }}" alt="">
            <div class="container">
                <div class="text">
                    <div class="heading">Rewards</div>
                    <div class="short">Earn Recognition and Prizes</div>
                </div>
            </div>
        </div>
    </Section>
    <section class="common-sec guidelines-sec rewards-page">
        <div class="container">
            <div class="items d-flex justify-between">
                <div class="item">
                    <div class="price-title"><span>1</span><sup>st</sup> Prize</div>
                    <div class="prize-detail">
                        <div class="image">
                            <img src="{{ asset('/assets/images/prize-image.jpg') }}" alt="">
                        </div>
                        <div class="text">
                            One Week Trip to China ₹ 50 thousand Cash Prize & A Trophy with Certificate!
                        </div>
                    </div>
                    <div class="description">
                        <p>
                            Winning team will be given an opportunity to visit China and tour the NAO headquarters for one week along with a trophy Certificate from NAO and a cash prize of ₹ 50,000 Each!
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="price-title"><span>2</span><sup>nd</sup> Prize</div>
                    <div class="prize-detail">
                        <div class="image">
                            <img src="{{ asset('/assets/images/prize-image2.jpg') }}" alt="">
                        </div>
                        <div class="text">
                            Cash prize of ₹ 30 thousand! & A Trophy with Certificate!
                        </div>
                    </div>
                    <div class="description">
                        <p>
                            Team will receive a Trophy, a Certificate to commemorate your achievement, and a fantastic cash prize of ₹ 30,000 Each!
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="price-title"><span>3</span><sup>rd</sup> Prize</div>
                    <div class="prize-detail">
                        <div class="image">
                            <img src="{{ asset('/assets/images/prize-image3.jpg') }}" alt="">
                        </div>
                        <div class="text">
                            Cash prize of ₹ 25 thousand! & A Trophy with Certificate!
                        </div>
                    </div>
                    <div class="description">
                        <p>
                            Team will receive a Trophy, a Certificate of excellence, and a rewarding cash prize of ₹ 25,000 Each!
                        </p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-center links">
                <a class="common-btn red" href="{{ route('login') }}">Participate Now</a>
            </div>
        </div>
    </section>
</x-app-layout>