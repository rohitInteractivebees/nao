<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'reg_no',
        'loginId',
        'spoc_email',
        'school_name',
        'country_code',
        'spoc_country_code',
        'pincode'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function scopeAdmin($query)
    {
        return $query->where('is_admin', true);
    }

    /**
     * Send the custom password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
}