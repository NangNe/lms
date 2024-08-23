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
                    <h1>Danh sách chuyên ngành</h1>
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
                                    <td><a href="{{ route('user.courses', $major->id) }}">
                                            {{ $major->name }}
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
                <script>
                    $(document).ready(function() {
                        $('#coursesTable1').DataTable();
                    });
                </script>
                </body>

            </div>
        </div>
    </div>
@endsection
