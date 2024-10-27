<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plo extends Model
{
    use HasFactory;

    protected $table = 'plos';

    protected $fillable = [
        'major_id',
        'name',
        'description',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
    
}
