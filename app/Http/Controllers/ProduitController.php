<?php

namespace App\Http\Controllers;

use App\Commune;
use App\Wilaya;
use App\Stock;
use App\Achat;
use Carbon\Carbon;
use App\Produit;
use App\Fournisseur;
use App\Http\Requests\StoreProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class ProduitController extends Controller
{


    public function index()
    {
        if(auth()->guard('fournisseur')->check()){
            $id = Auth::guard('fournisseur')->id();
            $produits = DB::table('produits')->where('fournisseur_id',$id)->orderBy('id', 'DESC')->paginate(10);    
            return view('produits.index',compact('produits'));
        }   
    

        $produits = Produit::all();
        return view('produits.index',compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $fournisseurs =Fournisseur::all();
        return view('produits.create',compact('fournisseurs','communes','wilayas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validated = $request->validated();

        
        $fournisseur = json_decode($request->get('fournisseur'), true);
        $produit = new Produit();   
        $produit->nom= $request->get('nom');
        $produit->prix_vente= $request->get('prix_vente');
        $produit->quantite= $request->get('quantite') ?? 0;
        $produit->categorie= $request->get('categorie');
        $produit->prix_fournisseur= $request->get('prix_fournisseur');
        $produit->marge_commercial= $request->get('marge_commercial');
        $produit->description = $request->get('description');
        $produit->fournisseur = $request->get('fournisseur');
        $produit->fournisseur_id = $fournisseur['id'];
        $produit->budget = $request->get('budget');
        $produit->marge_freelance = $request->get('marge_freelance');
        $produit->marge_boutique = $request->get('marge_boutique');
        $produit->marge_clicntic = $request->get('marge_clicntic');
        $produit->state = $request->get('state');
        $stack = array();
        if($request->file('image')){
            $file = $request->file('image');// as $image){
                $image = $file->store(
                    'produits/images',
                    'public'
                );
                $produit->image = $image; 
            }

        $stack = json_encode($stack);
        $produit->save();

        $stock = new  Stock();
        $stock->produit = json_encode($produit,true);
        $stock->produit_id = $produit->id;
        $stock->quantite = $produit['quantite'];
        $stock->operation = 'entré';
        $stock->save();
        $achat = new Achat([
            'state'=>$request['state'],
            'fournisseur'=>$request->get('fournisseur'),
            'fournisseur_id'=>$fournisseur['id'],            
            'date_achat'=>Carbon::now(),
        ]);
        $achat->produits = json_encode($produit); 
        $achat->reste = json_encode($produit); 
        $achat->total = $request->get('prix_fournisseur')*$request->get('quantite'); 
        
        $achat->save();




        return redirect()->route('produit.index')->with('success', 'Produit inséré avec succés ');        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show($id_produit)
    {
        $produit = Produit::find($id_produit);

        return view('produits.view',compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit($id_produit)
    {
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $fournisseurs =Fournisseur::all();
        $produit = Produit::find($id_produit);
        return view('produits.edit',compact('fournisseurs','communes','wilayas','produit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $produit)
    {   
        $produit = Produit::find($produit);
        $produit->nom= $request->get('nom');
        $produit->prix_vente= $request->get('prix_vente');
        $produit->quantite= $request->get('quantite');
        $produit->categorie= $request->get('categorie');
        $produit->prix_fournisseur= $request->get('prix_fournisseur');
        $produit->marge_commercial= $request->get('marge_commercial');
        $produit->description = $request->get('description');

        if ($request->hasFile('image')) {
            
            $produit->image = $request->file('image')->store(
                'produits/images',
                'public'
            );
        }
        $produit->save();
        $produits = Produit::all();
        return redirect()->route('produit.index')->with('success', 'Produit modifé avec succés ');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_produit)
    {
        $produit = Produit::find($id_produit);
        $produit->delete();
        return redirect()->route('produit.index')->with('success', 'le Produit a été supprimé ');        
    }

    public function stock($id_produit)
    {
        $produit = Produit::find($id_produit);
        $stocks = Stock::where('produit_id',$produit->id)->orderBy('id','desc')->get();
        $produits = Produit::all();
        $fournisseurs =Fournisseur::all();
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        return view('stocks.index',compact('produits','stocks','produits','fournisseurs','communes','wilayas'));
    }


    public function printStock($id_produit)
    {
        dd('on est entrain de construire cette page ...');
    }


}
