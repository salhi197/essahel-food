<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Commune;
use App\Http\Requests\StoreLivreur;
use App\Livreur;
use App\Wilaya;
use Illuminate\Http\Request;
use Auth;
use Hash;
use DB;
use Illuminate\Console\Command;

class LivreurController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:admin');
        // $this->middleware('auth:livreur');
    }


    public function indexAjax()
    {
        if($request->ajax()){
            $livreurs = Livreur::all();    
            $response = array(
                'livreurs' => $livreurs,
                'msg' => 'changement de la liste des livreurs',
            );
            return Response::json($response);  // <<<<<<<<< see this line    
        }
    }


    public function journal($livreur)
    {
        $wheres = "";
        $index = 0;
        $_livreur = "";
        $debut_entre = "";
        $fin_entre ="";
        $creance="";
        $livreurs = Livreur::all();
        $wheres =$wheres."where livreur_id=$livreur ";                
        $sql = "select * from commandes ";
        $sql = $sql.$wheres;
        $sql = $sql.'and (state="Livree" or state="confirmer" or state="non abouti") and creance_livreur="non solder"';
        $commandes=DB::select(DB::raw($sql));
        $ValeurRapporte = 0;
        $RapporteAuLsRapide=0;
        $LivreurMontant = 0;
        $livraison=0;
        foreach ($commandes as $key => $commande) {
            $c = Commande::find($commande->id);
            if($c->state == 'Livree' AND $c->creance_livreur== 'non solder')
            {
                $LivreurMontant  = $LivreurMontant + Commande::getWilayaLivreurTarif($commande->wilaya);
                $ValeurRapporte = $ValeurRapporte+$commande->total;    
            }
            if($c->state== 'non abouti' AND $c->creance_livreur== 'non solder')
            {
                $LivreurMontant  = $LivreurMontant + Commande::getWilayaLivreurNonAboutiTarif($commande->wilaya);
            }
        }
        $RapporteAuLsRapide = $livraison+$ValeurRapporte;
        return view('livreurs.journal',compact('livreurs','commandes','_livreur','LivreurMontant','debut_entre','fin_entre','creance','livraison','ValeurRapporte','RapporteAuLsRapide'));     

        
    }



    public function index()
    {
        if(Auth::guard('livreur')->user()){
            $livreur = Auth::guard('livreur')->user();
            //$livreurs = Livreur::all();
            $commandes = Commande::where(['state'=>'en attente','livreur'=>null])->orWhere('state',"annule")->get();                   
            return view('livreurs.my-index',compact('commandes'));            
            }
            if(Auth::guard('admin')->user()){
                $communes = Commune::all();
                $wilayas = Wilaya::all();
                $livreurs = Livreur::all();//where('id', '>', 0)->paginate(10);
                return view('livreurs.index',compact('livreurs','communes','wilayas'));
        
            }
            return redirect()->route('login');
    }

    public function create()
    {
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        return view('livreur.create',compact('wilayas','communes'));
    }

    public function maList()
    {
        if(Auth::guard('livreur')->user()){
            $livreur = Auth::guard('livreur')->user();
            $commandes = Commande::where(['livreur_id'=>$livreur->id,'state'=>'accepte'])->get(); 
            return view('livreurs.mes-livraisons',compact('commandes'));                
        }else{
            return redirect()->route('login');//->with('success', 'pub changé avec succés ');                   
        }

}
    public function store(Request $request)
    {
        // $validated = $request->validated();
        $livreur = new Livreur();
        $livreur->name= $request->get('name');
        $livreur->prenom= $request->get('prenom');
        $livreur->email= $request->get('email');
        $livreur->telephone= $request->get('telephone');
        $livreur->adress= $request->get('adress');
        $livreur->birth= $request->get('birth');
        $livreur->password=Hash::make($request->get('password'));
        $livreur->password_text= $request->get('password');
        $livreur->wilaya_id = $request->get('wilaya_id');
        $livreur->commune_id = $request->get('commune_id');
        if ($request->hasFile('identite')) {
            $livreur->identite = $request->file('identite')->store(
                'livreurs/identite',
                'public'
            );
        }

        $livreur->save();
        return redirect()->route('livreur.index')->with('success', 'livreur inséré avec succés ');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function destroy($id_livreur)
    {
            $c = Livreur::find($id_livreur);
            $c->delete();
            return redirect()->route('livreur.index')->with('success', 'le livreur a été supprimé ');     
    }

    public function extraFilter(Request $request,$livreur_id)
    {
        $result = Commande::query();
        $date_debut = "";
        $date_fin = "";

        if (!empty($request['date_debut'])) {
            $date_debut = $request['date_debut'];
            $result = $result->whereDate('created_at', '>=', $request['date_debut']);
        }

        if (!empty($request['date_fin'])) {
            $date_fin = $request['date_fin'];
            $result = $result->whereDate('created_at', '<=', $request['date_fin']);
        }
        $result = $result->where('livreur_id','=',$livreur_id);
        $result = $result->where('type', '=', 'colier');
        $result = $result->where('state', '<>', 'retour_client');            
        $result = $result->where('state', '<>', 'retour_ls');           
        $result = $result->where('state', '<>', 'retour_ls');          
        $result = $result->where('state', '<>', 'Livree');
        $commandes = $result->get();//->orderBy('sortie','asc');
        $wilayas =Wilaya::all();
        $l=Livreur::find($livreur_id); 
        $livreur = $livreur_id;
        return view('livreurs.filter',compact('commandes',
            'date_debut',
            'date_fin',
        'wilayas','l','livreur_id','livreur'));


    }
    public function filter($id_livreur)
    {
        $livreur = $id_livreur;
        // $commandes = Commande::where('livreur_id',$livreur)->get();
        $commandes = Commande::where([
            ['livreur_id','=',$livreur],
            ['type', '=', 'colier'],
            ['state', '<>', 'retour_client'],            
            ['state', '<>', 'retour_ls'],           
            ['state', '<>', 'retour_ls'],          
            ['state', '<>', 'Livree']
        ])->get();

        $wilayas =Wilaya::all();
        $l=Livreur::find($id_livreur); 
        $livreur_id = $id_livreur;
        $date_debut = "";
        $date_fin = "";
        return view('livreurs.filter',compact('commandes','wilayas','l','livreur','livreur_id',
        'date_debut',
        'date_fin'
    ));
    }


    public function changeState($id_livreur)
    {
        $livreur = Livreur::find($id_livreur);
        $livreur->state = !$livreur->state;

        $livreur->save();
        return redirect()->back()->with(['success' => 'désactivé']);
    }   



    public function edit($livreur)
    {
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $livreur = Livreur::find($livreur);
        return view('livreurs.edit',compact('livreur','wilayas','communes'));
    }

    public function update(Request $request)
    {
        $livreur = Livreur::find($request['livreur_id']);
        $livreur->name= $request->get('nom');
        $livreur->prenom= $request->get('prenom');
        $livreur->telephone = $request->get('telephone');
        $livreur->email = $request->get('email');
        $livreur->wilaya_id = $request->get('wilaya_id');
        $livreur->commune_id = $request->get('commune_id');
        $livreur->adress = $request->get('adress');
        try {
            $livreur->save();
        } catch (\Throwable $th) {
            return redirect()->route('livreur.index')
            ->with('error', 'Modification echoué !');
        }
        return redirect()->route('livreur.index')
            ->with('success', 'modification efféctué !');

    }

   
}
