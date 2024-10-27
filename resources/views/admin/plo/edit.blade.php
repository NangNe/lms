<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin - Chỉnh sửa PLO') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('plos.index') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('plos.update', $plo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Mã chuyên ngành -->
                        <div class="mb-3">
                            <label for="major_id" class="form-label">Mã chuyên ngành</label>
                            <select id="major_id" name="major_id" class="form-control" required>
                                <option value="">Chọn chuyên ngành</option>
                                @foreach ($allMajors as $major)
                                    <option value="{{ $major->id }}" {{ $major->id == $plo->major_id ? 'selected' : '' }}>
                                        {{ $major->code }} - {{ $major->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('major_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tên PLO -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên PLO</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $plo->name) }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mô tả -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" required>{{ old('description', $plo->description) }}</textarea>
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
