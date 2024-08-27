@extends('layouts.index')

@section('content')


    <!-- Nội dung dành cho user hoặc guest -->
    <title>Danh sách Chuyên Ngành và Khóa Học</title>

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
