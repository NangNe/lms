<!DOCTYPE html>
<html lang="en">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Chuyên Ngành và Khóa Học</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
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
</head>

<body>

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
    <script>
        $(document).ready(function() {
            $('#coursesTable1').DataTable();
        });
    </script>
</body>

</html>
