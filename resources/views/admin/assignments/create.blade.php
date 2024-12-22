<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>
    <style>
        /* Tùy chỉnh bảng */
        .table thead th {
            text-align: center;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .remove-assignments {
            cursor: pointer;
            color: red;
            font-size: 1.5rem;
        }

        .assignments .form-control.course-select {
            flex: 2;
            min-width: 200px;
        }
    </style>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('assignments.index') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-12">
                        <h1>Tạo Assignments</h1>

                        <form action="{{ route('assignments.store') }}" method="POST">
                            @csrf

                            {{-- <div class="form-group">
                                <label for="course_id" class="form-label">Chọn Khóa Học</label>
                                <select id="course_id" name="course_id" class="form-control select2" required>
                                    @foreach ($allcourses as $course)
                                        <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="component_name" class="form-label">Tên thành phần đánh giá</label>
                                <input type="text" class="form-control" id="component_name" name="component_name"
                                    value="{{ old('component_name') }}">
                                @error('component_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="weight" class="form-label">Trọng số</label>
                                <input type="text" class="form-control" id="weight" name="weight"
                                    value="{{ old('weight') }}">
                                @error('weight')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="clo_ids" class="form-label">CLO</label>
                                <select id="clo_ids" name="clo_ids[]" class="form-control select3" multiple>
                                    @foreach ($courselos as $clo)
                                        <option value="{{ $clo->id }}">{{ $clo->name }}-{{ $clo->detail }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="assessment_type" class="form-label">Hình Thức</label>
                                <input type="text" class="form-control" id="assessment_type" name="assessment_type"
                                    value="{{ old('assessment_type') }}">
                                @error('assessment_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="assessment_tool" class="form-label">Công cụ</label>
                                <input type="text" class="form-control" id="assessment_tool" name="assessment_tool"
                                    value="{{ old('assessment_tool') }}">
                                @error('assessment_tool')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="clo_weight" class="form-label">Trọng số CLO</label>
                                <input type="text" class="form-control" id="clo_weight" name="clo_weight"
                                    value="{{ old('clo_weight') }}">
                                @error('clo_weight')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="plos" class="form-label">PLO liên quan</label>
                                <input type="text" class="form-control" id="plos" name="plos"
                                    value="{{ old('plos') }}">
                                @error('plos')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
 --}}

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Chọn Khóa Học</th>
                                        <th>Tên thành phần đánh giá</th>
                                        <th>Trọng số</th>
                                        <th>CLO</th>
                                        <th>Hình Thức</th>
                                        <th>Công cụ</th>
                                        <th>Trọng số CLOCLO</th>
                                        <th>PLO liên quanquan</th>
                                    </tr>
                                </thead>
                                <tbody id="assignments-table-body">
                                    <tr class="assignment-row">
                                        <td>
                                            <select name="course_id[]" class="form-control select2" required>
                                                @foreach ($allcourses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->code }} -
                                                        {{ $course->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="component_name[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="weight[]">
                                        </td>
                                        <td>
                                            <select id="clo_ids" name="clo_ids[0][]" class="form-control select3" multiple>
                                                @foreach ($courselos as $clo)
                                                    <option value="{{ $clo->id }}">{{ $clo->name }} - {{ $clo->detail }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="assessment_type[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="assessment_tool[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="clo_weight[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="plos[]">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger remove-row">Remove</button>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            
                                
                            </table>
                            <button type="button" id="add-assignments" class="btn btn-secondary mb-3">Add
                                More</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thêm các liên kết JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Khởi tạo Select2
            function initializeSelect2() {
                $('.select2').select2({
                    placeholder: "Chọn Khóa học",
                    allowClear: true
                });

                $('.select3').select2({
                    placeholder: "Chọn CLO",
                    allowClear: true
                });
            }

            initializeSelect2();

            // Hàm để load CLOs khi thay đổi khóa học
            function loadClos(courseSelect) {
                var courseId = courseSelect.val();
                var cloSelect = courseSelect.closest('tr').find('.select3');

                if (courseId) {
                    $.ajax({
                        url: `/admin/courses/${courseId}/clos`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            cloSelect.empty();
                            $.each(data, function(index, clo) {
                                cloSelect.append('<option value="' + clo.id + '">' + clo.name +
                                    ' - ' + clo.detail + '</option>');
                            });
                            cloSelect.trigger('change');
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                        }
                    });
                } else {
                    cloSelect.empty();
                }
            }

            // Sự kiện thay đổi khóa học
            $(document).on('change', '.select2', function() {
                loadClos($(this));
            });

            // Thêm Assignments mới
            $('#add-assignments').click(function() {
                // Lấy giá trị khóa học từ dòng trước đó
                var previousCourseId = $('.select2').last().val();

                // Thêm dòng mới
                var newRow = `
                <tr>
                                        <td>
                                            <select name = "course_id[]" class="form-control select2" required>
                                                @foreach ($allcourses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->code }} -
                                                        {{ $course->name }}
                                                    </option>
                                                @endforeach
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="component_name[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="weight[]">
                                        </td>
                                        <td>
                                            <select id="clo_ids" name="clo_ids[1][]" class="form-control select3" multiple>
    @foreach ($courselos as $clo)
        <option value="{{ $clo->id }}">{{ $clo->name }} - {{ $clo->detail }}</option>
    @endforeach
</select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="assessment_type[]">   
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="assessment_tool[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="clo_weight[]">
                                        </td>

                                        <td>
                                            <input type="text" class="form-control" name="plos[]">
                                        </td>
                                    </tr>
                `;

                $('#assignments-table-body').append(newRow);
                initializeSelect2();

                // Load CLOs cho khóa học đã gán
                var newRowCourseSelect = $('.select2').last();
                loadClos(newRowCourseSelect);
            });

            // Xóa Assignments
            $(document).on('click', '.remove-assignments', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>

</x-app-layout>
