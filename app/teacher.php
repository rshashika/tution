<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
    public function class_name()
        {
             // return $this->belongsTo(tution::class, 'id','teacher');
            return $this->hasMany(tution::class, 'teacher', 'id');
        }
}
