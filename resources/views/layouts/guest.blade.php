<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $routeName = Route::currentRouteName();
    $routeArr =  ['home','login','register','school_register','thankyou','password.request','password.reset','gallery','testimonial','notice','privacy_policy','press_release'];
@endphp
@if(in_array($routeName, $routeArr))
    @auth
        @include('layouts.assets_file.css.old_css')
        
    @else
        @include('layouts.assets_file.css.new_css')
    @endauth
@else
    @include('layouts.assets_file.css.old_css')
@endif
    
    <body>
            @include('layouts.navigation')

            <!-- Page Heading -->
                        {{ $slot }}
                   
        @include('layouts.footer')
    </body>
     @if(in_array($routeName, $routeArr))
        @auth
            @include('layouts.assets_file.js.old_js')
            
        @else
            @include('layouts.assets_file.js.new_js')
        @endauth
    @else
        @include('layouts.assets_file.js.old_js')
    @endif
</html>
