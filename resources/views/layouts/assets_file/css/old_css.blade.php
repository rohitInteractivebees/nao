<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>National Automobile Olympiad 2025</title>
    <meta name="description" content="NAO" />
    <meta name="keywords" content="NAO" />
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/images/logo.jpg') }}" type="image/x-icon">


    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/style_new.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/assets/css/responsive-new.css') }}"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!--<link href="{{ asset('vendor/livewire/livewire.css') }}" rel="stylesheet">-->
    @livewireStyles

</head>