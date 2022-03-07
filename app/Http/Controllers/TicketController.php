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
use Auth;
use Dompdf\Dompdf;
use Carbon\Carbon;

class TicketController  extends Controller
{
    
    public function index()
    {
        $tickets= Ticket::orderBy('created_at', 'desc')->limit(1000)->get();
        $tickets = DB::select("select t.id,t.id_produit,t.created_at,t.updated_at,t.satut,t.num_ticket_produit,t.codebar,t.impression,t.maj ,p.nom  as nom from tickets t,produits p where (p.id=t.id_produit) order by t.created_at desc limit 1000");
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

        $tickets = DB::select("select t.id,t.id_produit,t.created_at,t.updated_at,t.satut,t.num_ticket_produit,t.codebar,t.impression,t.maj ,p.nom  as nom from tickets t,produits p where (p.id=t.id_produit) and ( DATE(t.updated_at)>=DATE('$date_debut') and DATE(t.updated_at)<=DATE('$date_fin') ) order by t.created_at desc");

        return view('tickets.index',compact(
            'tickets',
            'date_debut',
            'date_fin'
        ));
    }

    /**
     * retour normal
     */
    public function retour($livreur)
    {
        $tickets = DB::select("select *,t.id as id_ticket, t.updated_at as pupdated_at,t.created_at as pcreated_at,p.nom from tickets t,produits p where (t.id_produit=p.id) and t.id in (select id_ticket from sorties s where id_livreur=$livreur) and satut='sortie'");
        return view('tickets.retour',compact('tickets','livreur'));
    }

    public function retourner(Request $request)
    {
        
        if(auth()->guard('admin')->check()){$acteur= (Auth::guard('admin')->user()->email);} 
        if(auth()->guard('depot')->check()){$acteur =(Auth::guard('depot')->user()->email);}
        if(auth()->guard('production')->check()){$acteur= (Auth::guard('production')->user()->email);}
        
        
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut = 'retour';
        $ticket->maj = $acteur;
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



    /**
     * 
     *  Retour Prodution
     * 
     * 
     */


    public function retourRecyclage()
    {
        $tickets = Ticket::all();
        return view('tickets.retour-recyclage',compact('tickets'));
    }

    public function retournerRecyclage(Request $request)
    {
        
        if(auth()->guard('admin')->check()){$acteur= (Auth::guard('admin')->user()->email);} 
        if(auth()->guard('depot')->check()){$acteur =(Auth::guard('depot')->user()->email);}
        if(auth()->guard('production')->check()){$acteur= (Auth::guard('production')->user()->email);}
        
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut = 'recyclee';
        $ticket->maj = $acteur;
        $ticket->save();
        return response()->json([
            'ticket'=>$request['ticket']
        ]);
    }     



    public function retourDestruction()
    {
        $tickets = Ticket::all();
        return view('tickets.retour-destruction',compact('tickets'));
    }

    public function retournerDestruction(Request $request)
    {
        
        if(auth()->guard('admin')->check()){$acteur= (Auth::guard('admin')->user()->email);} 
        if(auth()->guard('depot')->check()){$acteur =(Auth::guard('depot')->user()->email);}
        if(auth()->guard('production')->check()){$acteur= (Auth::guard('production')->user()->email);}

        
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut = 'detruit';
        $ticket->maj = $acteur;
        $ticket->save();
        return response()->json([
            'ticket'=>$request['ticket']
        ]);
    }     




    public function detacher($livreur)
    {
        $tickets = DB::select("select *,t.id as id_ticket, t.updated_at as pupdated_at,t.created_at as pcreated_at,p.nom from tickets t,produits p where (t.id_produit=p.id) and t.id in (select id_ticket from sorties s where id_livreur=$livreur) and satut='sortie'");
        return view('tickets.detacher',compact('tickets','livreur'));
    }

    public function enlever(Request $request)
    {

        if(auth()->guard('admin')->check()){$acteur= (Auth::guard('admin')->user()->email);} 
        if(auth()->guard('depot')->check()){$acteur =(Auth::guard('depot')->user()->email);}
        if(auth()->guard('production')->check()){$acteur= (Auth::guard('production')->user()->email);}
        
        
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut = 'au_depot';
        $ticket->maj = $acteur;
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
        $tickets = Ticket::where('satut', '<>', 'sortie')
//            ->orWhere('satut', '=', '0')
        //    ->orWhere('satut', '=', 'retour')
            ->orderBy('created_at','desc')
            ->get();
        return view('tickets.affecter',compact('tickets','_livreur'));
    }
    

    public function assigner(Request $request)
    {
        
        if(auth()->guard('admin')->check()){$acteur= (Auth::guard('admin')->user()->email);} 
        if(auth()->guard('depot')->check()){$acteur =(Auth::guard('depot')->user()->email);}
        if(auth()->guard('production')->check()){$acteur= (Auth::guard('production')->user()->email);}
        
        $id_ticket = $request['ticket'];
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut = 'sortie';
        $ticket->maj = $acteur;
        $ticket->updated_at=date("Y-m-d H:i:s");
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
        $tickets = DB::select("select * from tickets t where ( DATE(t.updated_at)>=DATE('$date_debut') and DATE(t.updated_at)<=DATE('$date_fin') ) and t.id in (select id_ticket from sorties s where id_livreur=$id_livreur)");
        $livreur=Livreur::find($id_livreur);
        $produits_qte = DB::select("select l.id,l.name,l.prenom,p.nom,count(t.id) as nb_ticket from livreurs l,tickets t,sorties s,produits p where (l.id=s.id_livreur) and(l.id = '$id_livreur') and (t.id=s.id_ticket) and (t.id_produit=p.id) /*and (satut='sortie')*/ and (DATE(t.updated_at) between '$date_debut' and '$date_fin' ) group by l.id,l.name,l.prenom,p.nom ");
        return view('livreurs.filter',compact(
            'tickets',
            'livreur',
            'id_livreur',
            'produits_qte',
            'date_debut',
            'date_fin'
        ));
    }

    


    public function vers_depot()
    {
        $tickets = Ticket::where('satut', '=', '0')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at','desc')
            ->get();
            
        return view('tickets.vers_depot',compact('tickets'));

    }

    public function vers_depot_action(Request $request)
    {

        if(auth()->guard('admin')->check()){$acteur= (Auth::guard('admin')->user()->email);} 
        if(auth()->guard('depot')->check()){$acteur =(Auth::guard('depot')->user()->email);}
        if(auth()->guard('production')->check()){$acteur= (Auth::guard('production')->user()->email);}
        
        
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut= "vers_depot";
        $ticket->maj = $acteur;
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
        
        if(auth()->guard('admin')->check()){$acteur= (Auth::guard('admin')->user()->email);} 
        if(auth()->guard('depot')->check()){$acteur =(Auth::guard('depot')->user()->email);}
        if(auth()->guard('production')->check()){$acteur= (Auth::guard('production')->user()->email);}

        
        $ticket = Ticket::find($request['ticket']);
        $ticket->satut= "au_depot";
        $ticket->maj= $acteur;
        $ticket->save();
        return response()->json([
            'ticket'=>$request['ticket']
        ]);
    }

    public function bl($ticket)
    {
        $ticket = Ticket::find($ticket);
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions(); 
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);
        $html = Template::bl($ticket);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $current = date('Y-m-d');
        $file = "bonlivraison_".$current;
        $dompdf->stream("$file", array('Attachment'=>0));
    }
}

