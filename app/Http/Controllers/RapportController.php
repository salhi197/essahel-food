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

class RapportController  extends Controller
{

    public function rapport()
    {
        $produits = Produit::all();
        // $date_debut = $request['date_debut'];
        // $date_fin = $request['date_fin'];  
        // $nbrTickets = DB::select('select p.id ,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit and (created_at) and satut = vers_depot) group by (p.id) order by id_produit asc ');
        // dd($nbrTickets);

        return view('rapport',compact('produits'));
    }

    public function getScannedTickets(Request $request)
    {      
        
        $date_debut = date($request['date_debut']);
        $date_fin = date($request['date_fin']);  

        $nbrTicketsGenerated = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit and ( DATE(t.created_at)>DATE('$date_debut') and DATE(t.created_at)<DATE('$date_fin') ) and (satut = 0) ) group by (p.id) order by id_produit asc ");
        $nbrTicketsVersDepot = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit and ( DATE(t.updated_at)>DATE('$date_debut') and DATE(t.updated_at)<DATE('$date_fin') ) and (satut = 'vers_depot') ) group by (p.id) order by id_produit asc ");
        $nbrTicketsAuDepot = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit and ( DATE(t.updated_at)>DATE('$date_debut') and DATE(t.updated_at)<DATE('$date_fin') ) and (satut = 'au_depot') ) group by (p.id) order by id_produit asc ");

        return response()->json([
            'nbrTicketsGenerated' => $nbrTicketsGenerated,
            'nbrTicketsVersDepot'=>$nbrTicketsVersDepot,
            'nbrTicketsAuDepot'=>$nbrTicketsAuDepot            
        ]);    
    } 


}

