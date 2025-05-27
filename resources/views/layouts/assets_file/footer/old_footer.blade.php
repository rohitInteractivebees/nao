<footer class="footer py-0">
        <div class="container d-flex justify-between items-center" style="display: none;">
            <div class="left footer-logo">
                <img src="{{ asset('/assets/images/logo.png') }}" width="110" alt="">
            </div>
            <div class="right footer-nav">
                <div class="top-nav">
                    <ul class="d-flex justify-end">                        
                        <li><a href="./about_competition">About Competition </a></li>
                        <li><a href="./guidelines">Guidelines </a></li>
                        <li><a href="./rewards">Rewards</a></li>
                        <li><a href="./institutes">School</a></li>
                        <li><a href="{{ route('login') }}">Participate Now</a></li>
                        <li><a href="./contact_us">Contact Us</a></li>
                    </ul>
                </div>
                <div class="top-nav bottom-nav">
                    <ul class="d-flex justify-end">
                        <li><a href="./terms_and_conditions">Terms & Conditions</a></li>                        
                        <li><a href="./privacy-policy">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="concetivity-sec d-flex justify-end">
                    <a class="common-btn short d-flex items-center" href="mailto:nao@asdc.org.in">
                        <span class="icon"><img src="{{ asset('/assets/images/icon-mail.png') }}" width="30" height="30" alt=""></span>
                        <span class="text">Email : nao@asdc.org.in</span>
                    </a>
                    <a class="common-btn short d-flex items-center" href="tel:+911142599800">
                        <span class="icon"><img src="{{ asset('/assets/images/icon-call.png') }}" width="26" height="27" alt=""></span>
                        <span class="text">Phone : +91 9876543211</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container d-flex justify-between items-center">
                <div class="left">© 2025. NAO. All Rights Reserved</div>
                <div class="right">Web Design & Development : <a href="https://www.interactivebees.com/" target="_blank">Interactive Bees</a></div>
            </div>
        </div>
    </footer> 