<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Room;
use App\Lecture;

class Client extends Model
{
    //exemplo de serialization
    protected $hidden = ['email'];

    //exemplo de acessor
    /*public function getNameAttribute($value)
    {
        return strtolower($value);
    }*/


    //exemplo de acessor
    public function getAllInfoAttribute()
    {
        return "{$this->name} - {$this->email}";
    }

    protected $appends = ['all_info'];


    //exemplo de mutator
    /*public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }*/


    //reserva o quarto ou falha
    public function insertRoom($room_id){

        $room = Room::findOrFail($room_id);

        if($room->vacancies_remaining <= 0){
            return false;
        } else {

            $this->room_id = $room->id;
            $this->save();

            $room->vacancies_remaining -= 1;
            $room->save();

            return true;
        }
    }


    //retorna o quarto do cidadao
    public function room(){
        return $this->belongsTo('App\Room');
    }

    //retorna as atividades do cidadao
    public function lectures(){
        return $this->belongsToMany('App\Lecture');
    }



}
