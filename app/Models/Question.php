<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'code_snippet',
        'answer_explanation',
        'more_info_link',
        'image_path',
        'marks',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class)->orderBy('id','asc');
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }
}
