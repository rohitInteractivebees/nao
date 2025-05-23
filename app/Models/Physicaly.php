<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Physicaly extends Model
{
    use HasFactory;

    protected $table = 'physicalys';
    protected $fillable = [
        'title',
        'description',
        'image',
        'file',
        'edited',
        'student_id',
        'college_id',
       
    ];
}
