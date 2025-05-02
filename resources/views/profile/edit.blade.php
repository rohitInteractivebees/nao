<x-app-layout>
    <section class="common-sec login-page profile-edit">
        <div class="container d-flex justify-end">
            <ul class="links">
                <li>
                    <a href="#info">Profile Information</a>
                </li>
                <li>
                    <a href="#update">Update Password</a>
                </li>
            </ul>
            <div class="right overview">
                <div class="inner" id="info">
                    <div class="text-sec text-center">
                        <div class="heading">Profile Information</div>
                        <p>Update your account's profile information</p>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="inner" id="update">
                    <div class="text-sec text-center">
                        <div class="heading">Update Information</div>
                        <p>Update your account's profile information</p>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </section>

</x-app-layout>