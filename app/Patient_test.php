<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient_test extends Model
{
    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function processed()
    {
        return $this->belongsTo('App\User', 'processed_by' , 'id');
    }

    public function patient_test_results()
    {
        return $this->hasOne('App\Patient_test_result');
    }

    public function patient_tests_repeated()
    {
        return $this->hasOne('App\Patient_tests_repeated');
    }

    public function passenger()
    {
        return $this->hasMany('App\Passenger', 'patient_id' , 'patient_id');
    }

}
