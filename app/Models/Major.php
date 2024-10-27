<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Major extends Model
{
    use HasFactory;

    // Nếu tên bảng không phải là dạng số nhiều của tên model, hãy chỉ định tên bảng ở đây
    protected $table = 'majors'; // Tên bảng trong cơ sở dữ liệu

    // Các thuộc tính có thể được điền
    protected $fillable = [
        'name',
        'code',
        'upload_date',
        'description',
        'decision_number',
        'total_credits',
    ];

    // Nếu bạn không sử dụng timestamp
    public $timestamps = true;

    // Khóa chính (nếu không phải là `id`)
    protected $primaryKey = 'id';

    // Một chuyên ngành có thể có nhiều khóa học
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'major_courses');
    }

    public function plos()
    {
        return $this->hasMany(Plo::class, 'major_id');
    }
}

