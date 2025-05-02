<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NAO</title>
    <meta name="description" content="NAO" />
    <meta name="keywords" content="NAO" />
    <!-- Favicon -->
    <!--<link rel="icon" href="{{ asset('/assets/img/Innovate-A-Thon_fav-icon.png') }}" type="image/x-icon">-->


    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/responsive.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!--<link href="{{ asset('vendor/livewire/livewire.css') }}" rel="stylesheet">-->
    @livewireStyles

</head>

<body class="font-sans antialiased disableselect">
    <div class="">
        @include('layouts.navigation')

        <!-- Page Heading -->
        {{-- @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
    </div>
    </header>
    @endif --}}

    <!-- Page Content -->
    <main>
        <style>
            #livewire-error {
  display: none !important;
}
        </style>
        {{ $slot }}
    </main>
    </div>
    @include('layouts.footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="{{asset('/assets/js/custom.js') }}"></script>
    <!--<script src="{{ asset('vendor/livewire/livewire.js') }}"></script>-->
    @livewireScripts

    @stack('scripts')
   <!-- <script src="https://www.google.com/recaptcha/api.js?render=6LetGvEqAAAAAA6TdmWXB6Qo_JCj2ukkToO_Xtr1"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LetGvEqAAAAAEiespSeMooiDVv0j2qf5yYUL5aD', {
                action: 'homepage'
            }).then(function(token) {
                document.getElementById('recaptcha_token').value = token;
            });
        });
    </script>

    <!-- Google tag (gtag.js) -->
   <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-4DXHDFJWGW"></script> -->
   <!-- <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-4DXHDFJWGW');
    </script> -->

</body>

</html>