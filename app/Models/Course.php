<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'major_id', 'code', 'semester', 'credits', 'prerequisites', 'prior_course', 'co_requisite', 'is_mandatory', 'knowledge_area', 'objectives', 'summary', 'description', 'student_tasks', 'decision_no', 'is_approved', 'note', 'approved_date', 'is_active', 'english_name','time_allocation','department','syllabus' ];



    // public function syllabi()
    // {
    //     return $this->hasMany(Syllabus::class);
    // }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'major_courses');
    }

    public function prerequisite()
    {
        return $this->belongsTo(Course::class, 'prerequisites');
    }

    public function priorCourse()
    {
        return $this->belongsTo(Course::class, 'prior_course');
    }

    public function coRequisite()
    {
        return $this->belongsTo(Course::class, 'co_requisite');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'course_id');
    }

    public function lecturers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lecturer_courses', 'course_id', 'lecturer_id');
    }
}
