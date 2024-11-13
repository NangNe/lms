<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('majors') }}" class="text-blue-600 hover:text-blue-800 font-semibold mb-4 inline-block">
                &larr; Quay lại
            </a>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-semibold text-gray-700 mb-6">Tạo Chuyên Ngành</h1>
                    <form action="{{ route('majors.store') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="code" class="block text-gray-700 font-medium mb-2">Mã Khoa</label>
                            <select id="code" name="code" class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" selected>Chọn mã khoa</option>
                                @foreach ($existingCodes as $code)
                                    <option value="{{ $code }}">{{ $code }}</option>
                                @endforeach
                                <option value="new_code">Tạo mã khoa mới</option>
                            </select>
                        </div>
                        <div class="mb-6" id="new_code_input" style="display: none;">
                            <label for="new_code" class="block text-gray-700 font-medium mb-2">Nhập Mã Khoa Mới</label>
                            <input type="text" id="new_code" name="new_code" class="form-input w-full">
                        </div>

                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 font-medium mb-2">Tên Chuyên Ngành</label>
                            <input type="text"
                                class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-gray-700 font-medium mb-2">Mô Tả</label>
                            <textarea class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500" id="description"
                                name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="decision_number" class="block text-gray-700 font-medium mb-2">Số Quyết
                                Định</label>
                            <input type="text"
                                class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
                                id="decision_number" name="decision_number" value="{{ old('decision_number') }}">
                            @error('decision_number')
                                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center mt-8">
                            <button type="submit"
                                class="bg-blue-600 text-white py-3 px-6 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">Lưu</button>
                        </div>
                        <style>
                            body {
                                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                background-color: #f5f5f5;
                                /* Màu nền nhạt */
                                margin: 0;
                                padding: 0;
                            }

                            .form-input {
                                border-radius: 8px;
                                /* Bo góc các ô nhập liệu */
                                padding: 12px;
                                /* Padding cho các ô nhập liệu */
                                font-size: 16px;
                                /* Kích thước chữ trong ô nhập liệu */
                                color: #4a5568;
                                /* Màu chữ trong ô nhập liệu */
                                border: 1px solid #ddd;
                                /* Đường viền nhẹ cho các ô nhập liệu */
                            }

                            .form-input:focus {
                                border-color: #1d4ed8;
                                /* Đổi màu viền khi ô nhập liệu được focus */
                                outline: none;
                                /* Loại bỏ outline khi focus */
                            }

                            .text-red-600 {
                                color: #dc2626;
                                /* Màu chữ thông báo lỗi */
                            }

                            .bg-blue-600 {
                                width: 100px;
                                height: 50px;
                                background-color: #1d4ed8;
                                /* Màu xanh đậm cho nút lưu */
                            }

                            .bg-blue-600:hover {
                                background-color: #1e40af;
                                /* Màu xanh đậm hơn khi hover */
                            }
                        </style>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.getElementById('code').addEventListener('change', function() {
        const newCodeInput = document.getElementById('new_code_input');
        if (this.value === 'new_code') {
            newCodeInput.style.display = 'block';
        } else {
            newCodeInput.style.display = 'none';
        }
    });
</script>
