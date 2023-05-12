<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attendence extends Model
{
    public function class()
    {
       return $this->belongsTo('App\tution');
    }
}
