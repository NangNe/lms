@extends('layouts.index')

@section('content')
    <!-- Nội dung dành cho user hoặc guest -->
    <title>Danh sách Chuyên Ngành và Khóa Học</title>
    {{-- <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f6f9;
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #4a76a8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4a76a8;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: #4a76a8;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .fa-arrow-right {
            margin-left: 5px;
        }

        .table {
            margin-top: 20px;
        }

        /* DataTables styles */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #4a76a8 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #4a76a8 !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 5px;
            width: 250px;
            margin-left: 10px;
        }
    </style> --}}




    <div class="container">
        <h1>Danh sách Chuyên Ngành và Khóa Học</h1>
        <table class="table" id="coursesTable1">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tên</th>
                    <th>Ngày Tải Lên</th>
                    <th>Mô Tả</th>
                    <th>Số Quyết Định</th>
                    <th>Total Credit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($majors as $major)
                    <tr>
                        <td>{{ $major->code }}</td>
                        <td><a href="{{ route('guest.courses', $major->id) }}">
                                {{ $major->name }} <i class="fas fa-arrow-right"></i>
                            </a></td>
                        <td>{{ $major->created_at }}</td>
                        <td>{{ $major->description }}</td>
                        <td>{{ $major->decision_number }}</td>
                        <td>{{ $major->total_credits }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
