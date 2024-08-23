<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LMS') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/custom.css'])

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @if (Auth::check())
            @include('layouts.user_navigation')
        @else
            @include('layouts.guest_navigation')
        @endif

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                @if (session('success'))
                    <div class="alert alert-success notification" id="success-alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger notification_error" id="error-alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <style>
        .notification {
            position: fixed;
            top: 75px;
            right: 0px;
            padding: 15px;
            background-color: #00ff3c;
            border-radius: 5px;
            z-index: 1000;
            box-shadow: 0 0 10px rgb(0, 0, 0);
            opacity: 1;
            transition: opacity 0.5s ease;
            animation: fadeIn 1s ease-in-out;
        }

        .notification_error {
            position: fixed;
            top: 75px;
            right: 0px;
            padding: 15px;
            background-color: #ff3333;
            border-radius: 5px;
            z-index: 1000;
            box-shadow: 0 0 10px rgb(0, 0, 0);
            opacity: 1;
            transition: opacity 0.5s ease;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <!-- DataTables Initialization -->
    <script>
        $(document).ready(function() {
            $('#coursesTable').DataTable();
        });
    </script>

    <!-- Notification Fade Out -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var successAlert = document.getElementById('success-alert');
                var errorAlert = document.getElementById('error-alert');
                if (successAlert) {
                    successAlert.style.opacity = '0';
                }
                if (errorAlert) {
                    errorAlert.style.opacity = '0';
                }
            }, 1000);
        });
    </script>
</body>

</html>
