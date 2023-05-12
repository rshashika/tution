<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tute extends Model
{
    public function tution_name()
    {
      return $this->belongsTo(tution::class, 'tution_id', 'id');
      // return $this->hasMany(tution::class, 'id', 'tution_id');
    }
}
