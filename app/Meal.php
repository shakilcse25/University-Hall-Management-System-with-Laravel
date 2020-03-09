<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    public $timestamps = false;
    public function student_meal() {
        return $this->hasMany(Meal_student::Class, 'meal_id');
    }
    public function emp_meal()
    {
        return $this->hasMany(employee_meal::Class, 'meal_id');
    }
}
