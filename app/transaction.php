<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    public function student()
    {
        return $this->belongsTo(student::Class, 'std_id');
    }
}
