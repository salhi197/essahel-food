<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use App\Wilaya;
use App\Template;
use App\Commande;
use App\Produit;
use App\Ticket;
use DB;
use Dompdf\Dompdf;
use Carbon\Carbon;

class TicketController  extends Controller
{

    public function affecter($livreur)
    {
        $_livreur = $livreur;
        $tickets = Ticket::all();//where('type', '=', 'colier')->get();
        return view('tickets.affecter',compact('tickets','_livreur'));
    }
    

}

