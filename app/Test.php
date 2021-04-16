<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function test_category()
    {
        return $this->belongsTo('App\Test_category');
    }

    public function sample()
    {
        return $this->belongsTo('App\Sample');
    }

    public function reporting_units()
    {
        return $this->belongsTo('App\Reporting_unit' , 'reporting_unit_id');
    }
}
