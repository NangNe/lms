<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Courses LO') }}
        </h2>
    </x-slot>
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ 'dashboard' }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Danh sách Learning outcomes</h1>
                    <a href="{{ route('courses_lo.create') }}" class="btn btn-primary">Tạo Learning outcomes</a>
                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Tên LO</th>
                                <th>Khóa học</th>
                                <th>Chi tiết</th>
                                <th>Kiến thức</th>
                                <th>Kĩ năng</th>
                                <th>Trách nhiệm</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coursesLo as $lo)
                                <tr>
                                    <td>{{ $lo->name }}</td>
                                    <td>{{ $lo->course->name ?? 'Tên khóa học không tồn tại' }}</td>
                                    <td>{{ $lo->detail }}</td>
                                    <td>{{ $lo->knowledge }}</td>
                                    <td>{{ $lo->skill }}</td>
                                    <td>{{ $lo->autonomy_responsibility }}</td>
                                    <td>
                                        <a href="{{ route('courses_lo.edit', $lo->id) }}"
                                            class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('courses_lo.destroy', $lo->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                       
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
