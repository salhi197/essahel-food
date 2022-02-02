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
}
