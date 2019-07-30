<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Lecture extends Model
{
    public function users(){
       return $this->belongsToMany('App\User');
    }


}
