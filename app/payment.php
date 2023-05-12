<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
     public function student_name()
    {
         return $this->belongsTo(student::class, 'student_id', 'admission_num');
    }

      public function classname()
    {
         return $this->belongsTo(tution::class, 'class', 'id');
    }


     public function payment_class()
    {
         return $this->hasMany(students_fees::class,  'payment_id','id');
    }

     public function payment_category()
    {
         return $this->hasMany(student_registration_fees::class,  'payment_id','id');
    }

    //  public function classname()
    // {
    //      return $this->belongsTo(tution::class, 'class', 'id');
    // }


}
