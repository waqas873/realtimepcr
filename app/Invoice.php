<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function passenger()
    {
        return $this->hasOne('App\Passenger');
    }

    public function patient_tests()
    {
        return $this->hasMany('App\Patient_test');
    }
}
