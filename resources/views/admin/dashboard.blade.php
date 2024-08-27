<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div
                        class="flex items-center bg-gray-100 p-4 rounded-lg hover:bg-blue-100 active:bg-blue-200">
                        <i class="fas fa-user-cog text-blue-600 mr-4"></i>
                        <a href="{{ 'user' }}" class="text-gray-900 font-semibold hover:text-blue-600">User Manage</a>
                    </div>
                    <div
                        class="flex items-center bg-gray-100 p-4 rounded-lg hover:bg-blue-100 active:bg-blue-200">
                        <i class="fas fa-chalkboard-teacher text-blue-600 mr-4"></i>
                        <a href="{{ 'manage' }}" class="text-gray-900 font-semibold hover:text-blue-600">Lecturer Manage</a>
                    </div>
                    <div
                        class="flex items-center bg-gray-100 p-4 rounded-lg hover:bg-blue-100 active:bg-blue-200">
                        <i class="fas fa-graduation-cap text-blue-600 mr-4"></i>
                        <a href="{{ 'majors' }}" class="text-gray-900 font-semibold hover:text-blue-600">Major Manage</a>
                    </div>
                    <div
                        class="flex items-center bg-gray-100 p-4 rounded-lg hover:bg-blue-100 active:bg-blue-200">
                        <i class="fas fa-book text-blue-600 mr-4"></i>
                        <a href="{{ 'courses' }}" class="text-gray-900 font-semibold hover:text-blue-600">Course Manage</a>
                    </div>
                    <div
                        class="flex items-center bg-gray-100 p-4 rounded-lg hover:bg-blue-100 active:bg-blue-200">
                        <i class="fas fa-tasks text-blue-600 mr-4"></i>
                        <a href="{{ 'courses_lo' }}" class="text-gray-900 font-semibold hover:text-blue-600">Course LO Manage</a>
                    </div>
                    <div
                        class="flex items-center bg-gray-100 p-4 rounded-lg hover:bg-blue-100 active:bg-blue-200">
                        <i class="fas fa-book-open text-blue-600 mr-4"></i>
                        <a href="{{ 'material' }}" class="text-gray-900 font-semibold hover:text-blue-600">Material Manage</a>
                    </div>
                    <div
                        class="flex items-center bg-gray-100 p-4 rounded-lg hover:bg-blue-100 active:bg-blue-200">
                        <i class="fas fa-file-alt text-blue-600 mr-4"></i>
                        <a href="{{ 'assignments' }}" class="text-gray-900 font-semibold hover:text-blue-600">Assignments Manage</a>
                    </div>
                    <div
                        class="flex items-center bg-gray-100 p-4 rounded-lg hover:bg-blue-100 active:bg-blue-200">
                        <i class="fas fa-chalkboard text-blue-600 mr-4"></i>
                        <a href="{{ 'lessons' }}" class="text-gray-900 font-semibold hover:text-blue-600">Lessons Manage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Thêm FontAwesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
