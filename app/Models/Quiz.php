<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'published',
        'public',
        'result_show',
        'duration',
        'start_date',
        'end_date',
        'result_date',
        'class_ids',
    ];

    protected $casts = [
        'published' => 'boolean',
        'public'    => 'boolean',
        'result_show'    => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function scopePublic($q)
    {
        return $q->where('public', true);
    }

    public function scopePublished($q)
    {
        return $q->where('published', true);
    }
    public function scopeResultShow($q)
    {
        return $q->where('result_show', true);
    }
}
