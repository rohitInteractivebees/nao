<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>National Automobile Olympiad 2025</title>
    <meta name="description" content="National Automobile Olympiad 2025" />

<!-- Favicon -->
<link rel="icon" href="{{ asset('/images/logo.jpg') }}" type="image/x-icon">

<!--<script src="https://www.google.com/recaptcha/api.js?render=6LeMUTYrAAAAACw1nonakJL0zCidc_Be612pKEjT"></script>-->
<!--<script>-->
<!--    grecaptcha.ready(function() {-->
<!--        grecaptcha.execute('6LeMUTYrAAAAACw1nonakJL0zCidc_Be612pKEjT', {action: 'homepage'}).then(function(token) {-->
<!--            var input = document.getElementById('recaptcha_token');-->
<!--            if (input) {-->
<!--                input.value = token;-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->
<!--
    @if (isset($title))
        <title>{{ $title }}</title>
    @else
        <title>Quiz System</title>
    @endif -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" media="all"/>
    <!--<link rel="stylesheet" href="{{ asset('/assets/css/main.css') }}"/>-->
    <link rel="stylesheet" href="{{ asset('/assets/css/style_new.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/assets/css/responsive-new.css') }}"/>
    <!--<link rel="stylesheet" href="{{ asset('/assets/css/responsive.css') }}"/>-->
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>