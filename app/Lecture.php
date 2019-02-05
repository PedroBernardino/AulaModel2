<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Client;

class Lecture extends Model
{
    public function clients(){
       return $this->belongsToMany('App\Client');
    }

    public function newClient($client_id){

        $client = Client::findOrFail($client_id);
//        dd($this, $lecture, $lecture_id);

        $this->clients()->attach($client);

        return true;
    }

    public function removeClient($client_id){

        $client = Client::findOrFail($client_id);
//        dd($this, $lecture, $lecture_id);

        $this->clients()->detach($client);

        return true;
    }

}
