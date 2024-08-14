<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Danh sách Lessons') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('lessons.create') }}" class="btn btn-primary">Tạo lessons Mới</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Danh sách Lessons</h1>
                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Khóa học</th>
                                <th>Nội dung</th>
                                <th>Số buổi</th>
                                <th>Mục tiêu</th>
                                <th>CLO</th>
                                <th>Phương pháp giảng dạy</th>
                                <th>Hoạt động sinh viên</th>
                                <th>Documents</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lessons as $lesson)
                                <tr>
                                    <td>{{ $lesson->course->name }}</td>
                                    <td>{{ $lesson->topic }}</td>
                                    <td>{{ $lesson->number_of_periods }}</td>
                                    <td>{{ $lesson->objectives }}</td>
                                    <td>
                                        @if ($lesson->coursesLo->isNotEmpty())
                                            @foreach ($lesson->coursesLo as $courseLo)
                                                <p>{{ $courseLo->name }}</p> <!-- Hiển thị tên của CLO -->
                                            @endforeach
                                        @else
                                            Không có CLO
                                        @endif
                                    </td>
                                    <td>{{ $lesson->lecture_method }}</td>
                                    <td>{{ $lesson->active }}</td>
                                    <td>
                                        @if($lesson->s_download)
                                            <a href="{{ route('download', ['filename' => $lesson->s_download]) }}">{{$lesson->s_download}}</a>
                                        @else
                                            Không có tệp
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('lessons.edit', $lesson) }}" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" style="display:inline;">
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
