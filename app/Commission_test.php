<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission_test extends Model
{
	public function user()
    {
        return $this->belongsTo('App\User' , 'to_user_id' , 'id');
    }

    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function lab()
    {
        return $this->belongsTo('App\Lab');
    }

    public function collection_point()
    {
        return $this->belongsTo('App\Collection_point');
    }
}
