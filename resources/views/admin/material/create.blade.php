<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('material') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-12">
                        <h1>Tạo Material</h1>

                        <form action="{{ route('material.store') }}" method="POST">
                            @csrf
                            <div id="materials-container">
                                <div class="material-group">
                                    <div class="form-group">
                                        <label for="course_id" class="form-label">Chọn Khóa Học</label>
                                        <select id="course_id" name="course_id[]" class="form-control select2" required>
                                            @foreach ($allcourses as $course)
                                                <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="description_material" class="form-label">Mô Tả</label>
                                            <input type="text" class="form-control" name="description_material[]"
                                                value="{{ old('description_material') }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="isbn" class="form-label">ISBN</label>
                                            <input type="text" class="form-control" name="isbn[]" value="{{ old('isbn') }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="author" class="form-label">Tác Giả</label>
                                            <input type="text" class="form-control" name="author[]" value="{{ old('author') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="publisher" class="form-label">Nhà Xuất Bản</label>
                                            <input type="text" class="form-control" name="publisher[]" value="{{ old('publisher') }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="publish_date" class="form-label">Ngày Xuất Bản</label>
                                            <input type="date" class="form-control" name="publish_date[]" value="{{ old('publish_date') }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="edition" class="form-label">Phiên Bản</label>
                                            <input type="text" class="form-control" name="edition[]" value="{{ old('edition') }}">
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" name="is_main_material[]" class="form-check-input" value="1"
                                            {{ old('is_main_material') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_main_material">Is Main Material</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" name="is_hard_copy[]" class="form-check-input" value="1"
                                            {{ old('is_hard_copy') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_hard_copy">Is Hard Copy</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" name="is_online[]" class="form-check-input" value="1"
                                            {{ old('is_online') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_online">Is Online</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="note" class="form-label">Note</label>
                                        <input type="text" class="form-control" name="note" value="{{ old('note') }}">
                                    </div>                              
                                    <button type="button" class="btn btn-danger remove-material">Remove</button>
                                    <hr>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" id="add-material">Add More</button>
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

        // Clone the first material-group and append it to the container
        $('#add-material').on('click', function() {
            const materialGroup = $('.material-group').first().clone();
            // Reset input values
            materialGroup.find('input').val('');
            materialGroup.find('select').val($('#course_id').val()).trigger('change');
            $('#materials-container').append(materialGroup);
        });

        // Remove the material-group
        $(document).on('click', '.remove-material', function() {
            if ($('.material-group').length > 1) {
                $(this).closest('.material-group').remove();
            }
        });
    });
</script>
