<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Majors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ 'dashboard' }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('majors.create') }}" class="btn btn-primary">Tạo Chuyên Ngành Mới</a>

                    @foreach ($majors as $code => $majorGroup)
                    <h2 class="text-lg font-semibold mt-4">Khoa {{ $code }}</h2>
                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Tên chuyên ngành</th>
                                <th>Ngày Tải Lên</th>
                                <th>Mô Tả</th>
                                <th>Số Quyết Định</th>
                                <th>Total Credit</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($majorGroup->isEmpty())
                                <tr>
                                    <td colspan="6">Không có chuyên ngành nào cho mã khoa này.</td>
                                </tr>
                            @else
                                @foreach ($majorGroup as $major)
                                    <tr>
                                        <td><a href="{{ route('majors.courses', $major->id) }}">
                                            {{ $major->name }}
                                        </a></td>
                                        <td>{{ $major->created_at }}</td>
                                        <td>{{ $major->description }}</td>
                                        <td>{{ $major->decision_number }}</td>
                                        <td>{{ $major->total_credits }}</td>
                                        <td>
                                            <a href="{{ route('majors.edit', $major) }}" class="btn btn-warning">Sửa</a>
                                            <form action="{{ route('majors.destroy', $major) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                @endforeach
                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
