<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Majors') }}
        </h2>
    </x-slot>
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ 'dashboard' }}">Back</a>
            <h1>Chi tiết chương trình giảng dạy</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="margin-bottom: 20px">
                <div class="p-6 text-gray-900">

                    <div class="mb-3">
                        <table class="table table-bordered">
                            <tr>
                                <th>Tên Chuyên Ngành</th>
                                <td>{{ $majors->name }}</td>
                            </tr>
                            <tr>
                                <th>Ngày Tải Lên</th>
                                <td>{{ $majors->updated_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Mô Tả</th>
                                <td>{{ $majors->description }}</td>
                            </tr>
                            <tr>
                                <th>Số Quyết Định</th>
                                <td>{{ $majors->decision_number }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="margin-bottom: 20px">
                <h3> {{ $ploCount }} PLO(s)</h3>
                <div class="p-6 text-gray-900">
                    <h3>Danh sách PLO:</h3>
                    <table class="table table-bordered">
                        <tr>
                            <th>Tên PLO</th>
                            <th>Chi Tiết</th>
                        </tr>
                        @foreach ($major->plos as $plo)
                            <tr>
                                <td>{{ $plo->name }}</td>
                                <td>{{ $plo->description }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3> {{$courseCount}} subject , {{$creditCount}} credits </h3>
                <div class="p-6 text-gray-900">
                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Mã Khóa Học</th>
                                <th>Tên Khóa Học</th>
                                <th>Học Kỳ</th>
                                <th>Tín chỉ </th>
                                <th>Điều kiện tiên quyết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($majors->courses as $course)
                                <tr>
                                    <td>{{ $course->code }}</td>
                                    <td><a href="{{ route('courses.detail', $course->id) }}">
                                            {{ $course->name }}
                                        </a></td>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
