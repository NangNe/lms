<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Courses') }}
        </h2>
    </x-slot>
    </style>
    {{-- <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- Scripts -->
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ 'dashboard' }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Danh sách Khóa Học</h1>
                    <a href="{{ route('courses.create') }}" class="btn btn-primary">Tạo Khóa Học Mới</a>
                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Mã Khóa Học</th>
                                <th>Tên Khóa Học</th>
                                {{-- <th>Mã Chuyên Ngành</th> --}}
                                <th>Học Kỳ</th>
                                <th>Tín Chỉ</th>
                                <th>Điều Kiện Tiên Quyết</th>
                                <th>Học phần học trước</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{{ $course->code }}</td>
                                    <td>{{ $course->name }}</td>
                                    {{-- <td>{{ $course->major->code }}</td> --}}
                                    <td>{{ $course->semester }}</td>
                                    <td>{{ $course->credits }}</td>
                                    <td>
                                        @php
                                            // Khởi tạo biến để lưu tên khóa học
                                            $prerequisiteName = '';
                        
                                            // Nếu thuộc tính prerequisites không rỗng
                                            if (!empty($course->prerequisites)) {
                                                // Lấy ID khóa học từ thuộc tính prerequisites
                                                $prerequisiteId = $course->prerequisites;
                        
                                                // Lấy tên khóa học dựa trên ID
                                                $prerequisiteCourse = \App\Models\Course::find($prerequisiteId);
                                                
                                                // Kiểm tra nếu khóa học tồn tại
                                                if ($prerequisiteCourse) {
                                                    $prerequisiteName = $prerequisiteCourse->name;
                                                }
                                            }
                                        @endphp
                                        <!-- Hiển thị tên khóa học -->
                                        {{ $prerequisiteName }}
                                    </td>
                                    <td>
                                       @php
                                           $priorCourseName = '';

                                             if (!empty($course->prior_course)) {
                                                  $priorCourseId = $course->prior_course;
    
                                                  $priorCourse = \App\Models\Course::find($priorCourseId);
    
                                                  if ($priorCourse) {
                                                    $priorCourseName = $priorCourse->name;
                                                  }
                                             }
                                       @endphp
                                        {{ $priorCourseName }}
                                    </td>

                                    <td>
                                    
                                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('courses.destroy', $course) }}" method="POST"
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
