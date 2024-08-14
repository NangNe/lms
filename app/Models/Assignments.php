<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'component_name',
        'weight',
        'clo_ids',
        'assessment_type',
        'assessment_tool',
        'clo_weight',
        'plos',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function coursesLo()
    {
        return $this->belongsToMany(CoursesLo::class, 'assignment_courses_lo', 'assignment_id', 'course_lo_id');
    }
}
