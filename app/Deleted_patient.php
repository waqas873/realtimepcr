<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deleted_patient extends Model
{
    public function logs()
    {
        return $this->hasOne('App\logs','id','log_of_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User' , 'deleted_by' , 'id');
    }
}
