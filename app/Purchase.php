<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function ledgers()
    {
        return $this->hasMany('App\Ledger');
    }
}
