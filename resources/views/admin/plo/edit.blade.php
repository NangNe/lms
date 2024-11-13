<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit PLO') }}
        </h2>
    </x-slot>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('plos.index') }}" class="btn btn-secondary mb-3">Quay lại</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Chỉnh sửa PLO</h1>
                    <form action="{{ route('plos.update', $plo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="major_id">Chọn Chuyên Ngành</label>
                            <select id="major_id" name="major_id[]" class="form-control select2" multiple="multiple" required>
                                @foreach ($allMajors as $major)
                                    <option value="{{ $major->id }}"
                                        {{ in_array($major->id, $plo->majors->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $major->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('major_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Tên PLO</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $plo->name) }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description', $plo->description) }}</textarea>
                            @error('description')
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

<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Chọn chuyên ngành",
        allowClear: true,
        multiple: true
    });
});
</script>
