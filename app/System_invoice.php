<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System_invoice extends Model
{
    public function amnt()
    {
        return $this->belongsTo('App\Amount');
    }

    public function account_category()
    {
        return $this->belongsTo('App\Account_category');
    }
}
