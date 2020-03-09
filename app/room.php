<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    public function activestudents()
    {
        return $this->hasMany(student::Class,'room_id')->where('status',1);
    }
    public function inactivestudents()
    {
        return $this->hasMany(student::Class, 'room_id')->where('status', 0);
    }
    public function allstudents()
    {
        return $this->hasMany(student::Class, 'room_id');
    }
}
