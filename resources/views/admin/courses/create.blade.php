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
                    <h1>Tạo Khóa Học Mới</h1>
                    <form action="{{ route('courses.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="major_ids" class="form-label">Chọn Mã Chuyên Ngành</label>
                            <select id="major_ids" name="major_ids[]" class="form-control select2" multiple="multiple"
                                required>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}">{{ $major->code }} - {{ $major->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Tên Khóa Học:</label>
                            <input type="text" name="name"
                                class="form-control required>
                        </div>

                        <div class="form-group">
                            <label for="code">Mã Khóa Học:</label>
                            <input type="text" name="code"
                                class="form-control required >
                        </div>
                        
                        <div class="mb-3">
                            <label for="syllabus" class="form-label">Upload Syllabus</label>
                            <input type="file" class="form-control" id="syllabus" name="syllabus">
                        </div>

                        <div class="form-group">
                            <label for="lecturers">Chọn Giảng Viên Phụ Trách:</label>
                            <select name="lecturers[]" id="lecturers" class="form-control select4" multiple="multiple">
                                @foreach ($lecturers as $lecturer)
                                    <option style="width: 120px" value="{{ $lecturer->id }}">{{ $lecturer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="semester">Học Kỳ:</label>
                            <input type="text" name="semester"
                                class="form-control >
                        </div>

                        <div class="form-group ">
                            <label for="credits">Tín Chỉ:</label>
                            <input type="number" name="credits" class="form-control >
                        
                        </div>
                        
                        <div class="form-group">
                            <label for="prerequisites" class="form-label">Điều Kiện Tiên Quyết:</label>
                            <select id="prerequisites" name="prerequisites" class="form-control select3">
                                <option value="">Không có</option>
                                @foreach ($all_courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="english_name">Tên Tiếng Anh:</label>
                            <input type="text" name="english_name"
                                class="form-control >
                        </div>

                        <div class="form-group">
                            <label for="time_allocation">Phân Bổ Thời Gian:</label>
                            <input type="text" name="time_allocation"
                                class="form-control >
                        </div>

                        {{-- <div class="form-group">
                            <label for="main_instructor">Giảng Viên Chính:</label>
                            <input type="text" name="main_instructor"
                                class="form-control >
                        </div>

                        <div class="form-group">
                            <label for="co_instructors">Giảng Viên Phụ Trách:</label>
                            <input type="text" name="co_instructors"
                                class="form-control >
                        </div> --}}
                        <div class="form-group">
                            <label for="department">Khoa:</label>
                            <input type="text" name="department"
                                class="form-control >
                        </div>

                        <div class="form-group">
                            <label for="prior_course">Khóa Học Học trước:</label>
                            <select id="prior_course" name="prior_course" class="form-control select3">
                                <option value="">Không có</option>
                                @foreach ($all_courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="co_requisite">Khóa Học Song Hành:</label>
                            <select id="co_requisite" name="co_requisite" class="form-control select3">
                                <option value="">Không có</option>
                                @foreach ($all_courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">

                            <label for="is_mandatory">Bắt Buộc:</label>
                            <input type="checkbox" name="is_mandatory" class="form-control" value="1"
                                {{ old('is_mandatory') ? 'checked' : '' }}>
                        </div>

                        <div class="form-group">
                            <label for="knowledge_area" class="form-label">Thuộc Kiến Thức</label>
                            <div>
                                <input type="radio" id="general" name="knowledge_area" value="General"
                                    {{ old('knowledge_area', 'General') == 'General' ? 'checked' : '' }}>
                                <label for="general">General</label>
                            </div>
                            <div>
                                <input type="radio" id="core" name="knowledge_area" value="Core"
                                    {{ old('knowledge_area', 'General') == 'Core' ? 'checked' : '' }}>
                                <label for="core">Core</label>
                            </div>
                            <div>
                                <input type="radio" id="specialized" name="knowledge_area" value="Specialized"
                                    {{ old('knowledge_area', 'General') == 'Specialized' ? 'checked' : '' }}>
                                <label for="specialized">Specialized</label>
                            </div>
                            <div>
                                <input type="radio" id="internship" name="knowledge_area" value="Internship"
                                    {{ old('knowledge_area', 'General') == 'Internship' ? 'checked' : '' }}>
                                <label for="internship">Internship</label>
                            </div>
                            <div>
                                <input type="radio" id="thesis" name="knowledge_area" value="Thesis"
                                    {{ old('knowledge_area', 'General') == 'Thesis' ? 'checked' : '' }}>
                                <label for="thesis">Thesis</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="objectives">Mục Tiêu:</label>
                            <textarea name="objectives" class="form-control" rows="1"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="summary">Tóm Tắt:</label>
                            <textarea name="summary" class="form-control" rows="1"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô Tả:</label>
                            <textarea name="description" class="form-control" rows="1"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="student_tasks">Nhiệm Vụ Sinh Viên:</label>
                            <textarea name="student_tasks" class="form-control" rows="1"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="decision_no">Số Quyết Định:</label>
                            <input type="text" name="decision_no"
                                class="form-control >
                        </div>

                        <div class="form-group">
                            <label for="is_approved">Đã Phê Duyệt:</label>
                            <input type="checkbox" name="is_approved" class="form-control" value="1"
                                {{ old('is_approved') ? 'checked' : '' }}>
                        </div>

                        <div class="form-group">
                            <label for="note">Ghi Chú:</label>
                            <textarea name="note" class="form-control" rows="1"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="approved_date">Ngày Phê Duyệt:</label>
                            <input type="date" name="approved_date"
                                class="form-control >
                        </div>

                        <div class="form-group">
                            <label for="is_active">Kích Hoạt:</label>
                            <input type="checkbox" name="is_active" class="form-control" value="1"
                                {{ old('is_active') ? 'checked' : '' }}>
                        </div>


                        <button type="submit">Tạo Khóa Học</button>
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
