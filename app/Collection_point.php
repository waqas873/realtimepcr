<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection_point extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
