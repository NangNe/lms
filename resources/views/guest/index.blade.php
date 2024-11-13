@extends('layouts.index')

@section('content')
    <div class="container">
        <h1>Danh sách Chuyên Ngành và Khóa Học</h1>
        @foreach ($majors as $code => $majorGroup)
            <h2 class="text-lg font-semibold mt-4">Khoa {{ $code }}</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên chuyên ngành</th>
                        <th>Ngày Tải Lên</th>
                        <th>Mô Tả</th>
                        <th>Số Quyết Định</th>
                        <th>Total Credit</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($majorGroup->isEmpty())
                        <tr>
                            <td colspan="6">Không có chuyên ngành nào cho mã khoa này.</td>
                        </tr>
                    @else
                        @foreach ($majorGroup as $major)
                            <tr>
                                <td><a href="{{ route('guest.courses', $major->id) }}">
                                        {{ $major->name }} <i class="fas fa-arrow-right"></i>
                                    </a></td>
                                <td>{{ $major->created_at }}</td>
                                <td>{{ $major->description }}</td>
                                <td>{{ $major->decision_number }}</td>
                                <td>{{ $major->total_credits }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endforeach

    </div>
@endsection
