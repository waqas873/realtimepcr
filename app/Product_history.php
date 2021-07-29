<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_history extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function lab()
    {
        return $this->belongsTo('App\Lab');
    }
}
