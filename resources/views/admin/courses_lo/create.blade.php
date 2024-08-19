<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-labels {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        .form-label {
            flex: 1;
            text-align: center;
            font-weight: bold;
        }

        .learning-outcome {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .learning-outcome .form-control {
            margin: 0 5px;
            flex: 1 0 15%;
            min-width: 100px;
        }

        .remove-outcome {
            margin-left: 10px;
        }
    </style>

    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('courses_lo') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-14">
                        <h1>Tạo Learning Outcomes</h1>
                        <form action="{{ route('courses_lo.store') }}" method="POST">
                            @csrf

                            <div class="learning-outcome-container">

                                <div class="form-labels">
                                    <div class="form-label">Chọn Khóa Học</div>
                                    <div class="form-label">Tên Learning Outcomes</div>
                                    <div class="form-label">Chi Tiết</div>
                                    <div class="form-label">Kiến Thức</div>
                                    <div class="form-label">Kỹ Năng</div>
                                    <div class="form-label">Trách Nhiệm</div>
                                </div>

                                <div id="learning-outcomes-container">
                                    <div class="learning-outcome">
                                        <div class="form-group">
                                            <select id="course_id" name="course_id[]" class="form-control select2"
                                                required>
                                                @foreach ($allcourses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->code }} -
                                                        {{ $course->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('course_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="name" name="name[]"
                                                value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <textarea class="form-control" id="detail" name="detail[]">{{ old('detail') }}</textarea>
                                            @error('detail')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="knowledge" name="knowledge[]"
                                                value="{{ old('knowledge') }}">
                                            @error('knowledge')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="skills" name="skills[]"
                                                value="{{ old('skills') }}">
                                            @error('skills')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="autonomy_responsibility"
                                                name="autonomy_responsibility[]"
                                                value="{{ old('autonomy_responsibility') }}">
                                            @error('autonomy_responsibility')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <input type="hidden" id="initial_course_id" name="initial_course_id"
                                            value="">

                                        <button type="button" class="btn btn-danger remove-outcome">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="add-outcome" class="btn btn-secondary">Add More</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
<script>
$(document).ready(function() {
    // Khởi tạo select2 cho các phần tử hiện có
    $('.select2').select2({
        placeholder: "Chọn Khóa học",
        allowClear: true
    });

    // Khi người dùng chọn khóa học đầu tiên, lưu ID vào trường ẩn
    $('#course_id').change(function() {
        $('#initial_course_id').val($(this).val());
        console.log('Khóa học đã chọn:', $(this).val()); // In ra giá trị để kiểm tra
    });

    $('#add-outcome').click(function() {
        console.log('Nút Add More đã được nhấn'); // Thêm dòng này để kiểm tra
        const initialCourseId = $('#initial_course_id').val();

        if (initialCourseId) {
            const $container = $('#learning-outcomes-container');
            const $newOutcome = $('.learning-outcome').first().clone();

            // Thay thế select bằng input hidden chứa course_id
            $newOutcome.find('.form-group').html(`<input type="hidden" name="course_id[]" value="${initialCourseId}">`);

            // Xóa giá trị của các input fields khác
            $newOutcome.find('input:not([type=hidden]), textarea').val('');

            $container.append($newOutcome);
        } else {
            alert('Vui lòng chọn khóa học đầu tiên trước khi thêm nhóm mới.');
        }
    });
});

</script>
