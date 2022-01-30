<?php

namespace App\Http\Controllers;

use App\Type;
use App\Commande;
use App\Commune;
use App\Wilaya;
use App\Livreur;
use App\Produit;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

class CommandeController extends Controller
{


    
    public function index()
    {
        $commandes = DB::table('commandes')->orderBy('id', 'DESC')->paginate(5);
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $produits =Produit::all();
        $livreurs =Livreur::all();
        return view('commandes.index',compact('commandes','wilayas','communes','produits','livreurs'));
    }


    public function show($id_commande){
        $commande =  Commande::find($id_commande);
        return view('commandes.view',compact('commande'));
    }

    public function accepter($id_commande){
        $livreur = Auth::guard('livreur')->user();
        //$livreurs = Livreur::all();
        $commande = Commande::find($id_commande);
        $type = Type::where('label',$commande->command_express)->first();
        $commande->state = 'accepte';
        $commande->credit_livreur = $commande->prix + $commande->prix_livraison - $type['commission'];
        $commande->accepte = Carbon::now();
        $commande->livreur_id = $livreur->id;
        $commande->livreur = json_encode($livreur,true);
        $commande->save();
        return redirect()->route('livreur.index')->with('success', 'la commande vous a été accordée ');           
    }


    public function livrer($id_commande){
        $livreur = Auth::guard('livreur')->user();
        //$livreurs = Livreur::all();
        $commande = Commande::find($id_commande);
        $commande->state = 'livree';
        $commande->livree = Carbon::now();
        $commande->livreur_id = $livreur->id;
        $commande->livreur = json_encode($livreur,true);
        $commande->save();
        return redirect()->route('livreur.index')->with('success', 'la commande a été marquée comme livrée ');           
    }


