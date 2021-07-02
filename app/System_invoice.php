<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System_invoice extends Model
{
    public function amnt()
    {
        return $this->belongsTo('App\Amount');
    }
}
