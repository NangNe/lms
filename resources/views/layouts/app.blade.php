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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Thêm vào phần <head> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4; /* Màu nền nhạt cho toàn bộ trang */
            margin: 0;
            padding: 0;s
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #828282;
        }

        th {
            background-color: #f6ff00; /* Màu nền cho tiêu đề */
            color: rgb(0, 0, 0);
            font-size: 16px;
        }

        td {
            font-size: 17px;
            background-color: #fff; /* Màu nền trắng cho các ô */
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9; /* Màu nền cho các hàng chẵn */
        }

        tr:hover td {
            background-color: #f1f1f1; /* Màu nền khi di chuột qua hàng */
        }

        a {
            color: #1d4ed8;
            text-decoration: none; /* Loại bỏ gạch chân dưới link */
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline; /* Thêm gạch chân khi di chuột qua link */
        }

        button {
            background-color: #ff0000; /* Màu nền xanh lá cây cho nút */
            color: white; /* Màu chữ trắng */
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: #45a049; /* Màu nền khi di chuột qua nút */
            transform: scale(1.02);
        }
    </style>

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

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
            {{ $slot }}
        </main>

        <footer style="background-color: #ffffff; padding: 20px 0; font-family: Arial, sans-serif;">
            <div style="text-align: center; color: #000000; margin-bottom: 10px; font-weight: bold;">
                Copyright © 2017-2024 - Trường Đại học Công nghệ Thông tin &amp; Truyền Thông Việt - Hàn, Đại học Đà Nẵng
            </div>
            <div style="color: #4a4949; text-align: center; font-size: 14px; line-height: 1.6;">
                <div><span class="glyphicon glyphicon-home"></span> Địa chỉ: 41 Lê Duẩn, Hải Châu, Thành phố Đà Nẵng | Khu Đô thị
                    Đại học Đà Nẵng, Đường Nam Kỳ Khởi Nghĩa, quận Ngũ Hành Sơn, Đà Nẵng
                </div>
                <div><span class="glyphicon glyphicon-phone-alt"></span> Điện thoại: 0236.6.552.688</div>
                <div><span class="glyphicon glyphicon-envelope"></span> Email: daotao@vku.udn.vn</div>
            </div>
        </footer>
        
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
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <!-- Thêm vào phần <body> trước thẻ đóng </body> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#coursesTable').DataTable();
        });
    </script>
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
