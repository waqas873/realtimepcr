<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amount extends Model
{
	public function account_category()
    {
        return $this->belongsTo('App\Account_category');
    }
    
    public function system_invoice()
    {
        return $this->hasOne('App\System_invoice');
    }
}
