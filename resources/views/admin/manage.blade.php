<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý lecturer') }}
        </h2>
    </x-slot>
</style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ 'dashboard' }}">Back</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Quyền Quản Lý</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lecturers as $lecturer)
                                <tr>
                                    <td>{{ $lecturer->id }}</td>
                                    <td>{{ $lecturer->name }}</td>
                                    <td>{{ $lecturer->email }}</td>
                                    <td>{{ $lecturer->can_manage_content ? 'Có' : 'Không' }}</td>
                                    <td>
                                        <form action="{{ route('admin.toggleLecturerPermission', $lecturer->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit">
                                                {{ $lecturer->can_manage_content ? 'Thu hồi quyền' : 'Cấp quyền' }}
                                            </button>
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
