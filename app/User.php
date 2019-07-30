<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Room;

use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'//, 'is_admin'  comentado só por fins educativos não é
                                    // legal permitir q usuários saibam que esse atributo existe
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //exemplo de acessor
    /*public function getNameAttribute($value)
    {
        return strtolower($value);
    }*/

    //exemplo de acessor para formatação de vários atributos
    /*public function getAllInfoAttribute()
    {
        return "{$this->name} - {$this->email}";
    }
    protected $appends = ['all_info'];*/

    //exemplo de mutator
    /*public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }*/


    public function creditCard(){
        return $this->hasOne('App\CreditCard');
    }

    //retorna o quarto
    public function room(){
        return $this->belongsTo('App\Room');
    }

    //reserva o quarto ou falha
    public function reserveRoom($room_id){

        $this->room_id = $room_id;
        $this->save();
        return true;
    }

    public function removeRoom(){

        $this->room_id = null;
        $this->save();
        return true;
    }


    //retorna as atividades do cidadao
    public function lectures(){
        return $this->belongsToMany('App\Lecture');
    }

    //se inscreve em uma palestra
    public function subscribeInLecture($lecture_id)
    {
        $this->lectures()->attach($lecture_id);
        return true;
    }

    //se desinscreve de uma palestra
    public function unsubscribeInLecture($lecture_id)
    {
        $this->lectures()->detach($lecture_id);
        return true;
    }

}
