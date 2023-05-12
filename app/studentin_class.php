<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class studentin_class extends Model
{
    public function student()
    {
       return $this->belongsTo('App\student');
    }

     public function studentsfeeses()
    {
       return $this->belongsTo(students_fees::class, 'student_id', 'student_id');
    }


     public function studentsclasses()
    {
       return $this->belongsTo(students_fees::class, 'class', 'tution_id');
    }


    public function classname()
    {
         return $this->belongsTo(tution::class, 'class', 'id');
    }


    public function studentname()
    {
       return $this->belongsTo(student::class, 'student_id', 'admission_num');
    }

}
