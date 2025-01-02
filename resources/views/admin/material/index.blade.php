<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Material') }}
        </h2>
    </x-slot>
    </style>
    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ 'dashboard' }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Danh sách Material</h1>
                    <a href="{{ route('material.create') }}" class="btn btn-primary">Tạo Material</a>
                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Khóa học</th>
                                <th>Tài liệu chính</th>
                                <th>Isbn</th>
                                <th>Bản cứng</th>
                                <th>Tài liệu trực tuyến</th>
                                <th>Ghi chú</th>
                                <th>Tác giả</th>
                                <th>Nhà Xuất bản</th>
                                <th>Ngày xuất bản</th>
                                <th>Phiên bản</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td>{{ $material->description_material }}</td>
                                    <td>{{ $material->course->name ?? 'Tên khóa học không tồn tại' }}</td>
                                    <td>
                                        <input type="checkbox" disabled
                                            {{ $material->is_main_material ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $material->isbn }}</td>
                                    <td>
                                        <input type="checkbox" disabled {{ $material->is_hard_copy ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" disabled {{ $material->is_online ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $material->note }}</td>
                                    <td>{{ $material->author }}</td>
                                    <td>{{ $material->publisher }}</td>
                                    <td>{{ $material->published_date }}</td>
                                    <td>{{ $material->edition }}</td>
                                    <td>
                                        <a href="{{ route('material.edit', $material->id) }}"
                                            class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('material.destroy', $material->id) }}" method="POST"
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
