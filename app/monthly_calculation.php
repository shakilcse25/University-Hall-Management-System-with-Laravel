<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class monthly_calculation extends Model
{
    public function student() {
        return $this->belongsTo(student::Class, 'std_id');
    }

    public function month()
    {
        return $this->belongsTo(createmonth_calculation::Class, 'month_id');
    }
}
