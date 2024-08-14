<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doashboard Admin ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('majors') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (isset($major))
                        <a href="{{ route('majors.edit', ['id' => $major->id]) }}" class="btn btn-warning">Sửa</a>

                        <form action="{{ route('majors.update', $major) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="code" class="form-label">Mã Chuyên Ngành</label>
                                <input type="text" class="form-control" id="code" name="code"
                                    value="{{ old('code', $major->code) }}" required>
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Tên Chuyên Ngành</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $major->name) }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô Tả</label>
                                <textarea class="form-control" id="description" name="description">{{ old('description', $major->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="decision_number" class="form-label">Số Quyết Định</label>
                                <input type="text" class="form-control" id="decision_number" name="decision_number"
                                    value="{{ old('decision_number', $major->decision_number) }}">
                                @error('decision_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="total_credits" class="form-label">Total Credit</label>
                                <input type="number" class="form-control" id="total_credits" name="total_credits"
                                    value="{{ old('total_credits', $major->total_credits) }}">
                                @error('total_credits')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </form>
                    @else
                        <p>Không tìm thấy chuyên ngành.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
