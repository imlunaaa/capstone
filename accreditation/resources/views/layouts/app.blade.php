<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Accreditation</title>

        <!-- Css -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap JS -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

        <!-- Bootstrap CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Fontawesome JS -->
        <script src="{{ asset('js/all.min.js') }}"></script>

        <!-- Fontawesome Css -->
        <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
        
        <!-- Toastr JS -->
        <script src="{{ asset('js/toastr.min.js') }}"></script>

         <!-- Toastr CSS -->
        <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

        <!-- Jquery -->
        <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>

        <!-- Datatable JS -->
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

        <!-- Datatable CSS -->
        <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
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
    </body>
</html>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content');
        }
    })
</script>
