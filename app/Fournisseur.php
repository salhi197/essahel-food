<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Fournisseur extends Authenticatable
{
 
    protected $guard = 'fournisseur';

    public function NbrColiers()
    {
        $nbrColiers = Commande::where([
            ['fournisseur_id','=',$this->id],
            ['type', '=', 'arrive'],
        ])->get()->count();

        // $nbrColiers = Commande::where('fournisseur_id',$this->id)->get()->count();
        return $nbrColiers;
    }

    protected $fillable = [
        'nom_prenom',
        'telephone',
        'num_service',
        'gestion_stock',
        'confirmation_telephonique',
        'email',
        'wilaya',
        'password',
        'password_text',
        'commune_id',
        'adress',
    ];
}
