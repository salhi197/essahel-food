<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    
    protected $fillable = [
        'produits',
        'reste',
        'total',
        'state',
        'fournisseur',
        'fournisseur_id',
        'date_achat',
    ];
    public function getWilaya()
    {
        return Wilaya::where('id',$this->wilaya)->first()['name'];
    }
   
    public function getCommune()
    {
        return Commune::where('id',$this->commune)->first()['name'];
    }

}
