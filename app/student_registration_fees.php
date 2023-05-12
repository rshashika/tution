<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class student_registration_fees extends Model
{
    
        public function payment()
        {
            return $this->hasMany(payment::class, 'id', 'payment_id');
        }

        public function category_name()
        {
             return $this->belongsTo(payment_category::class, 'payment_cat','id');
        }
}
