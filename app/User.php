<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function lab()
    {
        return $this->belongsTo('App\Lab');
    }

    public function collection_point()
    {
        return $this->belongsTo('App\Collection_point');
    }

    public function airline()
    {
        return $this->belongsTo('App\Airline');
    }

    public function patients()
    {
        return $this->hasMany('App\Patient');
    }

    public function patient_tests()
    {
        return $this->hasMany('App\Patient_test');
    }

    public function admin_permissions()
    {
        return $this->hasMany('App\Admin_permission');
    }

}
