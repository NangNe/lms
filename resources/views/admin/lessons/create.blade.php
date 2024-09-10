<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tạo Bài Giảng Mới') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="course_id" class="form-label">Khóa học</label>
                            <select id="course_id" name="course_id" class="form-control">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="topic" class="form-label">Nội dung</label>
                            <input type="text" id="topic" name="topic" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="number_of_periods" class="form-label">Số buổi</label>
                            <input type="number" id="number_of_periods" name="number_of_periods" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="objectives" class="form-label">Mục tiêu</label>
                            <textarea id="objectives" name="objectives" class="form-control" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="clos" class="form-label">CLO</label>
                            <select id="clos" name="clos[]" class="form-control select2" multiple>
                                @foreach ($courselos as $clo)
                                    <option value="{{ $clo->id }}" data-detail="{{ $clo->detail }}">{{ $clo->name }} - {{ $clo->detail }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="lecture_method" class="form-label">Phương pháp giảng dạy</label>
                            <input type="text" id="lecture_method" name="lecture_method" class="form-control">
                        </div>

                        <div class="mb-4">
                            <label for="active" class="form-label">Hoạt động sinh viên</label>
                            <input type="text" id="active" name="active" class="form-control">
                        </div>

                        <div class="mb-4">
                            <label for="s_download" class="form-label">Tài liệu đính kèm</label>
                            <input type="file" id="s_download" name="s_download" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <a href="{{ route('lessons.index') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Chọn CLOs",
            allowClear: true
        });

        $('#course_id').change(function() {
            var courseId = $(this).val();
            if (courseId) {
                $.ajax({
                    url: `/lecturer/lessons/${courseId}/clos`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var cloSelect = $('#clos');
                        cloSelect.empty();
                        $.each(data, function(index, clo) {
                            cloSelect.append('<option value="' + clo.id + '">' + clo.name + ' - ' + clo.detail + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            } else {
                $('#clos').empty();
            }
        });
    });
</script>
