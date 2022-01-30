<?php

namespace App;

use App\Wilaya;
use App\Commune;
use App\Commande;
    
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Livreur extends Authenticatable
{
    use Notifiable;

    public function getWilaya()
    {
        return Wilaya::where('id',$this->wilaya_id)->first()['name'];
    }
   
    public function getCommune()
    {
        return Commune::where('id',$this->wilaya_id)->first()['name'];
    }

    public function NbrCourse()
    {
        return Commande::where('livreur_id',$this->id)->count();
    }

    protected $guard = 'livreur';

    protected $fillable = [
        'name', 'email', 'password','paswword_text'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function commandes()
    {
        return $this->hasMany('App\Commande');
    }
}
