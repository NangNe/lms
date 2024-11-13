@extends('layouts.index')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ url()->previous() }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Mã Khóa Học</th>
                                <th>Tên Khóa Học</th>
                                <th>Học Kỳ</th>
                                <th>Tín Chỉ</th>
                                <th>Ngày phê duyệt</th>
                                <th>Số Quyết định</th>
                                <th>Học phần học trước</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($courses->count())
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->code }}</td>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->semester }}</td>
                                        <td>{{ $course->credits }}</td>
                                        <td>{{ $course->approved_at }}</td>
                                        <td>{{ $course->decision_number }}</td>
                                        <td>
                                            @if ($course->prerequisites)
                                                @php
                                                    $prerequisiteName = '';
                                                    $prerequisiteId = $course->prerequisites;
                                                    $prerequisiteCourse = \App\Models\Course::find($prerequisiteId);
                                                    if ($prerequisiteCourse) {
                                                        $prerequisiteName = $prerequisiteCourse->name;
                                                    }
                                                @endphp
                                                {{ $prerequisiteName }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Không tìm thấy khóa học nào.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
