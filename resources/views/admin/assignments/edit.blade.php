<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sửa Assignment') }}
        </h2>
    </x-slot>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('assignments.index') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('assignments.update', $assignment) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Khóa học</label>
                            <select id="course_id" name="course_id" class="form-control">
                                @foreach ($lecturerCourses as $course)
                                    <option value="{{ $course->id }}" {{ $course->id == $assignment->course_id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="component_name" class="form-label">Tên thành phần đánh giá</label>
                            <input type="text" id="component_name" name="component_name" class="form-control" value="{{ $assignment->component_name }}" />
                        </div>
                        
                        <div class="mb-3">
                            <label for="weight" class="form-label">Trọng số</label>
                            <input type="number" id="weight" name="weight" class="form-control" value="{{ $assignment->weight }}" />
                        </div>
                        
                        <div class="mb-3">
                            <label for="clo_ids" class="form-label">CLO</label>
                            <select id="clo_ids" name="clo_ids[]" class="form-control select2" multiple>
                                @foreach ($clos as $clo)
                                    <option value="{{ $clo->id }}" {{ in_array($clo->id, $selectedClos) ? 'selected' : '' }}>
                                        {{ $clo->name }} - {{ $clo->detail }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="assessment_type" class="form-label">Hình Thức</label>
                            <input type="text" id="assessment_type" name="assessment_type" class="form-control" value="{{ $assignment->assessment_type }}" />
                        </div>
                        
                        <div class="mb-3">
                            <label for="assessment_tool" class="form-label">Công cụ</label>
                            <input type="text" id="assessment_tool" name="assessment_tool" class="form-control" value="{{ $assignment->assessment_tool }}" />
                        </div>
                        
                        <div class="mb-3">
                            <label for="clo_weight" class="form-label">Trọng số CLO</label>
                            <input type="number" id="clo_weight" name="clo_weight" class="form-control" value="{{ $assignment->clo_weight }}" />
                        </div>
                        
                        <div class="mb-3">
                            <label for="plos" class="form-label">PLO liên quan</label>
                            <input type="text" id="plos" name="plos" class="form-control" value="{{ $assignment->plos }}" />
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
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
    // JavaScript để cập nhật danh sách CLOs khi thay đổi khóa học
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
