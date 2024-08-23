<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <!-- Thêm các liên kết CSS của Bootstrap -->
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

        .remove-material {
            cursor: pointer;
            color: red;
        }

        .material .form-control.course-select {
            flex: 2;
            /* Tăng giá trị flex để cột dài hơn */
            min-width: 200px;
            /* Điều chỉnh chiều rộng tối thiểu nếu cần */
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
                                    <th>Is Main Material</th>
                                    <th>Is Hard Copy</th>
                                    <th>Is Online</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="materials-table-body">
                                <tr>
                                    <td>
                                        <select id="course_id" name="course_id[]" class="form-control course-select select2" required>
                                            @foreach ($allcourses as $course)
                                                <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('course_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="description_material[]" required>
                                        @error('description_material')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="isbn[]">
                                        @error('isbn')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" name="note[]"></textarea>
                                        @error('note')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="author[]">
                                        @error('author')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="publisher[]">
                                        @error('publisher')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="publish_date[]">
                                        @error('publish_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="edition[]">
                                        @error('edition')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
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

    {{-- <!-- Thêm các liên kết JS của jQuery và Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}

    <!-- Thêm liên kết JS cho Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Khởi tạo Select2
            $('.select2').select2({
                placeholder: "Chọn Khóa học",
                allowClear: true
            });

            // Hàm để thêm một hàng mới
            $('#add-material').click(function() {
                var newRow = `
                    <tr>
                        <td>
                            <select name="course_id[]" class="form-control select2" required>
                                @foreach ($allcourses as $course)
                                    <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input type="text" class="form-control" name="description_material[]" required>
                            @error('description_material')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input type="text" class="form-control" name="isbn[]">
                            @error('isbn')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <textarea class="form-control" name="note[]"></textarea>
                            @error('note')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input type="text" class="form-control" name="author[]">
                            @error('author')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input type="text" class="form-control" name="publisher[]">
                            @error('publisher')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input type="date" class="form-control" name="publish_date[]">
                            @error('publish_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input type="text" class="form-control" name="edition[]">
                            @error('edition')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
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
                `;
                $('#materials-table-body').append(newRow);
                // Khởi tạo lại Select2 cho các phần tử mới
                $('.select2').select2({
                    placeholder: "Chọn Khóa học",
                    allowClear: true
                });
            });

            // Hàm để xóa một hàng
            $(document).on('click', '.remove-material', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
</x-app-layout>
