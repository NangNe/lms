<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'material';

    protected $fillable = [
        'course_id',
        'description_material',
        'is_main_material',
        'isbn',
        'is_hard_copy',
        'is_online',
        'note',
        'author',
        'publisher',
        'published_date',
        'edition',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
