<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Assignment') }}
        </h2>
    </x-slot>
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ 'dashboard' }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Danh sách Assignments</h1>
                    <a href="{{ route('assignments.create') }}" class="btn btn-primary">Tạo Assignments Mới</a>
                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Khóa học</th>
                                <th>Tên thành phần đánh giá</th>
                                <th>Trọng số</th>
                                <th>CLO</th>
                                <th>Hình Thức</th>
                                <th>Công cụ</th>
                                <th>Trọng số CLO</th>
                                <th>PLO liên quan</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->course->name }}</td>
                                    <td>{{ $assignment->component_name }}</td>
                                    <td>{{ $assignment->weight }}</td>
                                    <td>
                                        @foreach ($assignment->coursesLo as $courseLo)
                                            {{ $courseLo->name }}
                                        @endforeach
                                    </td>
                                    <td>{{ $assignment->assessment_type }}</td>
                                    <td>{{ $assignment->assessment_tool }}</td>
                                    <td>{{ $assignment->clo_weight }}</td>
                                    <td>{{ $assignment->plos }}</td>
                                    <td>
                                        <a href="{{ route('assignments.edit', $assignment) }}"
                                            class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('assignments.destroy', $assignment) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>

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
