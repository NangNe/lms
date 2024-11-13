<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('courses') }}" class="text-blue-600 hover:underline">Quay lại</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Sửa Khóa Học</h1>
                    <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Mã Khóa Học -->
                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700">Mã Khóa Học</label>
                            <input type="text" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="code" name="code" value="{{ old('code', $course->code) }}" required>
                            @error('code')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tên Khóa Học -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Tên Khóa Học</label>
                            <input type="text" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="name" name="name" value="{{ old('name', $course->name) }}" required>
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mã Chuyên Ngành -->
                        <div class="mb-4">
                            <label for="major_id" class="block text-sm font-medium text-gray-700">Mã Chuyên Ngành</label>
                            <select id="major_id" name="major_ids[]" class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm select2" multiple="multiple" required>
                                <option value="">Chọn Mã Chuyên Ngành</option>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}" {{ in_array($major->id, $selectedMajorIds) ? 'selected' : '' }}>
                                        {{ $major->code }} - {{ $major->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Đề Cương -->
                        <div class="mb-4">
                            <label for="syllabus" class="block text-sm font-medium text-gray-700">Đề Cương</label>
                            <input type="file" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="syllabus" name="syllabus">
                            @if ($course->syllabus)
                                <p class="mt-2 text-gray-600">Hiện tại: <a href="{{ Storage::url('uploads/' . $course->syllabus) }}" target="_blank" class="text-blue-600 hover:underline">{{ $course->syllabus }}</a></p>
                            @endif
                            @error('syllabus')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Giảng Viên Phụ Trách -->
                        <div class="mb-4">
                            <label for="lecturers" class="block text-sm font-medium text-gray-700">Chọn Giảng Viên Phụ Trách</label>
                            <select name="lecturers[]" id="lecturers" class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm select4" multiple="multiple">
                                @foreach ($lecturers as $lecturer)
                                    <option value="{{ $lecturer->id }}" {{ in_array($lecturer->id, $selectedLecturers) ? 'selected' : '' }}>
                                        {{ $lecturer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Học Kỳ -->
                        <div class="mb-4">
                            <label for="semester" class="block text-sm font-medium text-gray-700">Học Kỳ</label>
                            <input type="text" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="semester" name="semester" value="{{ old('semester', $course->semester) }}">
                            @error('semester')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tín Chỉ -->
                        <div class="mb-4">
                            <label for="credits" class="block text-sm font-medium text-gray-700">Tín Chỉ</label>
                            <input type="number" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="credits" name="credits" value="{{ old('credits', $course->credits) }}">
                            @error('credits')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Điều Kiện Tiên Quyết -->
                        <div class="mb-4">
                            <label for="prerequisites" class="block text-sm font-medium text-gray-700">Điều Kiện Tiên Quyết</label>
                            <select id="prerequisites" name="prerequisites" class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm select3">
                                <option value="">Chọn Điều Kiện Tiên Quyết</option>
                                @foreach ($all_courses as $course)
                                    <option value="{{ $course->id }}" {{ $course->id == $currentPrerequisite ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tên Tiếng Anh -->
                        <div class="mb-4">
                            <label for="english_name" class="block text-sm font-medium text-gray-700">Tên Tiếng Anh</label>
                            <input type="text" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="english_name" name="english_name" value="{{ old('english_name', $course->english_name) }}">
                            @error('english_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phân bổ thời gian -->
                        <div class="mb-4">
                            <label for="time_allocation" class="block text-sm font-medium text-gray-700">Phân bổ thời gian</label>
                            <input type="number" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="time_allocation" name="time_allocation" value="{{ old('time_allocation', $course->time_allocation) }}">
                            @error('time_allocation')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Knowledge Area -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Thuộc khối kiến thức</label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach(['General' => 'Khối kiến thức chung', 'Core' => 'Khối kiến thức cơ bản', 'Specialized' => 'Khối kiến thức chuyên ngành', 'Internship' => 'Khối kiến thức thực tập', 'Thesis' => 'Khối kiến thức luận văn'] as $value => $label)
                                    <div class="flex items-center">
                                        <input type="radio" id="{{ $value }}" name="knowledge_area" value="{{ $value }}"
                                            {{ old('knowledge_area', $course->knowledge_area) == $value ? 'checked' : '' }}
                                            class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <label for="{{ $value }}" class="ml-2 text-sm text-gray-700">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('knowledge_area')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mục Tiêu -->
                        <div class="mb-4">
                            <label for="objectives" class="block text-sm font-medium text-gray-700">Mục Tiêu</label>
                            <textarea class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="objectives" name="objectives">{{ old('objectives', $course->objectives) }}</textarea>
                            @error('objectives')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tóm Tắt -->
                        <div class="mb-4">
                            <label for="summary" class="block text-sm font-medium text-gray-700">Tóm Tắt</label>
                            <textarea class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="summary" name="summary">{{ old('summary', $course->summary) }}</textarea>
                            @error('summary')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- mô tả -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Mô Tả</label>
                            <textarea class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="description" name="description">{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- nhiệm vụ sinh viên -->
                        <div class="mb-4">
                            <label for="student_tasks" class="block text-sm font-medium text-gray-700">Nhiệm Vụ Sinh Viên</label>
                            <textarea class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="student_tasks" name="student_tasks">{{ old('student_tasks', $course->student_tasks) }}</textarea>
                            @error('student_tasks')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- số quyết định-->
                        <div class="mb-4">
                            <label for="decision_number" class="block text-sm font-medium text-gray-700">Số Quyết Định</label>
                            <input type="text" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="decision_number" name="decision_number" value="{{ old('decision_number', $course->decision_number) }}">
                            @error('decision_number')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Đã phê duyệt check box-->
                        <div class="mb-4">
                            <label for="approved" class="block text-sm font-medium text-gray-700">Đã Phê Duyệt</label>
                            <input type="checkbox" class="form-checkbox mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="approved" name="approved" {{ old('approved', $course->approved) ? 'checked' : '' }}>
                            @error('approved')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- note -->
                        <div class="mb-4">
                            <label for="note" class="block text-sm font-medium text-gray-700">Ghi Chú</label>
                            <textarea class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="note" name="note">{{ old('note', $course->note) }}</textarea>
                            @error('note')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ngày phê duyệt -->
                        <div class="mb-4">
                            <label for="approved_at" class="block text-sm font-medium text-gray-700">Ngày Phê Duyệt</label>
                            <input type="date" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="approved_at" name="approved_at" value="{{ old('approved_at', $course->approved_at) }}">
                            @error('approved_at')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- kích hoạt is_active -->
                        <div class="mb-4">
                            <label for="is_active" class="block text-sm font-medium text-gray-700">Kích Hoạt</label>
                            <input type="checkbox" class="form-checkbox mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                id="is_active" name="is_active" {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                            @error('is_active')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <!-- Nút cập nhật -->
                        <div class="mt-6 flex justify-center">
                            <button type="submit" class="update-btn">
                                Cập Nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .update-btn {
            background: linear-gradient(to right, #FCD34D, #FBBF24);
            color: white;
            padding: 12px 32px;
            border-radius: 9999px;
            font-size: 1.125rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            cursor: pointer;
        }

        .update-btn:hover {
            background: linear-gradient(to right, #FBBF24, #F59E0B);
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 10px rgba(0, 0, 0, 0.15);
        }

        .update-btn:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(252, 211, 77, 0.5);
        }
    </style>
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
