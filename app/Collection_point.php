<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection_point extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function cp_categories()
    {
        return $this->hasMany('App\Collection_point_category');
    }
}
