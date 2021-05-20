<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function doctor_categories()
    {
        return $this->hasMany('App\Doctor_category');
    }
}
