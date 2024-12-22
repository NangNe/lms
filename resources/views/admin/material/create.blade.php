<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <!-- Thêm các liên kết CSS của Bootstrap và Select2 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Tùy chỉnh bảng */
        .table thead th {
            text-align: center;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .remove-material {
            cursor: pointer;
            color: red;
            font-size: 1.5rem;
        }

        .material .form-control.course-select {
            flex: 2;
            min-width: 200px;
        }
    </style>

    <div class="py-16">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('material') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-3">Tạo Material</h1>
                    <form action="{{ route('material.store') }}" method="POST">
                        @csrf
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Chọn Khóa Học</th>
                                    <th>Mô tả Material</th>
                                    <th>ISBN</th>
                                    <th>Ghi chú</th>
                                    <th>Tác giả</th>
                                    <th>Nhà xuất bản</th>
                                    <th>Ngày xuất bản</th>
                                    <th>Phiên bản</th>
                                    <th>Main Material</th>
                                    <th>Hard Copy</th>
                                    <th>Online</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="materials-table-body">
                                <tr>
                                    <td>
                                        <select name="course_id[]" class="form-control select2" required>
                                            @foreach ($allcourses as $course)
                                                <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="description_material[]" required></td>
                                    <td><input type="text" class="form-control" name="isbn[]"></td>
                                    <td><textarea class="form-control" name="note[]"></textarea></td>
                                    <td><input type="text" class="form-control" name="author[]"></td>
                                    <td><input type="text" class="form-control" name="publisher[]"></td>
                                    <td><input type="date" class="form-control" name="publish_date[]"></td>
                                    <td><input type="text" class="form-control" name="edition[]"></td>
                                    <td class="text-center">
                                        <input type="hidden" name="is_main_material[]" value="0">
                                        <input type="checkbox" name="is_main_material[]" value="1">
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="is_hard_copy[]" value="0">
                                        <input type="checkbox" name="is_hard_copy[]" value="1">
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="is_online[]" value="0">
                                        <input type="checkbox" name="is_online[]" value="1">
                                    </td>
                                    <td class="text-center">
                                        <span class="remove-material">&times;</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" id="add-material" class="btn btn-secondary mb-3">Add More</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Thêm các liên kết JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Khởi tạo Select2 cho hàng đầu tiên
            $('.select2').select2({
                placeholder: "Chọn Khóa học",
                allowClear: true
            });
    
            // Hàm để thêm một hàng mới
            $('#add-material').click(function() {
                let lastCourseId = $("select[name='course_id[]']").last().val(); // Lấy khóa học của hàng trên cùng
    
                let newRow = `
                <tr>
                    <td>
                        <select name="course_id[]" class="form-control select2" disabled>
                            @foreach ($allcourses as $course)
                                <option value="{{ $course->id }}" ${"{{ $course->id }}" == lastCourseId ? 'selected' : ''}>
                                    {{ $course->code }} - {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="course_id[]" value="${lastCourseId}">
                    </td>
                    <td><input type="text" class="form-control" name="description_material[]" required></td>
                    <td><input type="text" class="form-control" name="isbn[]"></td>
                    <td><textarea class="form-control" name="note[]"></textarea></td>
                    <td><input type="text" class="form-control" name="author[]"></td>
                    <td><input type="text" class="form-control" name="publisher[]"></td>
                    <td><input type="date" class="form-control" name="publish_date[]"></td>
                    <td><input type="text" class="form-control" name="edition[]"></td>
                    <td class="text-center">
                        <input type="hidden" name="is_main_material[]" value="0">
                        <input type="checkbox" name="is_main_material[]" value="1">
                    </td>
                    <td class="text-center">
                        <input type="hidden" name="is_hard_copy[]" value="0">
                        <input type="checkbox" name="is_hard_copy[]" value="1">
                    </td>
                    <td class="text-center">
                        <input type="hidden" name="is_online[]" value="0">
                        <input type="checkbox" name="is_online[]" value="1">
                    </td>
                    <td class="text-center">
                        <span class="remove-material">&times;</span>
                    </td>
                </tr>`;
    
                $('#materials-table-body').append(newRow);
    
                // Khởi tạo Select2 (nếu cần)
                $('.select2').select2();
            });
    
            // Hàm để xóa một hàng
            $(document).on('click', '.remove-material', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
    
</x-app-layout>
