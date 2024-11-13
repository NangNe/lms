<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('majors') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block text-lg font-medium">Quay lại</a>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    @if (isset($major))
                        <a href="{{ route('majors.edit', ['id' => $major->id]) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200 mb-4 inline-block">Sửa</a>

                        <form action="{{ route('majors.update', $major) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="code" class="block text-gray-700 font-semibold mb-2">Mã Khoa</label>
                                <input type="text" class="form-input w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" id="code" name="code" value="{{ old('code', $major->code) }}" required>
                                @error('code')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name" class="block text-gray-700 font-semibold mb-2">Tên Chuyên Ngành</label>
                                <input type="text" class="form-input w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" id="name" name="name" value="{{ old('name', $major->name) }}" required>
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-gray-700 font-semibold mb-2">Mô Tả</label>
                                <textarea class="form-input w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" id="description" name="description">{{ old('description', $major->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="decision_number" class="block text-gray-700 font-semibold mb-2">Số Quyết Định</label>
                                <input type="text" class="form-input w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" id="decision_number" name="decision_number" value="{{ old('decision_number', $major->decision_number) }}">
                                @error('decision_number')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="text-center mt-8">
                                <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">Cập nhật</button>
                            </div>
                        </form>
                    @else
                        <p class="text-gray-600">Không tìm thấy chuyên ngành.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5; /* Màu nền nhạt */
        margin: 0;
        padding: 0;
    }

    .form-input {
        border-radius: 8px; /* Bo góc các ô nhập liệu */
        padding: 12px; /* Padding cho các ô nhập liệu */
        font-size: 16px; /* Kích thước chữ trong ô nhập liệu */
        color: #4a5568; /* Màu chữ trong ô nhập liệu */
        border: 1px solid #ddd; /* Đường viền nhẹ cho các ô nhập liệu */
    }

    .form-input:focus {
        border-color: #1d4ed8; /* Đổi màu viền khi ô nhập liệu được focus */
        outline: none; /* Loại bỏ outline khi focus */
    }

    .text-red-600 {
        color: #dc2626; /* Màu chữ thông báo lỗi */
    }

    .bg-blue-600 {
        width: 150px;
        height: 50px;
        background-color: #1d4ed8; /* Màu xanh đậm cho nút lưu */
    }

    .bg-blue-600:hover {
        background-color: #1e40af; /* Màu xanh đậm hơn khi hover */
    }

    .bg-yellow-500 {
        background-color: #f59e0b; /* Màu vàng cho nút sửa */
    }

    .bg-yellow-500:hover {
        background-color: #d97706; /* Màu vàng đậm hơn khi hover */
    }
</style>
