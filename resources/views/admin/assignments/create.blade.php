<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('assignments.index') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-12">
                        <h1>Tạo Assignments</h1>

                        <form action="{{ route('assignments.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
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
                                        <option value="{{ $clo->id }}">{{ $clo->name }}-{{$clo->detail}}</option>
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
        $('.select2').select2({
            placeholder: "Chọn Khóa học",
            allowClear: true
        });
    });
    $(document).ready(function() {
        $('.select3').select2({
            placeholder: "Chọn CLO",
            allowClear: true
        });
    });
    $('#course_id').change(function() {
                var courseId = $(this).val();
                if (courseId) {
                        $.ajax({
                            url: `/admin/courses/${courseId}/clos`,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                var cloSelect = $('#clo_ids');
                                cloSelect.empty();
                                $.each(data, function(index, clo) {
                                    cloSelect.append('<option value="' + clo.id + '" data-detail="' + clo.detail + '">' + clo.name + ' - ' + clo.detail + '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error:', error);
                            }
                        });
                    } else {
                        $('#clo_ids').empty();
                    }
                });
</script>
