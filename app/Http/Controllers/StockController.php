<?php

namespace App\Http\Controllers;

use App\Commune;
use App\Wilaya;
use App\Produit;
use App\Stock;
use App\Commande;

use App\Fournisseur;
use DB;
use Auth;
use App\Http\Requests\StoreProduit;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        if(auth()->guard('fournisseur')->check()){
     
            $id = Auth::guard('fournisseur')->id();
            $communes = Commune::all();
            $wilayas =Wilaya::all();
            $produits = DB::select("select * from produits where fournisseur_id=$id");
            
            /**
             * stcok ta3 ses prdoutis brk 
             */
            $fournisseurs =Fournisseur::all();
            $stocks = DB::select("select * from stocks where produit_id in (select id from produits where fournisseur_id=$id)");
            return view('stocks.index-fournisseur',compact('stocks','fournisseurs','produits','communes','wilayas','id'));
        
        }   

        $fournisseurs =Fournisseur::all();
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $produits = Produit::all();
        $stocks = Stock::all();//DB::table('stocks')->orderBy('id', 'DESC')->get();
        return view('stocks.index2',compact('stocks','produits','fournisseurs','communes','wilayas'));
    }

    public function detail($id_stock)
    {
        $stock =Stock::find($id_stock);
        $produit = Produit::find($stock->produit_id);

        $commande = Commande::find(1);
        return view('stocks.detail',compact('stock','commande','produit'));

    }


    public function print($id_stock)
    {
        $stock =Stock::find($id_stock);
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions(); 
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);
        $html = Commande::templateStock('test');
        $dompdf->loadHtml($html);
        $dompdf->render();
        $current = date('Y-m-d');
        $file = "facture_".$current;
        $dompdf->stream("$file", array('Attachment'=>1));

    }
    public function entrer(Request $request)
    {
        $fournisseur = json_decode($request['fournisseur_entre']);

        foreach ($request['dynamic_form']['dynamic_form'] as $array) {
            $produit_json = json_decode($array['produit'], true);
            $produit  = Produit::find($produit_json['id']);
            $qteOld = $produit->quantite;
            $qteNew = $qteOld + $array['quantite'];  
            $produit->quantite = $qteNew;
            $produit->save();
            $stock = new  Stock();
            $stock->produit = $array['produit'];
            $stock->produit_id = $produit->id;
            $stock->quantite = $array['quantite'];
            $stock->fournisseur_id =$fournisseur->id;
            $stock->operation = 'entré';

            $stock->save();


        }    
        return redirect()->route('stock.index')->with('success', 'insertion effectué !  ');     

    }

    public function sortie(Request $request)
    {
        $fournisseur = json_decode($request['fournisseur_sortie']);

        foreach ($request['dynamic_form_sortie']['dynamic_form_sortie'] as $array) {
            $produit_json = json_decode($array['produit'], true);
            $produit  = Produit::find($produit_json['id']);
            $qteOld = $produit->quantite;
            $qteNew = $qteOld - $array['quantite'];  
            $produit->quantite = $qteNew;
            $produit->save();
            $stock = new  Stock();
            $stock->produit = $array['produit'];
            $stock->produit_id = $produit->id;
            $stock->quantite = $array['quantite'];
            $stock->fournisseur_id =$fournisseur->id;
            $stock->operation = 'sortie';

            $stock->save();
        }    
        return redirect()->route('stock.index')->with('success', 'insertion effectué !  ');     
    }

    public function destroy($id_stock)
    {
        $stock = Stock::find($id_stock);
        $stock->delete();
        return redirect()->route('stock.index')->with('success', 'le Produit a été supprimé ');        
    }


}
