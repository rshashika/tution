<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tution extends Model
{
    public function attendences()
    {
       return $this->hasMany(attendence::class, 'class', 'id');
    }

    public function classinfees()
    {
       return $this->hasMany(students_fees::class, 'id', 'tution_id');
    }

    public function teacher_name()
    {

      // return $this->hasMany(teacher::class, 'id', 'teacher');
      return $this->belongsTo(teacher::class, 'teacher', 'id');
    }


    public function tute_class()
        {
             return $this->hasMany(tute::class, 'tution_id','id');
            // return $this->belongsTo(tute::class, 'id', 'tution_id');
        }
}
