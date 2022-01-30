<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'nom',
        'catégorie',
        'quantite',
        'prix' ,   
        'budget',
        'fournisseur',
        'fournisseur_id',
        'description',
        'state',
        'marge_clicntic',
        'marge_boutique',
        'marge_commercial',
        'marge_freelancer',
        'color',
    ];

}
