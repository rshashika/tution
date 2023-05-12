<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class students_fees extends Model
{
     public function student()
    {
       return $this->belongsTo('App\student');
    }


      public function studentsclass()
        {
            return $this->hasMany(studentin_class::class, 'student_id', 'student_id');
        }


           public function studentstutions()
        {
            return $this->hasMany(studentin_class::class, 'class', 'tution_id');
        }


        public function payment()
        {
            return $this->hasMany(payment::class, 'id', 'payment_id');
        }

        public function class_name()
        {
             return $this->belongsTo(tution::class, 'tution_id','id');
        }

}
