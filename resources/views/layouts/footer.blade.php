@php
    $routeName = Route::currentRouteName();
    $routeArr =  ['home','login','register','school_register','thankyou','password.request','password.reset','gallery','testimonial','notice','privacy_policy','press_release'];
@endphp
@if(in_array($routeName, $routeArr))
    @auth
        @include('layouts.assets_file.footer.old_footer')
        
    @else
        @include('layouts.assets_file.footer.new_footer')
    @endauth
@else
    @include('layouts.assets_file.footer.old_footer')
@endif

