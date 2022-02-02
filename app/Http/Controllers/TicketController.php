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

    public function affecter($livreur)
    {
        $_livreur = $livreur;
        $tickets = Ticket::where('satut', '=', 'au_depot')->orWhere('satut', '=', '0')->orWhere('satut', '=', 'vers_depot')->orderBy('created_at','desc')->get();
        return view('tickets.affecter',compact('tickets','_livreur'));
    }
    

    public function assigner(Request $request)
    {
        $id_ticket = $request['ticket'];
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut = 'sortie';
        $ticket->save();
        
        $nbticket = DB::select("select statut_livraison as nbticket from sortie where id_ticket=$id_ticket and updated_at=CURDATE()");
        if(count($nbticket)>0){
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

