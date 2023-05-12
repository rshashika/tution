<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class student_tute extends Model
{
     public function tution_name()
    {
      return $this->hasMany(tution::class, 'id', 'tution_id');
    }

     public function student_name()
    {
      return $this->belongsTo(student::class, 'student_id', 'admission_num');
       // return $this->hasMany(tution::class, 'id', 'tution_id');
    }
}
