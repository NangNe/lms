<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lessons extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'topic',
        'number_of_periods',
        'objectives',
        'clos', // Nếu 'clos' là tên của cột trong bảng, có thể cần kiểm tra lại
        'lecture_method',
        'active',
        's_download'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Quan hệ nhiều-nhiều với CoursesLo thông qua bảng trung gian course_lesson
    public function coursesLo()
    {
        return $this->belongsToMany(CoursesLo::class, 'course_lesson', 'lesson_id', 'course_lo_id');
    }
}

