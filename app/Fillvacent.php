<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fillvacent extends Model
{
    public function student()
    {
        return $this->belongsTo(student::Class, 'student_id');
    }
}
