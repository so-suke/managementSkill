<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Employee extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_admin',
        'job_title_id',
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'profile_image_path',
        'email',
        'password',
        'gender',
        'hired_at',
        'birth_at',
        'remarks',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function jobTitle()
    {
        return $this->belongsTo('App\JobTitle');
    }

    public function languageExperiences()
    {
        return $this->hasMany('App\LanguageExperience');
    }

    public function frameworkExperiences()
    {
        return $this->hasMany('App\FrameworkExperience');
    }

    public function otherToolExperiences()
    {
        return $this->hasMany('App\OtherToolExperience');
    }
}
