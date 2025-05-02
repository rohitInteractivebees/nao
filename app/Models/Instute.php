<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instute extends Model
{
    use HasFactory;

    protected $table = 'instutes';
    protected $fillable = [
        'name',
       
    ];
}
