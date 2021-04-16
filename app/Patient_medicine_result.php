<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient_medicine_result extends Model
{
	public function test_categories()
    {
        return $this->belongsTo('App\Test_category' , 'test_category_id' , 'id');
    }
}
