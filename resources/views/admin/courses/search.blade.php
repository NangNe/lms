<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tìm kiếm Khóa Học') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ url()->previous() }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- <h1>Tìm kiếm Khóa Học</h1>

                    <!-- Form tìm kiếm -->
                    <form method="GET" action="{{ route('courses.search') }}" class="mb-4">
                        <input type="text" name="query" class="form-input w-1/3" placeholder="Nhập tên hoặc mã khóa học...">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form> --}}

                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Mã Khóa Học</th>
                                <th>Tên Khóa Học</th>
                                <th>Học Kỳ</th>
                                <th>Tín Chỉ</th>
                                <th>Điều Kiện Tiên Quyết</th>
                                <th>Học phần học trước</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($courses->count())
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->code }}</td>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->semester }}</td>
                                        <td>{{ $course->credits }}</td>
                                        <td>
                                            @php
                                                $prerequisiteName = '';
                                                if (!empty($course->prerequisites)) {
                                                    $prerequisiteCourse = \App\Models\Course::find($course->prerequisites);
                                                    $prerequisiteName = $prerequisiteCourse ? $prerequisiteCourse->name : '';
                                                }
                                            @endphp
                                            {{ $prerequisiteName }}
                                        </td>
                                        <td>
                                            @php
                                                $priorCourseName = '';
                                                if (!empty($course->prior_course)) {
                                                    $priorCourse = \App\Models\Course::find($course->prior_course);
                                                    $priorCourseName = $priorCourse ? $priorCourse->name : '';
                                                }
                                            @endphp
                                            {{ $priorCourseName }}
                                        </td>
                                    
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Không tìm thấy khóa học nào.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
