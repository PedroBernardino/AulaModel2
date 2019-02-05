<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    public function clients(){
       return $this->belongsToMany('App\Client');
    }

    public function newClient($client_id){

        $client = Lecture::findOrFail($client_id);
//        dd($this, $lecture, $lecture_id);

        $this->clients()->attach($client);

        return true;
    }

}
