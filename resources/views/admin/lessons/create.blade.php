<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Tùy chỉnh bảng */
        .table thead th {
            text-align: center;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .remove-lesson {
            cursor: pointer;
            color: red;
        }

        .lesson .form-control.course-select {
            flex: 2;
            min-width: 200px;
        }
    </style>

    <div class="py-16">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('lessons.index') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-3">Tạo Lessons</h1>
                    <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Chọn Khóa Học</th>
                                    <th>Topic</th>
                                    <th>Số Tiết</th>
                                    <th>Mục Tiêu</th>
                                    <th>CLOs</th>
                                    <th>Phương Pháp Giảng Dạy</th>
                                    <th>Active</th>
                                    <th>File Tải Về</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="lesson-table-body">
                                <tr>
                                    <td>
                                        <select name="course_id[]" class="form-control select2" required>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->code }} -
                                                    {{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="topic[]">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="number_of_periods[]">
                                    </td>
                                    <td>
                                        <textarea class="form-control" name="objectives[]"></textarea>
                                    </td>
                                    <td>
                                        <select id="clos" name="clos[]" class="form-control select3" multiple>
                                            @foreach ($courselos as $clo)
                                                <option value="{{ $clo->id }}" data-detail="{{ $clo->detail }}">
                                                    {{ $clo->name }} - {{ $clo->detail }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <div class="mb-4">
                                        <label for="clos" class="form-label">CLO</label>

                                    </div>

                                    <td>
                                        <input type="text" class="form-control" name="lecture_method[]">
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control" name="active[]">
                                    </td>
                                    <td>
                                        <input type="file" id="s_download" class="form-control" name="s_download[]">
                                    </td>
                                    <td class="text-center">
                                        <span class="remove-lesson">&times;</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" id="add-lesson" class="btn btn-secondary mb-3">Add More</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                    // Gửi yêu cầu AJAX tới server
                    $.ajax({
                        url: `/admin/courses/${courseId}/clos`, // Đường dẫn API
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Làm rỗng dropdown CLO
                            cloSelect.empty();

                            // Thêm các CLO mới
                            $.each(data, function(index, clo) {
                                cloSelect.append('<option value="' + clo.id + '">' + clo.name +
                                    ' - ' + clo.detail + '</option>');
                            });

                            // Làm mới Select2
                            cloSelect.trigger('change');
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                        }
                    });
                } else {
                    cloSelect.empty(); // Nếu không chọn khóa học, làm rỗng CLOs
                }
            }

            // Sự kiện thay đổi khóa học
            $(document).on('change', '.select2', function() {
                loadClos($(this));
            });

            // Hàm thêm hàng mới
            $('#add-lesson').click(function() {
                var newRow = `
            <tr>
                <td>
                    <select name="course_id[]" class="form-control select2" required>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" name="topic[]" required>
                </td>
                <td>
                    <input type="number" class="form-control" name="number_of_periods[]" required>
                </td>
                <td>
                    <textarea class="form-control" name="objectives[]"></textarea>
                </td>
                <td>
                    <select name="clos[]" class="form-control select3" multiple>
                        <!-- CLOs sẽ được load qua AJAX -->
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" name="lecture_method[]">
                </td>
                <td class="text-center">
                    <input type="text" class="form-control" name="active[]">
                </td>
                <td>
                    <input type="file" class="form-control" name="s_download[]">
                </td>
                <td class="text-center">
                    <span class="remove-lesson">&times;</span>
                </td>
            </tr>
        `;
                $('#lesson-table-body').append(newRow);

                // Khởi tạo lại Select2 cho các hàng mới
                initializeSelect2();
            });

            // Hàm xóa một hàng
            $(document).on('click', '.remove-lesson', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
</x-app-layout>
