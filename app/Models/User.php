<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'institute',
        'college',
        'phone',
        'password',
        'is_admin',
        'facebook_id',
        'google_id',
        'github_id',
        'is_college',
        'session_year',
        'streams',
        'idcard',
        'is_verified',
        'other_stream',
        'level2enddate',
        'level3enddate',
        'parent_name',
        'class',
        'state',
        'city',
        'spoc_mobile',
        'country',
        'reg_no'



    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function scopeAdmin($query)
    {
        $query->where('is_admin', true);

    }
}
