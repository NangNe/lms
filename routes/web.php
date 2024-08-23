<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\LecturerMiddleware;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursesLoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\GuestController;


Route::get('/', function () {
    return view('welcome');
});

// guest
Route::get('/guest', [GuestController::class, 'index'])->name('guest.index');
Route::get('/guest/{id}/courses', [GuestController::class, 'showCourses'])->name('guest.courses');
Route::get('/guest/detail/{id}', [GuestController::class, 'showDetail'])->name('guest.detail');
 
// user
Route::middleware('auth')->group(function () {
    Route::get('/user', [HomeController::class, 'index'])->name('user.index');
    Route::get('/user/detail/{id}', [HomeController::class, 'showDetail'])->name('user.detail');
    Route::get('/user/courses/{id}', [HomeController::class, 'showCourses'])->name('user.courses');
});

// Auth::routes();

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/manage', [AdminController::class, 'manage'])->name('admin.manage');
    Route::get('/admin/user', [AdminController::class, 'getUsers'])->name('admin.user');
    Route::post('/admin/lecturer/{lecturerId}/toggle-permission', [AdminController::class, 'toggleLecturerPermission'])->name('admin.toggleLecturerPermission');
});

// Routes dành cho lecturer
Route::middleware(['auth', LecturerMiddleware::class])->group(function () {
    Route::get('/admin/user', [AdminController::class, 'getUsers'])->name('admin.user'); // Lecturers có quyền xem danh sách người dùng
    // Route::get('/lecturer/manage', [AdminController::class, 'manageLecturer'])->name('lecturer.manage');
    
});

// Routes for major
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/majors', [MajorController::class, 'showMajor'])->name('majors');
    Route::get('/majors/create', [MajorController::class, 'create'])->name('majors.create');
    Route::post('/majors', [MajorController::class, 'store'])->name('majors.store');
    Route::get('/majors/{id}', [MajorController::class, 'showMajor'])->name('majors.show');
    Route::get('/majors/{id}/edit', [MajorController::class, 'edit'])->name('majors.edit');
    Route::put('/majors/{id}', [MajorController::class, 'update'])->name('majors.update');
    Route::delete('/majors/{id}', [MajorController::class, 'destroy'])->name('majors.destroy');
    Route::get('/majors/{id}/courses', [MajorController::class, 'showCourses'])->name('majors.courses');
});

// Routes for course
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/courses', [CourseController::class, 'index'])->name('courses');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::get('/courses/detail/{id}', [CourseController::class, 'showDetail'])->name('courses.detail');
    Route::get('/courses/{course}/clos', [CourseController::class, 'getCourseClos'])->name('courses.clos');
});

// Routes for course_LO
Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::get('/courses_lo', [CoursesLoController::class, 'index'])->name('courses_lo');
});

// Routes for material
Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::get('/material', [MaterialController::class, 'index'])->name('material');
});

// Routes for assignments
Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::get('/assignments', [AssignmentsController::class, 'index'])->name('assignments.index');
});

// Routes for lessons
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {
    Route::get('/lessons', [LessonsController::class, 'index'])->name('lessons.index');
});

//ROute for lecturer permission
Route::prefix('lecturer')->middleware(['auth', 'lecturer'])->group(function () {
    Route::get('/majors', [MajorController::class, 'showMajor'])->name('majors');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses');
});



Route::prefix('lecturer')->middleware(['auth', 'lecturer'])->group(function() {
    Route::get('/lessons', [LessonsController::class, 'index'])->name('lessons.index');
    Route::get('/lessons/create', [LessonsController::class, 'create'])->name('lessons.create');
    Route::post('/lessons', [LessonsController::class, 'store'])->name('lessons.store');
    Route::get('/lessons/{lesson}/edit', [LessonsController::class, 'edit'])->name('lessons.edit');
    Route::put('/lessons/{lesson}', [LessonsController::class, 'update'])->name('lessons.update');
    Route::delete('/lessons/{lesson}', [LessonsController::class, 'destroy'])->name('lessons.destroy');
    Route::get('/download/{filename}', [LessonsController::class, 'download'])->name('download');
    Route::get('/lessons/{courseId}/clos', [LessonsController::class, 'getClos']);
    Route::get('/admin/courses/{courseId}/clos', [LessonsController::class, 'getClosByCourse'])->name('courses.clos');
});

Route::prefix('lecturer')->middleware(['auth', 'lecturer'])->group(function () {
    Route::get('/assignments', [AssignmentsController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/create', [AssignmentsController::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [AssignmentsController::class, 'store'])->name('assignments.store');
    Route::get('/assignments/{assignment}/edit', [AssignmentsController::class, 'edit'])->name('assignments.edit');
    Route::put('/assignments/{assignment}', [AssignmentsController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [AssignmentsController::class, 'destroy'])->name('assignments.destroy');
});

Route::prefix('lecturer')->middleware(['auth','lecturer'])->group(function(){
    Route::get('/courses_lo', [CoursesLoController::class, 'index'])->name('courses_lo');
    Route::get('/courses_lo/create', [CoursesLoController::class, 'create'])->name('courses_lo.create');
    Route::post('/courses_lo', [CoursesLoController::class, 'store'])->name('courses_lo.store');
    Route::get('/courses_lo/{id}/edit', [CoursesLoController::class, 'edit'])->name('courses_lo.edit');
    Route::put('/courses_lo/{id}', [CoursesLoController::class, 'update'])->name('courses_lo.update');
    Route::delete('/courses_lo/{id}', [CoursesLoController::class, 'destroy'])->name('courses_lo.destroy');
});

Route::prefix('lecturer')->middleware(['auth', 'lecturer'])->group(function () {
    Route::get('/material', [MaterialController::class, 'index'])->name('material');
    Route::get('/material/create', [MaterialController::class, 'create'])->name('material.create');
    Route::post('/material', [MaterialController::class, 'store'])->name('material.store'); // Tạo mới
    Route::get('/material/{id}/edit', [MaterialController::class, 'edit'])->name('material.edit'); // Chỉnh sửa
    Route::put('/material/{id}', [MaterialController::class, 'update'])->name('material.update'); // Cập nhật
    Route::delete('/material/{id}', [MaterialController::class, 'destroy'])->name('material.destroy'); // Xóa
});



require __DIR__ . '/auth.php';
