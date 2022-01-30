<?php

namespace App\Http\Controllers;

use App\Type;
use App\Commande;
use App\Commune;
use App\Stock;
use App\Fournisseur;
use App\Wilaya;
use App\Livreur;
use App\Produit;
use App\Achat;
use App\Payment;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

class PaymentController extends Controller
{


    
    public function index($id_achat)
    {
        $achat = Achat::find($id_achat);
        $payments =Payment::where('achat',$id_achat)->get();
        $payed = DB::table("payments")->where('achat',$id_achat)->get()->sum("montant");
        $debt  = $achat->total - $payed ;
        return view('payments.index',compact('debt','payments','achat','payed'));
    }

    public function list($id_achat)
    {
        $achat = Achat::find($id_achat);
        $payments =Payment::where('achat',$id_achat)->get();
        $payed = DB::table("payments")->where('achat',$achat)->get()->sum("montant");
        $debt  = $achat->total - $payed ;
        return view('payments.list',compact('debt','payments','achat','payed'));
    }


    public function show($achat){
        $achat =  Achat::find($achat);
        return view('achats.view',compact('achat'));
    }

    public function store(Request $request)
    {       
        $achat= Achat::find($request->get('achat'));
        $produits = json_decode($achat->reste,true) ?? json_decode($achat->produits,true) ;
        $products = json_decode($achat->reste,true) ?? json_decode($achat->produits,true) ;
        for ($key=0; $key < count($request['quantites']); $key++) { 
            $produits[$key]['quantite'] -= $request['quantites'][$key];    
            $products[$key]['quantite'] = $request['quantites'][$key];                
        }
        $achat->reste = json_encode($produits);
        $achat->save();
        $payment = new Payment();
        $payment->montant= $request->get('montant');
        $payment->achat= $request->get('achat');
        $payment->date_payment= $request->get('date_payment');
        $payment->commentaire= $request->get('commentaire');
        $payment->produit= $request->get('produit');
        $payment->quantite= json_encode($products);//quantite');
        $payment->save();
        return redirect()->route('payment.index',['achat'=>$payment->achat])->with('success', 'payment inséré avec succés ');
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


    

}
