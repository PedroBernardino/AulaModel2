<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    public function rooms(){
        return $this->hasMany('App\Room');
    }

    public function vacanciesRemaining(){

        $rooms = $this->rooms;
        $vacancies = 0;

        foreach ($rooms as $room){
            $vacancies += $room->vacancies_remaining;
        }

        return $vacancies;
    }
}
