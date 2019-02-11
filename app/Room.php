<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{


    public function hotel(){
        return $this->belongsTo('App\Hotel');
    }

    public function  users(){
        return $this->hasMany('App\User');
    }

    public function newUsers($user_ids){
        if($this->vacancies_remaining <= sizeof($user_ids)){
            return 'vagas insuficientes';
        } else {

            foreach ($user_ids as $user_id) {
                $user = User::findOrFail($user_id);
                $user->room_id = $this->id;
                $user->save();

                $this->vacancies_remaining -= 1;
                $this->save();
            }

            return true;
        }

    }

    public function removeUsers($user_ids){

        foreach ($user_ids as $user_id) {
            $user = User::findOrFail($user_id);
            $user->room_id = null;
            $user->save();

            $this->vacancies_remaining += 1;
            $this->save();
        }

        return true;

    }

}
