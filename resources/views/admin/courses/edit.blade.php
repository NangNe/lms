<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Courses') }}
        </h2>
    </x-slot>
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('courses') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Sửa Khóa Học</h1>
                    <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="code" class="form-label">Mã Khóa Học</label>
                            <input type="text" class="form-control" id="code" name="code"
                                value="{{ old('code', $course->code) }}" required>
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên Khóa Học</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $course->name) }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="major_id" class="form-label">Mã Chuyên Ngành</label>
                            <select id="major_id" name="major_ids[]" class="form-control select2" multiple="multiple"
                                required>
                                <option value="">Chọn Mã Chuyên Ngành</option>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}"
                                        {{ in_array($major->id, $selectedMajorIds) ? 'selected' : '' }}>
                                        {{ $major->code }} - {{ $major->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="syllabus" class="form-label">Đề cương</label>

                            @if ($course->syllabus)
                                <input type="file" class="form-control" id="syllabus" name="syllabus">
                                <p>Hiện tại: <a href="{{ Storage::url('uploads/' . $course->syllabus) }}"
                                        target="_blank">{{ $course->syllabus }}</a></p>
                            @else
                                <input type="file" class="form-control" id="syllabus" name="syllabus">
                            @endif

                            @error('syllabus')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>





                        <div class="form-group">
                            <label for="lecturers">Chọn Giảng Viên Phụ Trách:</label>
                            <select name="lecturers[]" id="lecturers" class="form-control select4" multiple="multiple">
                                @foreach ($lecturers as $lecturer)
                                    <option style="width: 120px" value="{{ $lecturer->id }}"
                                        {{ in_array($lecturer->id, $selectedLecturers) ? 'selected' : '' }}>
                                        {{ $lecturer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label">Học Kỳ</label>
                            <input type="text" class="form-control" id="semester" name="semester"
                                value="{{ old('semester', $course->semester) }}">
                            @error('semester')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="credits" class="form-label">Tín Chỉ</label>
                            <input type="number" class="form-control" id="credits" name="credits"
                                value="{{ old('credits', $course->credits) }}">
                            @error('credits')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="prerequisites" class="form-label">Điều Kiện Tiên Quyết</label>
                            <select id="prerequisites" name="prerequisites" class="form-control select3">
                                <option value="">Chọn Điều Kiện Tiên Quyết</option>
                                @foreach ($all_courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ $course->id == $currentPrerequisite ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="english_name" class="form-label">Tên Tiếng Anh</label>
                            <input type="text" class="form-control" id="english_name" name="english_name"
                                value="{{ old('english_name', $course->english_name) }}">
                            @error('english_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="time_allocation" class="form-label">Phân bổ thời gian</label>
                            <input type="number" class="form-control" id="time_allocation" name="time_allocation"
                                value="{{ old('time_allocation', $course->time_allocation) }}">
                            @error('time_allocation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="mb-3">
                            <label for="main_instructor" class="form-label">Giảng viên chính</label>
                            <input type="text" class="form-control" id="main_instructor" name="main_instructor"
                                value="{{ old('main_instructor', $course->main_instructor) }}">
                            @error('main_instructor')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="co_instructors" class="form-label">Giảng viên phụ trách</label>
                            <input type="text" class="form-control" id="co_instructors" name="co_instructors"
                                value="{{ old('co_instructors', $course->co_instructors) }}">
                            @error('co_instructors')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="mb-3">
                            <label for="department" class="form-label">Khoa</label>
                            <input type="text" class="form-control" id="department" name="department"
                                value="{{ old('department', $course->department) }}">
                            @error('department')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="prior_course" class="form-label">Khóa học học trước:</label>
                            <select id="prior_course" name="prior_course" class="form-control select3">
                                <option value="">Chọn Khóa học học trước</option>
                                @foreach ($all_courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ $course->id == $currentPriorCourse ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="co_requisite" class="form-label">Khóa học song hành:</label>
                            <select id="co_requisite" name="co_requisite" class="form-control select3">
                                <option value="">Chọn Khóa học song hành</option>
                                @foreach ($all_courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ $course->id == $currentCoRequisite ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="is_mandatory" class="form-label">Bắc buộc</label>
                            <input type="checkbox" name="is_mandatory" class="form-control" value="1"
                                {{ old('is_mandatory', $course->is_mandatory) ? 'checked' : '' }}>

                            @error('is_mandatory')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="knowledge_area" class="form-label">Thuộc khối kiến thức</label>
                            <div>
                                <input type="radio" id="general" name="knowledge_area" value="General"
                                    {{ old('knowledge_area', $course->knowledge_area) == 'General' ? 'checked' : '' }}>
                                <label for="general">General</label>
                            </div>
                            <div>
                                <input type="radio" id="core" name="knowledge_area" value="Core"
                                    {{ old('knowledge_area', $course->knowledge_area) == 'Core' ? 'checked' : '' }}>
                                <label for="core">Core</label>
                            </div>
                            <div>
                                <input type="radio" id="specialized" name="knowledge_area" value="Specialized"
                                    {{ old('knowledge_area', $course->knowledge_area) == 'Specialized' ? 'checked' : '' }}>
                                <label for="specialized">Specialized</label>
                            </div>
                            <div>
                                <input type="radio" id="internship" name="knowledge_area" value="Internship"
                                    {{ old('knowledge_area', $course->knowledge_area) == 'Internship' ? 'checked' : '' }}>
                                <label for="internship">Internship</label>
                            </div>
                            <div>
                                <input type="radio" id="thesis" name="knowledge_area" value="Thesis"
                                    {{ old('knowledge_area', $course->knowledge_area) == 'Thesis' ? 'checked' : '' }}>
                                <label for="thesis">Thesis</label>
                            </div>
                            @error('knowledge_area')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="objectives" class="form-label">Mục Tiêu</label>
                            <textarea class="form-control" id="objectives" name="objectives">{{ old('objectives', $course->objectives) }}</textarea>
                            @error('objectives')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="summary" class="form-label">Tóm Tắt</label>
                            <input type="text" class="form-control" id="summary" name="summary"
                                value="{{ old('summary', $course->summary) }}">
                            @error('summary')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <input type="text" class="form-control" id="description" name="description"
                                value="{{ old('description', $course->description) }}">
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="student_tasks" class="form-label">Nhiệm vụ sinh viên</label>
                            <input type="text" class="form-control" id="student_tasks" name="student_tasks"
                                value="{{ old('student_tasks', $course->student_tasks) }}">
                            @error('student_tasks')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="decision_no" class="form-label">Số Quyết Định</label>
                            <input type="text" class="form-control" id="decision_no" name="decision_no"
                                value="{{ old('decision_no', $course->decision_no) }}">
                            @error('decision_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="is_approved" class="form-label">Đã Phê duyệt</label>
                            <input type="checkbox" class="form-control" id="is_approved" name="is_approved"
                                value="1"{{ old('is_approved', $course->is_approved) ? 'checked' : '' }}>
                            @error('is_approved')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi Chú: </label>
                            <input type="text" class="form-control" id="note" name="note"
                                value="{{ old('note', $course->note) }}">
                            @error('note')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="approved_date" class="form-label">Ngày Phê Duyệt:</label>
                            <input type="date" class="form-control" id="approved_date" name="approved_date"
                                value="{{ old('approved_date', $course->approved_date) }}">
                            @error('approved_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Kích Hoạt</label>
                            <input type="checkbox" class="form-control" id="is_active" name="is_active"
                                value="1" {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                            @error('is_active')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Chọn chuyên ngành",
            allowClear: true
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.select3').select2({
            placeholder: "Chọn môn học",
            allowClear: true
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.select4').select2({
            placeholder: "Chọn giảng viên",
            allowClear: true
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var syllabusInput = document.getElementById('syllabus');

        syllabusInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                // Hiển thị tên tệp đã chọn
                var fileName = this.files[0].name;
                this.nextElementSibling.innerText = 'Tệp đã chọn: ' + fileName;
            }
        });
    });
</script>
