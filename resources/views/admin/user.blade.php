<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 border-b-4 border-yellow-500 pb-2">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <a href="{{ 'dashboard' }}" class="text-blue-600 hover:text-blue-800 mb-6 inline-block text-lg font-medium">Back</a>
        
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 mb-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-gray-200 pb-2">Danh Sách Người Dùng</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 border-gray-200 pb-2">Danh Sách Giảng Viên</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lecturers as $lecturer)
                        <tr>
                            <td>{{ $lecturer->id }}</td>
                            <td>{{ $lecturer->name }}</td>
                            <td>{{ $lecturer->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4; /* Màu nền nhạt cho toàn bộ trang */
            margin: 0;
            padding: 0;
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
            border: 1px solid #ddd;
        }

        th {
            background-color: #f1c615; /* Màu nền cho tiêu đề */
            color: #fff; /* Màu chữ trắng */
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
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: #2563eb; /* Màu nền khi di chuột qua nút */
            transform: scale(1.02);
        }
    </style>
</x-app-layout>
