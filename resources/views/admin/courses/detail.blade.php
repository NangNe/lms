<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chi tiếc khóa học {{ $courses->name }}
        </h2>
    </x-slot>
    </style>
    <style>
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #292121;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #5b6771;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: left;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ url()->previous() }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-1200">
                    <div class="container">
                        @if ($courses->syllabus)
                       <a href="{{ Storage::url('uploads/' . $courses->syllabus) }}" target="_blank">Tải xuống đề cương</a>
                        @endif

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $courses->id }}</td>
                                <tr>
                                    <th>Tên khóa học</th>
                                    <td>{{ $courses->name }}</td>
                                </tr>
                                <tr>
                                    <th>Mã khóa học</th>
                                    <td>{{ $courses->code }}</td>
                                </tr>
                                <tr>
                                    <th>Tín chỉ</th>
                                    <td>{{ $courses->credits }}</td>
                                </tr>
                                <tr>
                                    <th>Degree Level</th>
                                    <td>{{ $courses->credits }}</td>
                                </tr>
                                <tr>
                                    <th>Time Allocation:</th>
                                    <td>{{ $courses->time_allocation }}</td>
                                </tr>
                                <tr>
                                    <th>Bắt buộc</th>
                                    <td>{{ $courses->is_mandatory ? 'Có' : 'Không' }}</td>
                                </tr>
                                <tr>
                                    <th>Điều kiện tiên quyết</th>
                                    <td>@php
                                        $prerequisiteName = '';

                                        if (!empty($courses->prerequisites)) {
                                            $prerequisiteId = $courses->prerequisites;
                                            $prerequisiteCourse = \App\Models\Course::find($prerequisiteId);
                                            if ($prerequisiteCourse) {
                                                $prerequisiteName = $prerequisiteCourse->name;
                                            }
                                        }
                                    @endphp
                                        {{ $prerequisiteName }}</td>
                                </tr>
                                <tr>
                                    <th>Mô tả</th>
                                    <td>{{ $courses->description }}</td>
                                </tr>
                                <tr>
                                    <th>Nhiệm Kỳ</th>
                                    <td>{{ $courses->semester }}</td>
                                </tr>
                                <tr>
                                    <th>Số quyết định</th>
                                    <td>{{ $courses->decision_no }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày ban hành</th>
                                    <td>{{ $courses->approved_date }}</td>
                                </tr>
                                <tr>
                                    <th>Note</th>
                                    <td>{{ $courses->note }}</td>
                                </tr>
                                <tr>
                                    <th>IsApproved</th>
                                    <td>{{ $courses->is_approved ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr>
                                    <th>IsActive</th>
                                    <td>{{ $courses->is_active ? 'Yes' : 'No' }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <h2 style="margin-top: 20px;margin-bottom: 10px">Material details</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-1200">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mô tả</th>
                                <th>Tài liệu chính</th>
                                <th>Isbn</th>
                                <th>Bản cứng</th>
                                <th>Tài liệu trực tuyến</th>
                                <th>Ghi chú</th>
                                <th>Tác giả</th>
                                <th>Nhà Xuất bản</th>
                                <th>Ngày xuất bản</th>
                                <th>Phiên bản</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td>{{ $material->description_material }}</td>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <h2 style="margin-top: 20px;margin-bottom: 10px">CoursesLo Details</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-1200">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Detail</th>
                                <th>Knowledge</th>
                                <th>Skills</th>
                                <th>Autonomy/Responsibility</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($coursesLo as $lo)
                                <tr>
                                    <td>{{ $lo->name }}</td>
                                    <td>{{ $lo->detail }}</td>
                                    <td>{{ $lo->knowledge }}</td>
                                    <td>{{ $lo->skills }}</td>
                                    <td>{{ $lo->autonomy_responsibility }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No CoursesLo found for this course.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <h2>Danh sách Lessons</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-1200">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nội dung</th>
                                <th>Số buổi</th>
                                <th>Mục tiêu</th>
                                <th>CLO</th>
                                <th>Phương pháp giảng dạy</th>
                                <th>Hoạt động sinh viên</th>
                                <th>Documents</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lessons as $lesson)
                                <tr>
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
                                        @if ($lesson->s_download)
                                            <a
                                                href="{{ route('download', ['filename' => $lesson->s_download]) }}">{{ $lesson->s_download }}</a>
                                        @else
                                            Không có tệp
                                        @endif
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <h2>Danh sách Assignments</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-1200">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tên thành phần đánh giá</th>
                                <th>Trọng số</th>
                                <th>CLO</th>
                                <th>Hình Thức</th>
                                <th>Công cụ</th>
                                <th>Trọng số CLO</th>
                                <th>PLO liên quan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->component_name }}</td>
                                    <td>{{ $assignment->weight }}</td>
                                    <td>
                                        @if ($assignment->coursesLo->isNotEmpty())
                                            @foreach ($assignment->coursesLo as $courseLo)
                                                <p>{{ $courseLo->name }}</p> <!-- Hiển thị tên của CLO -->
                                            @endforeach
                                        @else
                                            Không có CLO
                                        @endif
                                    </td>
                                    <td>{{ $assignment->assessment_type }}</td>
                                    <td>{{ $assignment->assessment_tool }}</td>
                                    <td>{{ $assignment->clo_weight }}</td>
                                    <td>{{ $assignment->plos }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
