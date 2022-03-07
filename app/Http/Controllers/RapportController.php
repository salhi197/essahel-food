<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use App\Wilaya;
use App\Template;
use App\Commande;
use App\Ticket;
use DB;
use App\Produit;
use Carbon\Carbon;

class RapportController  extends Controller
{

    public function rapport()
    {
        $produits = Produit::all();
        
        return view('rapport',compact('produits'));
    }

    public function getScannedTickets(Request $request)
    {      
        
        $date_debut = date($request['date_debut']);
        $date_fin = date($request['date_fin']);  

        $nbrTicketsGenerated = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit and ( DATE(t.created_at)>=DATE('$date_debut') and DATE(t.created_at)<=DATE('$date_fin') ) and (satut = 0) ) group by (p.id) order by id_produit asc ");
        $nbrTicketsVersDepot = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit and ( DATE(t.updated_at)>=DATE('$date_debut') and DATE(t.updated_at)<=DATE('$date_fin') ) and (satut = 'vers_depot') ) group by (p.id) order by id_produit asc ");
        $nbrTicketsAuDepot = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit and ( DATE(t.updated_at)>=DATE('$date_debut') and DATE(t.updated_at)<=DATE('$date_fin') ) and (satut = 'vers_depot') ) group by (p.id) order by id_produit asc ");
        $nbrTicketsSortie = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit and ( DATE(t.updated_at)>=DATE('$date_debut') and DATE(t.updated_at)<=DATE('$date_fin') ) and (satut = 'sortie') ) group by (p.id) order by id_produit asc ");
        $nbrTicketsRetour = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit and ( DATE(t.updated_at)>=DATE('$date_debut') and DATE(t.updated_at)<=DATE('$date_fin') ) and (satut = 'retour') ) group by (p.id) order by id_produit asc ");

        $nbrTicketsGenerated = Produit::getNumber($nbrTicketsGenerated);
        $nbrTicketsVersDepot = Produit::getNumber($nbrTicketsVersDepot);
        $nbrTicketsAuDepot = Produit::getNumber($nbrTicketsAuDepot);
        $nbrTicketsSortie = Produit::getNumber($nbrTicketsSortie);
        $nbrTicketsRetour = Produit::getNumber($nbrTicketsRetour);

        $nbrTicketsVersDepot_outdate = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit /*and ( DATE(t.updated_at)>=DATE('$date_debut') and DATE(t.updated_at)<=DATE('$date_fin') )*/ and (satut = 'vers_depot') ) group by (p.id) order by id_produit asc ");
        $nbrTicketsAuDepot_outdate = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit /*and ( DATE(t.updated_at)>=DATE('$date_debut') and DATE(t.updated_at)<=DATE('$date_fin') )*/ and (satut = 'vers_depot') ) group by (p.id) order by id_produit asc ");
        $nbrTicketsSortie_outdate = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit /*and ( DATE(t.updated_at)>=DATE('$date_debut') and DATE(t.updated_at)<=DATE('$date_fin') )*/ and (satut = 'sortie') ) group by (p.id) order by id_produit asc ");
        $nbrTicketsRetour_outdate = DB::select("select p.id as id_produit,count(t.num_ticket_produit) as nbrtickets from tickets t, produits p where (p.id = t.id_produit /*and ( DATE(t.updated_at)>=DATE('$date_debut') and DATE(t.updated_at)<=DATE('$date_fin') )*/ and (satut = 'retour') ) group by (p.id) order by id_produit asc ");

        $nbrTicketsVersDepot_outdate = Produit::getNumber($nbrTicketsVersDepot_outdate);
        $nbrTicketsAuDepot_outdate = Produit::getNumber($nbrTicketsAuDepot_outdate);
        $nbrTicketsSortie_outdate = Produit::getNumber($nbrTicketsSortie_outdate);
        $nbrTicketsRetour_outdate = Produit::getNumber($nbrTicketsRetour_outdate);


        
        for($i=0;$i<count($nbrTicketsVersDepot_outdate);$i++)
        {
            
            $nbrTicketsAuDepot_outdate[$i]->nbrtickets = $nbrTicketsVersDepot_outdate[$i]->nbrtickets-$nbrTicketsSortie_outdate[$i]->nbrtickets+$nbrTicketsRetour_outdate[$i]->nbrtickets;
            
            //
        }
        return response()->json([
            'nbrTicketsGenerated' => $nbrTicketsGenerated,
            'nbrTicketsVersDepot'=>$nbrTicketsVersDepot,
            'nbrTicketsAuDepot'=>$nbrTicketsAuDepot_outdate,
            'nbrTicketsSortie'=>$nbrTicketsSortie            
        ]);
    } 


}

