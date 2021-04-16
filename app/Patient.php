<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User' , 'reffered_by' , 'id');
    }

    public function users()
    {
        return $this->belongsTo('App\User' , 'user_id' , 'id');
    }

    public function invoice()
    {
        return $this->hasMany('App\Invoice');
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
