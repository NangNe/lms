<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý PLO') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('dashboard') }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Danh sách PLO</h1>
                    <a href="{{ route('plos.create') }}" class="btn btn-primary">Tạo PLO Mới</a>
                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Tên Chuyên Ngành</th>
                                <th>Mã PLO</th>
                                <th>Mô tả</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plos as $plo)
                                <tr>
                                    <td>
                                        @foreach ($plo->majors as $major)
                                            <div>{{ $major->name }}</div>
                                            <!-- Hiển thị mỗi chuyên ngành trên một dòng riêng biệt -->
                                        @endforeach
                                    </td>
                                    <td>{{ $plo->name }}</td>
                                    <td>{{ $plo->description }}</td>
                                    <td>
                                        <a href="{{ route('plos.edit', $plo) }}" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('plos.destroy', $plo) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
