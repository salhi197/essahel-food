<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use App\Wilaya;
use App\Template;
use App\Livreur;
use App\Sortie;
use App\Retour;
use App\Ticket;
use DB;
use Dompdf\Dompdf;
use Carbon\Carbon;

class TicketController  extends Controller
{
    
    public function index()
    {
        $tickets= Ticket::orderBy('created_at', 'desc')->limit(300)->get();
        $nbrtickets = count(Ticket::all());

        $date_debut = date('Y-m-d');
        // date($request['date_debut'],'Y-m-d');
        $date_fin = date('Y-m-d');
        return view('tickets.index',compact('tickets',
        'date_debut',
        'date_fin' ,
        'nbrtickets'
        ));
    }

    public function filterExtra(Request $request)
    {        
        $date_debut = Carbon::parse($request['date_debut'])->format('Y-m-d');
        $date_fin = Carbon::parse($request['date_fin'])->format('Y-m-d');
        // $tickets = DB::select("select * from tickets t where ( DATE(t.created_at)>=DATE('$date_debut') and DATE(t.created_at)<=DATE('$date_fin') )");
        $tickets = DB::select("select t.id,t.created_at,t.updated_at,t.satut,t.num_ticket_produit,t.codebar ,p.nom  as nom from tickets t,produits p where (p.id=t.id_produit) and ( DATE(t.created_at)>=DATE('$date_debut') and DATE(t.created_at)<=DATE('$date_fin') )");
        return view('tickets.index',compact(
            'tickets',
            'date_debut',
            'date_fin'
        ));
    }
    public function retour($livreur)
    {
        $tickets = DB::select("select *,t.id as id_ticket, t.updated_at as pupdated_at,t.created_at as pcreated_at,p.nom from tickets t,produits p where (t.id_produit=p.id) and t.id in (select id_ticket from sorties s where id_livreur=$livreur) and satut='sortie'");
        return view('tickets.retour',compact('tickets','livreur'));
    }

    public function retourner(Request $request)
    {
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut = 'retour';
        $ticket->save();
        /**
         * insérer retour
         */
        $retour  = new Retour();
        $retour->id_ticket = $request['ticket'];
        $retour->id_livreur = $request['livreur'];
        $retour->id_client = 1;
        $retour->prix_vente = 100;        
        $retour->save();    
        return response()->json([
            'ticket'=>$request['ticket'],
            'livreur'=>$request['livreur'],
        ]);
    }


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
           ->orWhere('satut', '=', 'retour')
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

    public function filter(Request $request,$id_livreur)
    {
        $date_debut = Carbon::parse($request['date_debut'])->format('Y-m-d');
        // date($request['date_debut'],'Y-m-d');
        $date_fin = Carbon::parse($request['date_fin'])->format('Y-m-d');
        // date($request['date_fin'],'Y-m-d');  
        $tickets = DB::select("select * from tickets t where ( DATE(t.created_at)>=DATE('$date_debut') and DATE(t.created_at)<=DATE('$date_fin') ) and t.id in (select id_ticket from sorties s where id_livreur=$id_livreur)");
        $livreur=Livreur::find($id_livreur);
        return view('livreurs.filter',compact(
            'tickets',
            'livreur',
            'id_livreur',
            'date_debut',
            'date_fin'
        ));
    }

    


    public function vers_depot()
    {
        $tickets = Ticket::where('satut', '=', '0')
            ->orderBy('created_at','desc')
            ->get();
        return view('tickets.vers_depot',compact('tickets'));

    }

    public function vers_depot_action(Request $request)
    {
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut= "vers_depot";
        $ticket->save();
        return response()->json([
            'ticket'=>$request['ticket']
        ]);
    }


    public function au_depot()
    {
        $tickets = Ticket::where('satut', '=', 'vers_depot')
            ->orderBy('created_at','desc')
            ->get();
        return view('tickets.au_depot',compact('tickets'));

    }

    public function au_depot_action(Request $request)
    {
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut= "au_depot";
        $ticket->save();
        return response()->json([
            'ticket'=>$request['ticket']
        ]);
    }



}

