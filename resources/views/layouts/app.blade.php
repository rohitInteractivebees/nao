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

<body class="font-sans antialiased disableselect">
    <div class="">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @include('layouts.footer')
    @if(in_array($routeName, $routeArr))
        @auth
            @include('layouts.assets_file.js.old_js')
            
        @else
            @include('layouts.assets_file.js.new_js')
        @endauth
    @else
        @include('layouts.assets_file.js.old_js')
    @endif
    @livewireScripts
    @stack('scripts')
</body>

</html>
