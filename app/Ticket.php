<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produit;
class Ticket extends Model
{
    public function getProduit()
    {
        $produit = Produit::find($this->id_produit);
        return $produit;
    }
}
