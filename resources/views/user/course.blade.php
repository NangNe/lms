@extends('layouts.index')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>
    </style>

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
                                    <td><a href="{{ route('user.detail', $course->id) }}">
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
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 20px;
                        }

                        .container {
                            max-width: 800px;
                            margin: 0 auto;
                        }

                        .major {
                            border: 1px solid #ccc;
                            padding: 10px;
                            margin-bottom: 10px;
                        }

                        .major h2 {
                            margin: 0;
                        }

                        .courses {
                            margin-top: 10px;
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
@endsection
