<?php

namespace App\Http\Controllers;

use App\Type;
use App\Commande;
use App\Commune;
use App\Stock;
use App\Fournisseur;
use App\Wilaya;
use App\Payment;

use App\Livreur;
use App\Produit;
use App\Achat;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

class AchatController extends Controller
{


    
    public function index()
    {
        $fournisseurs =Fournisseur::all();
        $achats = DB::table('achats')->orderBy('id', 'DESC')->paginate(5);
        return view('achats.index',compact('achats','fournisseurs'));
    }


    public function facture($achat){
        $achat =  Achat::find($achat);
        $payments =Payment::where('achat',$achat->id)->get();
        $payed = DB::table("payments")->where('achat',$achat->id)->get()->sum("montant");
        $debt  = $achat->total - $payed ;
        return view('achats.view',compact('debt','payments','achat','payed'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fournisseurs =Fournisseur::all();
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $produits = Produit::all();        
        return view('achats.create',compact('wilayas','communes','produits','fournisseurs'));
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
        foreach ($request['dynamic_form']['dynamic_form'] as $array) {
            $produit_json = json_decode($array['produit'], true);
            $produit  = Produit::find($produit_json['id']);
            $qteOld = $produit->quantite;
            $qteNew = $qteOld + $array['quantite'];  
            $produit->quantite = $qteNew;
            $produit->save();
            $total_produit = $array['quantite']*$array['prix']; 
            $total = $total + $total_produit;

            $produit_json['quantite'] = $array['quantite'];
            $produit_json['prix_vente'] = $array['prix'];

             array_push($produits,$produit_json);

             $stock = new  Stock();
             $stock->produit = $array['produit'];
             $stock->quantite = $array['quantite'];
             $stock->operation = 'entré';
             $stock->save();
 
        }    
        $produits = json_encode($produits);
        $fournisseur = json_decode($request->get('fournisseur'), true);
        $achat = new Achat([
            'state'=>$request['state'],
            'fournisseur'=>$request->get('fournisseur'),
            'fournisseur_id'=>$fournisseur['id'],            
            'date_achat'=>$request->get('date_achat'),
        ]);
        $achat->produits = $produits; 
        $achat->reste = $produits; 
        $achat->total = $total; 
        
        $achat->save();

        return redirect()->route('achat.index')->with('success', 'achat inséré avec succés inserted successfuly ');
    }

    /**
     * Display the specified resource.
     *
     * 
     * @param  \App\Commande  $commande
     *  @return \Illuminate\Http\Response

     */
    public function destroy($id_commande)
    {
            $c = Commande::find($id_commande);
            $c->delete();
            return redirect()->route('commande.index')->with('success', 'la commande a été supprimé ');     
    }


    public function update(Request $request)
    {
            $achat = Achat::find($request['']);
            dd($achat);
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

    

}
