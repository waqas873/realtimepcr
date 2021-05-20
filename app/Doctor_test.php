<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor_test extends Model
{
    public function test()
    {
        return $this->belongsTo('App\Test');
    }
}
