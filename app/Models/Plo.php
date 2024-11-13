<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plo extends Model
{
    use HasFactory;

    protected $table = 'plos';

    protected $fillable = [
        'name',
        'description',
    ];

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'major_plo', 'plo_id', 'major_id');
    }
    
}
