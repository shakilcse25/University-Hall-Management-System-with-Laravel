<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class createmonth_calculation extends Model
{
    public function monthcalc()
    {
        return $this->hasMany(monthly_calculation::Class, 'month_id');
    }
}
