<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    public function room()
    {
        return $this->belongsTo(room::Class,'room_id');
    }

    public function meal_student()
    {
        return $this->hasMany(Meal_student::Class, 'student_id');
    }

    public function monthly_cal()
    {
        return $this->hasMany(monthly_calculation::Class, 'std_id');
    }
    public function fillvacent()
    {
        return $this->hasMany(Fillvacent::Class, 'student_id');
    }
}