    public function display($id_commande){
        $commande =  Commande::find($id_commande);
        return view('commandes.display',compact('commande'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $livreurs =Livreur::all();
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $produits = Produit::all();
        $types = Type::all();
        
        return view('commandes.create',compact('wilayas','communes','produits','livreurs','types'));
    }

    public function search(Request $request)
    {
        $result = Commande::query();
        if (!empty($request['id_commande'])) {
            $result = $result->where('id',$request['id_commande']);
        }
        
        if (!empty($request['nom_client'])) {
            $result = $result->where('nom_client', 'like', '%'.$request['nom_client'].'%');
        }
        
        if (!empty($request['type_livraison'])) {
            $result = $result->where('command_express', $request['type_livraison']);
        }
        
        if (!empty($request['telephone'])) {
            $result = $result->where('telephone', $request['telephone']);
        }
        if (!empty($request['telephone'])) {
            $result = $result->where('telephone', $request['telephone']);
        }
        if (!empty($request['wilaya_id'])) {
            $result = $result->where('wilaya', $request['wilaya_id']);
        }
        if (!empty($request['commune_id'])) {
            $result = $result->where('commune', $request['commune_id']);
        }
        $commandes = $result->get();
        return view('commandes.results',compact('commandes'));
    }

    /** 
     * 
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $produits = array();
        $total_produit = 0;
        $total= 0;
        $acteur = "";
        $id_acteur = 0;
        if(auth()->guard('freelancer')->check()){
            $id_acteur = auth()->guard('freelancer')->user()->id;;
            $acteur = 'freelancer';
        }
        if(auth()->guard('admin')->check()){
            $id_acteur = auth()->guard('admin')->user()->id;;
            $acteur = 'admin';
        }          
        if(Auth::user()){
            $id_acteur = Auth::user()->id;
            $acteur = 'commercial';
        }
        
        
        foreach ($request['dynamic_form']['dynamic_form'] as $array) {
            $produit_json = json_decode($array['produit'], true);
            $produit  = Produit::find($produit_json['id']);
            $qteOld = $produit->quantite;
            $qteNew = $qteOld - $array['quantite'];  
            $produit->quantite = $qteNew;
            $produit->save();
            $total_produit = $produit['quantite']*$produit['prix_vente'];
            $total = $total + $total_produit;

            $produit_json['quantite'] = $array['quantite'];
            array_push($produits,$produit_json);
        }    
        $produits = json_encode($produits);
        $livreur = json_decode($request->get('livreur'), true);
        $commande = new Commande([
            'quantite'=>$request->get('quantite'),
            'prix'=>$request->get('prix'),
            'prix_livraison'=>$request->get('prix_livraison'),
            'command_express'=>$request->get('comand_express'),
            'nom_client'=>$request->get('nom_client'),
            'telephone'=>$request->get('telephone'),
            'wilaya'=>$request->get('wilaya_id'),
            'commune'=>$request->get('commune_id'),
            'note'=>$request->get('note'),
            'adress'=>$request->get('adress') ?? '',
            'state'=>'en attente',
            'livreur'=>$request->get('livreur'),
            'livreur_id'=>$livreur['id'],
            'date_livraison'=>$request->get('date_livraison'),
            'acteur'=>$acteur,
            'id_acteur'=>$id_acteur,
    

        ]);
        $commande->produit = $produits; 
        $commande->total = $total; 
        
        $commande->save();

        return redirect()->route('home')->with('success', 'commande inséré avec succés inserted successfuly ');
    }

    /**
     * Display the specified resource.
     *
     * 
     * @param  \App\Commande  $commande
     *  @return \Illuminate\Http\Response
     */
    public function prendre($id_commande)
    {
        if(Auth::guard('livreur')->user()){
            $livreur = Auth::guard('livreur')->user();
            //$livreurs = Livreur::all();
            $commande = Commande::find($id_commande);
            $commande->state = 'accepte';
            $commande->accepte = Carbon::now();
            $commande->livreur_id = $livreur->id;
            
            $commande->save();
            return redirect()->route('livreur.index')->with('success', 'la commande vous a été accordée ');           
            }        
    }

    public function consulter($id_commande)
    {
            $livreur = Auth::guard('livreur')->user();
            $commande = Commande::find($id_commande);
            return view('commandes.consulter',compact('commande'));
    }

    /**
     * Show the form for editing the specified resource.
     *  
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit($id_commande)
    {
        $livreurs =Livreur::all();
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $produits = Produit::all();
        $types = Type::all();
        $commande = Commande::find($id_commande);
        return view('commandes.edit',compact('commande','wilayas','communes','produits','livreurs','types'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $commande)
    {
        $data = json_decode($request->get('produit'), true);
        
        $commande = new Commande([
            'produit'=>$request->get('produit'),
            'quantite'=>$request->get('quantite'),
            'prix'=>$request->get('prix'),
            'prix_livraison'=>$request->get('prix_livraison'),
            'command_express'=>$request->get('commande_express'),
            'nom_client'=>$request->get('nom_client'),
            'telephone'=>$request->get('telephone'),
            'wilaya'=>$request->get('wilaya'),
            'commune'=>$request->get('commune'),
            'note'=>$request->get('note'),
            'adress'=>$request->get('adress') ?? '',
            'state'=>'en attente',
            'livreur'=>$request->get('livreur'),
            'remise'=>$request->get('remise'),
            
        ]);
        $stack = array();
        if(request('images')){
            foreach($request->file('images') as $image){
                $image = $image->store(
                    'commandes/images',
                    'public'
                );
                array_push($stack,$image);
            }    
        }
        $stack = json_encode($stack);
        $commande->images = $stack; 
        $commande->save();
        return redirect()->route('commande.index')->with('success', 'commande inséré avec succés inserted successfuly ');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_commande)
    {
            $c = Commande::find($id_commande);
            $c->delete();
            return redirect()->route('commande.index')->with('success', 'la commande a été supprimé ');     
    }


    

    public function relancer($id_commande)
    {
            $c = Commande::find($id_commande);
            $c->state = 'en attente';
            $c->save();
            return redirect()->route('livreur.index')->with('success', 'la commande a été relancé ');     
    }
    public function updateState(Request $request)
    {
            $c = Commande::find($request['commande']);
            $c->state = $request['state'];
                switch ($request['state']) {
                    case 'en attente':
                        $c->en_attente = Carbon::now();
                        break;
                    case 'accepte':
                        $c->accepte = Carbon::now();
                        break;
                    case 'expedier':
                        $c->expedier = Carbon::now();
                        break;
                    case 'en attente paiement':
                        $c->en_attente_paiement = Carbon::now();
                        break;
                    case 'livree':
                        $c->livree = Carbon::now();
                        break;
                    }
            $c->state = $request['state'];
            
            $c->save();
            return redirect()->route('home')->with('success', 'la commande a été modifié ');     
    }


    public function updateDate(Request $request)
    {
        $c = Commande::find($request['commande']);
        $c->date_livraison = $request['date_livraison'];                        
        $c->save();
        return redirect()->route('livreur.index')->with('success', 'la commande a été modifié ');     
    }


    public function updateRetour(Request $request)
    {
            $c = Commande::find($request['commande']);
            $produit = Produit::where('id',$request['produit'])->first();            
            $stock = new Stock([
                'produit'=> $produit['id'],
                'date'=>Carbon::now(),
                'entre'=>$request['retour'],
                'sorte'=>0,
                'commande'=>$c->id,
                'retour'=>$request['retour'],
                'vente'=>0,
                'reste'=>((int)$request->get('retour') + $produit['quantite'])
            ]);
            $stock->save();            
            $produit->quantite = $produit->quantite + $request['retour'];
            $produit->save();            
            
            return redirect()->route('commande.index')->with('success', 'la commande a été modifié ');     
    }
    
    public function updateCredit(Request $request)
    {
        $c = Commande::find($request['commande']);
        dd($c);
        $c->credit_livreur = $request['montant_credit'];
        return redirect()->route('home')->with('success', 'la commande a été modifié ');     
    }


    public function annuler(Request $request){
        //$livreurs = Livreur::all();
        $c = Commande::find($request['commande']);
        $c->state = 'annule';
        $c->annule = Carbon::now();
        $c->livreur = null;
        $commande->credit_livreur = 0;


        $c->livreur_id = null;
        $c->motif = $request['motif'];
        $c->save();
        return redirect()->route('livreur.index')->with('success', 'la commande a été  annulé');           
    }


}
