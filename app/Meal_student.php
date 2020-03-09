<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal_student extends Model
{
    public $timestamps = false;
    public function meal()
    {
        return $this->belongsTo(Meal::Class, 'meal_id');
    }

    public function student()
    {
        return $this->belongsTo(student::Class, 'student_id');
    }
}
