<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }
}
