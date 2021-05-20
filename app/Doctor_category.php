<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor_category extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
