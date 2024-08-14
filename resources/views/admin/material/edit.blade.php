<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doashboard Admin ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('material') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('material.update', $material) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Khóa học</label>
                            <select id="course_id" name="course_id" class="form-control select3">
                                <option value="">Chọn Khóa Học</option>
                                @foreach ($lecturerCourses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ $course->id == $currentCourse ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description_material" class="form-label">Mô tả</label>
                            <input type="text" class="form-control" id="description_material"
                                name="description_material"
                                value="{{ old('description_material', $material->description_material) }}" required>
                            @error('description_material')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <lable for="is_main_material" class="form-lable">Là tài liệu chính</lable>
                            <input type="checkbox" class="form-control" id="is_main_material" name="is_main_material"
                                value="1"
                                {{ old('is_main_material', $material->is_main_material) ? 'checked' : '' }}">
                            @error('is_main_material')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn"
                                value="{{ old('isbn', $material->isbn) }}">
                            @error('isbn')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="is_hard_copy" class="form-label">Là bản cứng</label>
                            <input type="checkbox" class="form-control" id="is_hard_copy" name="is_hard_copy"
                                value="1" {{ old('is_hard_copy', $material->is_hard_copy) ? 'checked' : '' }}>
                            @error('is_hard_copy')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="is_online" class="form-label">Là tài liệu trực tuyến</label>
                            <input type="checkbox" class="form-control" id="is_online" name="is_online" value="1"
                                {{ old('is_online', $material->is_online) ? 'checked' : '' }}>
                            @error('is_online')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú</label>
                            <input type="text" class="form-control" id="note" name="note"
                                value="{{ old('note', $material->note) }}">
                            @error('note')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Tác giả</label>
                            <input type="text" class="form-control" id="author" name="author"
                                value="{{ old('author', $material->author) }}">
                            @error('author')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="publisher" class="form-label">Nhà xuất bản</label>
                            <input type="text" class="form-control" id="publisher" name="publisher"
                                value="{{ old('publisher', $material->publisher) }}">
                            @error('publisher')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="published_date" class="form-label">Ngày xuất bản</label>
                            <input type="date" class="form-control" id="published_date" name="published_date"
                                value="{{ old('published_date', $material->published_date) }}">
                            @error('published_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edition" class="form-label">Phiên bản</label>
                            <input type="text" class="form-control" id="edition" name="edition"
                                value="{{ old('edition', $material->edition) }}">
                            @error('edition')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
