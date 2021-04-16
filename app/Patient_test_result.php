<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient_test_result extends Model
{
    public function patient_medicine_results()
    {
        return $this->hasMany('App\Patient_medicine_result');
    }

}
