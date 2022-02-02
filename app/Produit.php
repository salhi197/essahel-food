<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Produit extends Model
{
    public function getTicketToday()
    {
        $tickets = Ticket::whereDate('created_at', Carbon::today())->where('id_produit',$this->id)->get();
        $nbrTickets = count($tickets); 
        return $nbrTickets;
    }

    public static function getNumber($response)
    {
        $produits = Produit::all();
        $collection = collect();
        foreach($produits as $produit)
        {
            $object = (object) ['id_produit' => $produit->id ,'nbrtickets' => 0];
            foreach($response as $res)
            {
                if($res->id_produit == $produit->id)
                {
                    $object = (object) ['id_produit' => $produit->id ,'nbrtickets' => $res->nbrtickets];                    
                }
            }
            $collection->push($object);
        }
        return $collection;
    }
        
}
