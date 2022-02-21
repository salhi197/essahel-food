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

    public static function extract_date_and_number($array)
    {

        $ret=[];

        $created_at = [];
        $i=0;
        $numbers = [];

        foreach ($array as $element) 
        {

            $created_at[$i] = $element->created_at;
            $numbers[$i] = $element->nb_ticket;
            $i++;
            // code...
        }

        $ret['date'] = $created_at;
        $ret['numbers'] = $numbers;
        
        return (object)$ret;
        // code...
    }

    public function getLivreur()
    {
        $sortie = Sortie::where('id_livreur',$this->id)->orderBy('created_at', 'desc')->first();
        $livreur = null;
        if($sortie!=null)
            $livreur = Livreur::find($sortie->id_livreur);
        return $livreur;
        
    }
}
