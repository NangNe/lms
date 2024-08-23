@extends('layouts.index')

@section('content')
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
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>Danh sách hiển thị khóa học theo chuyên ngành {{ $majors->name }}</h1>
                        <table class="table" id="coursesTable">
                            <thead>
                                <tr>
                                    <th>Mã Khóa Học</th>
                                    <th>Tên Khóa Học</th>
                                    <th>Học Kỳ</th>
                                    <th>Tín chỉ </th>
                                    <th>Điều kiện tiên quyết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($majors->courses as $course)
                                    <tr>
                                        <td>{{ $course->code }}</td>
                                        <td><a href="{{ route('guest.detail', $course->id) }}">
                                                {{ $course->name }}
                                            </a></td>
                                        <td>{{ $course->semester }}</td>
                                        <td>{{ $course->credits }}</td>
                                        <td>
                                            @php
                                                // Khởi tạo biến để lưu tên khóa học
                                                $prerequisiteName = '';

                                                // Nếu thuộc tính prerequisites không rỗng
                                                if (!empty($course->prerequisites)) {
                                                    // Lấy ID khóa học từ thuộc tính prerequisites
                                                    $prerequisiteId = $course->prerequisites;

                                                    // Lấy tên khóa học dựa trên ID
                                                    $prerequisiteCourse = \App\Models\Course::find($prerequisiteId);

                                                    // Kiểm tra nếu khóa học tồn tại
                                                    if ($prerequisiteCourse) {
                                                        $prerequisiteName = $prerequisiteCourse->name;
                                                    }
                                                }
                                            @endphp
                                            <!-- Hiển thị tên khóa học -->
                                            {{ $prerequisiteName }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
