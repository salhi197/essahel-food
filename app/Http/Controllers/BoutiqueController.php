<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Commune;
use App\Freelancer;
use App\Wilaya;
use App\Livreur;
use App\Produit;
use Auth;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class BoutiqueController extends Controller
{
    public function index()
    {
        $boutiques = DB::table('boutiques')->orderBy('id', 'DESC')->paginate(5);
        return view('boutiques.index',compact('boutiques'));
    }
    public function create()
    {
        $produits = Produit::all();
        return view('boutiques.create',compact('produits'));
    }


    public function store(Request $request)
    {
        $produits = array();


        foreach ($request['dynamic_form']['dynamic_form'] as $array) {
            $produit_json = json_decode($array['produit'], true);
            $produit  = Produit::find($produit_json['id']);
            $qteOld = $produit->quantite;
            $qteNew = $qteOld - $array['quantite'];  
            $produit->quantite = $qteNew;
            $produit->save();

            $produit_json['quantite'] = $array['quantite'];
            $produit_json['prix_vente'] = $array['prix'];
            array_push($produits,$produit_json);
        }    
        $boutique = new Boutique([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'adress'=>$request->get('adress'),
            'telephone'=>$request->get('telephone'),
            'password'=>Hash::make('password'),//,      
            'password_text'=>$request->get('password')//[''],//,      
        ]);
        $produits = json_encode($produits);
        $boutique->produits = $produits;
        $boutique->save();
        return redirect()->route('boutique.index')->with('success', 'boutique inséré avec succés inserted successfuly ');
    }  

    public function destroy($id_boutique)
    {
            $b = Boutique::find($id_boutique);
            $b->delete();
            return redirect()->route('boutique.index')->with('success', 'la boutique a été supprimé ');     
    }

    public function show($boutqiue)
    {
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $boutqiue = Freelancer::find($boutqiue);
        return view('boutiques.edit',compact('livreur','wilayas','communes'));
    }

    public function update(Request $request)
    {
        $boutqiue = Freelancer::find($request['freelancer_id']);
        $boutqiue->name=$request->get('name');
        $boutqiue->email=$request->get('email');
        $boutqiue->adress=$request->get('adress');
        $boutqiue->telephone=$request->get('telephone');
        $boutqiue->password=Hash::make('password');//,      
        $boutqiue->password_text=$request->get('password');//[''],//,      
        $boutqiue->save();
        return redirect()->route('boutique.index')
            ->with('success', 'modification efféctué !');

    }
    


}

