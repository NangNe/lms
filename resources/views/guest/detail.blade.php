@extends('layouts.index')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Chi tiết khóa học {{ $courses->name }}
    </h2>
    {{-- <style>
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #292121;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
        }

        .table th,
        .table td {
            padding: 12px;
            vertical-align: top;
            border-top: 1px solid #5b6771;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: left;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        a {
            color: #4a76a8;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f6f9;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #4a76a8;
        }

        .btn-back {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #4a76a8;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-back:hover {
            background-color: #3a5a8c;
        }
    </style> --}}

    <div class="container">
        <a href="{{ url()->previous() }}" class="btn-back">Quay lại</a>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-1200">
                        <div class="container">
                            @if ($courses->syllabus)
                                <a href="{{ Storage::url('uploads/' . $courses->syllabus) }}" target="_blank">Tải xuống
                                    đề cương</a>
                            @endif
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $courses->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tên khóa học</th>
                                        <td>{{ $courses->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mã khóa học</th>
                                        <td>{{ $courses->code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tín chỉ</th>
                                        <td>{{ $courses->credits }}</td>
                                    </tr>
                                    <tr>
                                        <th>Degree Level</th>
                                        <td>{{ $courses->credits }}</td>
                                    </tr>
                                    <tr>
                                        <th>Time Allocation</th>
                                        <td>{{ $courses->time_allocation }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bắt buộc</th>
                                        <td>{{ $courses->is_mandatory ? 'Có' : 'Không' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Điều kiện tiên quyết</th>
                                        <td>@php
                                            $prerequisiteName = '';

                                            if (!empty($courses->prerequisites)) {
                                                $prerequisiteId = $courses->prerequisites;
                                                $prerequisiteCourse = \App\Models\Course::find($prerequisiteId);
                                                if ($prerequisiteCourse) {
                                                    $prerequisiteName = $prerequisiteCourse->name;
                                                }
                                            }
                                        @endphp
                                            {{ $prerequisiteName }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mô tả</th>
                                        <td>{{ $courses->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nhiệm Kỳ</th>
                                        <td>{{ $courses->semester }}</td>
                                    </tr>
                                    <tr>
                                        <th>Số quyết định</th>
                                        <td>{{ $courses->decision_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày ban hành</th>
                                        <td>{{ $courses->approved_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th>
                                        <td>{{ $courses->note }}</td>
                                    </tr>
                                    <tr>
                                        <th>IsApproved</th>
                                        <td>{{ $courses->is_approved ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>IsActive</th>
                                        <td>{{ $courses->is_active ? 'Yes' : 'No' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <h2>Danh sách Assignments</h2>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-1200">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tên thành phần đánh giá</th>
                                    <th>Trọng số</th>
                                    <th>CLO</th>
                                    <th>Hình Thức</th>
                                    <th>Công cụ</th>
                                    <th>Trọng số CLO</th>
                                    <th>PLO liên quan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $assignment)
                                    <tr>
                                        <td>{{ $assignment->component_name }}</td>
                                        <td>{{ $assignment->weight }}</td>
                                        <td>
                                            @if ($assignment->coursesLo->isNotEmpty())
                                                @foreach ($assignment->coursesLo as $courseLo)
                                                    <p>{{ $courseLo->name }}</p>
                                                @endforeach
                                            @else
                                                Không có CLO
                                            @endif
                                        </td>
                                        <td>{{ $assignment->assessment_type }}</td>
                                        <td>{{ $assignment->assessment_tool }}</td>
                                        <td>{{ $assignment->clo_weight }}</td>
                                        <td>{{ $assignment->plos }}</td>
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
