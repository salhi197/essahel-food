<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use App\Wilaya;
use App\Template;
use App\Commande;
use App\Sortie;
use App\Ticket;
use DB;
use Dompdf\Dompdf;
use Carbon\Carbon;

class TicketController  extends Controller
{

    public function detacher($livreur)
    {
        $tickets = DB::select("select *,t.id as id_ticket, t.updated_at as pupdated_at,t.created_at as pcreated_at,p.nom from tickets t,produits p where (t.id_produit=p.id) and t.id in (select id_ticket from sorties s where id_livreur=$livreur) and satut='sortie'");
        return view('tickets.detacher',compact('tickets','livreur'));
    }

    public function enlever(Request $request)
    {
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut = 'au_depot';
        $ticket->save();
        Sortie::where('id_ticket',$ticket->id)->first()->delete();
        return response()->json([
            'ticket'=>$request['ticket'],
            'livreur'=>$request['livreur'],

        ]);

    }


    public function affecter($livreur)
    {
        $_livreur = $livreur;
        $tickets = Ticket::where('satut', '=', 'au_depot')
//            ->orWhere('satut', '=', '0')
//            ->orWhere('satut', '=', 'vers_depot')
            ->orderBy('created_at','desc')
            ->get();
        return view('tickets.affecter',compact('tickets','_livreur'));
    }
    

    public function assigner(Request $request)
    {
        $id_ticket = $request['ticket'];
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut = 'sortie';
        $ticket->save();
        
        $nbticket = DB::select("select statut_livraison as nbticket from sorties where id_ticket=$id_ticket and date(updated_at)=CURDATE()");
        if(count($nbticket)==0){
            $sortie  = new Sortie();
            $sortie->id_ticket = $request['ticket'];
            $sortie->id_livreur = $request['livreur'];
            $sortie->id_client = 1;
            $sortie->prix_vente = 100;        
            $sortie->save();    
        }
        
        return response()->json([
            'ticket'=>$request['ticket'],
            'livreur'=>$request['livreur'],
                        
        ]);    
    }


}

