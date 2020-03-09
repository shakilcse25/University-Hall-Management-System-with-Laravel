<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_meal extends Model
{
    public $timestamps = false;
    public function emp()
    {
        return $this->belongsTo(employee::Class, 'employee_id');
    }
}
