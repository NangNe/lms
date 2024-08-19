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
                    <div class="py-12">
                        <h1>Tạo Chuyên Ngành</h1>
                        <form action="{{ route('majors.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="code" class="form-label">Mã Chuyên Ngành</label>
                                <input type="text" class="form-control" id="code" name="code"
                                    value="{{ old('code') }}" required>
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Tên Chuyên Ngành</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô Tả</label>
                                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="decision_number" class="form-label">Số Quyết Định</label>
                                <input type="text" class="form-control" id="decision_number" name="decision_number"
                                    value="{{ old('decision_number') }}">
                                @error('decision_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label for="total_credits" class="form-label">Total Credit</label>
                                <input type="number" class="form-control" id="total_credits" name="total_credits"
                                    value="{{ old('total_credits') }}">
                                @error('total_credits')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
