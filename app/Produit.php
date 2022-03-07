<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Produit extends Model
{
    protected $fillable = [
        'nom', 'reference', 'description','prix_gros','prix_semi_gros','prix_detail','prix_minimum','prix_autre','id_categorie'
    ];
    public function getTicketToday()
    {
        $tickets = Ticket::whereDate('created_at', Carbon::today())->where('id_produit',$this->id)->get();
        $nbrTickets = count($tickets); 
        return $nbrTickets;
    }


    public static function getNomProduit($id_produit)
    {
        $produit = DB::select("select nom from produits where id = '$id_produit' ");
        $produit = $produit[0];
        return $produit->nom;
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
