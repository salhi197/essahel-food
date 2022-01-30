<?php

namespace App;
use App\Fournisseur;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{    
    protected $fillable = [
        'produit_id',
        'produit',
        'quantite',
        'operation',
    ];
    public function fournisseur()
    {
        return Fournisseur::find($this->fournisseur_id);
    }
}
