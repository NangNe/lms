<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doashboard Admin ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('courses_lo') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                        <form action="{{ route('courses_lo.update', $coursesLo) }}" method="POST">
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
                                <label for="name" class="form-label">Tên LO</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $coursesLo->name) }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="detail" class="form-label">Chi tiết</label>
                                <input type="text" class="form-control" id="detail" name="detail"
                                    value="{{ old('detail', $coursesLo->detail) }}">
                                @error('detail')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="knowledge" class="form-label">Kiến thức</label>
                                <input type="number" class="form-control" id="knowledge" name="knowledge"
                                    value="{{ old('knowledge', $coursesLo->knowledge) }}">
                                @error('knowledge')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="skill" class="form-label">Kỹ Năng</label>
                                <input type="number" class="form-control" id="skill" name="skill"
                                    value="{{ old('skill', $coursesLo->skill) }}">
                                @error('skill')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="autonomy_responsibility" class="form-label">Trách nhiệm</label>
                                <input type="number" class="form-control" id="autonomy_responsibility" name="autonomy_responsibility"
                                    value="{{ old('autonomy_responsibility', $coursesLo->autonomy_responsibility) }}">
                                @error('autonomy_responsibility')
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
