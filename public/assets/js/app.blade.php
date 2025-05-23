<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (isset($title))
        <title>{{ $title }}</title>
    @else
        <title>Quiz System</title>
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
 <link href="https://innovate-a-thon.asdc.org.in/css/style.css" rel="stylesheet" />
<link href="https://innovate-a-thon.asdc.org.in/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://innovate-a-thon.asdc.org.in/css/theme.css" rel="stylesheet" />
<link href="https://innovate-a-thon.asdc.org.in/css/theme-support.css" rel="stylesheet" />




    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="https://innovate-a-thon.asdc.org.in/assets/js/vendor/jquery-3.6.0.min.js"></script>
	<script src="https://innovate-a-thon.asdc.org.in/bootstrap.min.js"></script>
	<script src="https://innovate-a-thon.asdc.org.in/imagesloaded.pkgd.min.js"></script>
	
	<script src="https://innovate-a-thon.asdc.org.in/isotope.pkgd.min.js"></script>
	<script src="https://innovate-a-thon.asdc.org.in/jquery.counterup.min.js"></script>
	<script src="https://innovate-a-thon.asdc.org.in/jquery.magnific-popup.min.js"></script>
	<script src="https://innovate-a-thon.asdc.org.in/jquery.marquee.min.js"></script>
	<script src="https://innovate-a-thon.asdc.org.in/jquery-ui.min.js"></script>
	<script src="https://innovate-a-thon.asdc.org.in/main.js"></script>
	<script src="https://innovate-a-thon.asdc.org.in/slick.min.js"></script>
	
    @livewireScripts
    @stack('scripts')
</body>

</html>
