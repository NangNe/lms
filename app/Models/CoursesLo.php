<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CoursesLo extends Model
{
    use HasFactory;

    protected $table = 'courses_lo';

    protected $fillable = [
        'course_id',
        'name',
        'detail',
        'knowledge',
        'skills',
        'autonomy_responsibility',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function lessons()
    {
        return $this->belongsToMany(Lessons::class, 'course_lesson', 'course_lo_id', 'lesson_id');
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignments::class, 'assignment_courses_lo', 'course_lo_id', 'assignment_id');
    }
}
