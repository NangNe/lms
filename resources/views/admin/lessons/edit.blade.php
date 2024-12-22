<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sửa Lessons') }}
        </h2>
    </x-slot>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4">
                            <label for="course_id" class="form-label">Khóa học</label>
                            <select id="course_id" name="course_id" class="form-control">
                                @foreach ($lecturerCourse as $course)
                                    <option value="{{ $course->id }}" {{ $course->id == $lesson->course_id ? 'selected' : '' }}>{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="topic" class="form-label">Nội dung</label>
                            <input type="text" id="topic" name="topic" class="form-control" value="{{ old('topic', $lesson->topic) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="number_of_periods" class="form-label">Số buổi</label>
                            <input type="number" id="number_of_periods" name="number_of_periods" class="form-control" value="{{ old('number_of_periods', $lesson->number_of_periods) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="objectives" class="form-label">Mục tiêu</label>
                            <textarea id="objectives" name="objectives" class="form-control" required>{{ old('objectives', $lesson->objectives) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="clos" class="form-label">CLO</label>
                            <select name="clos[]" id="clos" class="form-control select2" multiple="multiple">
                                @foreach ($clos as $clo)
                                    <option value="{{ $clo->id }}" {{ in_array($clo->id, $selectedClos) ? 'selected' : '' }}>
                                        {{ $clo->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                        </div>

                        <div class="mb-4">
                            <label for="lecture_method" class="form-label">Phương pháp giảng dạy</label>
                            <input type="text" id="lecture_method" name="lecture_method" class="form-control" value="{{ old('lecture_method', $lesson->lecture_method) }}">
                        </div>

                        <div class="mb-4">
                            <label for="active" class="form-label">Hoạt động sinh viên</label>
                            <input type="text" id="active" name="active" class="form-control" value="{{ old('active', $lesson->active) }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="s_download" class="form-label">Documents</label>
                            <input type="file" id="s_download" name="s_download" class="form-control">
                            @if ($lesson->s_download)
                                <p>Hiện tại: <a href="{{ Storage::url('uploads/' . $lesson->s_download) }}" target="_blank">Tải xuống tệp hiện tại</a></p>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
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
            placeholder: "Chọn Khóa học",
            allowClear: true
        });

        $('#course_id').change(function() {
            var courseId = $(this).val();
            if (courseId) {
                $.ajax({
                    url: `/admin/lessons/${courseId}/clos`,
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