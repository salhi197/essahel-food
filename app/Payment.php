<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{    
    
    protected $fillable = [
        'montant',
        'achat',
        'produit',
        'quantite',
        'commnetaire',
        'payment'
    ];
}
