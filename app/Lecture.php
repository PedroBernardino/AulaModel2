<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Lecture extends Model
{
    public function User(){
       return $this->belongsToMany('App\User');
    }


    /**
     * Adiciona novos usuários à palestra
     *
     * @param  array  $user_ids
     * @return boolean
     */
    public function newUsers($user_ids){
        foreach ($user_ids as $user_id) {
            $user = User::findOrFail($user_id);
//          dd($this, $lecture, $lecture_id);
            $this->users()->attach($user);
        }
        return true;
    }


    /**
     * Remove usuários da palestra
     *
     * @param  array  $user_ids
     * @return boolean
     */
    public function removeUsers($user_ids){
        foreach ($user_ids as $user_id) {
            $user = User::findOrFail($user_id);
//          dd($this, $lecture, $lecture_id);
            $this->users()->detach($user);
        }
        return true;
    }

}
