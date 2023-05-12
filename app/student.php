<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    public function studentsfees()
    {
       return $this->hasMany(students_fees::class, 'student_id', 'admission_num');
    }

    public function students_class()
    {
       return $this->hasMany(studentin_class::class, 'student_id', 'admission_num');
    }


    public function payment_students()
    {
       return $this->hasMany(payment::class, 'student_id', 'admission_num');
    }
   

    public function student_tutes()
    {
       return $this->hasMany(student_tute::class, 'student_id', 'admission_num');
    }

}
