<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection_point_test extends Model
{
    public function test()
    {
        return $this->belongsTo('App\Test');
    }
}
