<?php

namespace App\Http\Controllers;

use App\Type;
use App\Admin;
use App\Boutique;
use App\Commande;
use App\Commune;
use App\Wilaya;
use App\Livreur;
use App\Stock;
use App\Produit;
use App\Fournisseur;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class JournalController extends Controller
{

    public function ls()
    {
        $_user = "";
        $debut_entre = "";
        $fin_entre ="";
        $creance="";
        $ValeurRapporte = 0;
        $RapporteAuLsRapide=0;
        $livraison=0;
        $sql = "select * from commandes ";
        // $commandes = Commande::all();
        $sql = $sql.'where (state="Livree" or state="non abouti" or state="confirmer") and creance_livreur="solder livreur" and creance_fournisseur="solder fournisseur"';
        $commandes=DB::select(DB::raw($sql));
        $ValeurRapporte = 0;
        $RapporteAuLsRapide=0;
        $LivreurMontant=0;
        $LivreurMontantNonAbouti=0;
        
        $livraison=0;

        foreach ($commandes as $key => $commande) {
            if($commande->state == 'Livree' and $commande->creance_livreur == 'solder livreur' and $commande->creance_fournisseur == 'solder fournisseur')
            {
                $c = Commande::find($commande->id);
                // $LivreurMontant  = $LivreurMontant + Commande::getWilayaLivreurTarif($commande->wilaya);
                $ValeurRapporte = $ValeurRapporte+(Commande::getWilayaFournisseurTarif($commande->wilaya)-Commande::getWilayaLivreurTarif($commande->wilaya));
                
            }
        }

        return view('journals.ls',compact('commandes','creance','debut_entre','fin_entre','_user','livraison','ValeurRapporte','RapporteAuLsRapide')); 
    }

    public function personnel()
    {
        $_admin = "";
        $debut_entre = "";
        $fin_entre ="";
        $creance="";
        $ValeurRapporte = 0;
        $RapporteAuLsRapide=0;
        $soldage=0;
        $total = 0;
        $commandes = Commande::all();
        $admins = Admin::all();
        return view('journals.personnel',compact('admins','commandes','creance','debut_entre','fin_entre','_admin','soldage','ValeurRapporte','RapporteAuLsRapide','total')); 
    }

    public function livreur()
    {
        $_livreur = "";
        $debut_entre = "";
        $fin_entre ="";
        $creance="";
        $ValeurRapporte = 0;
        $RapporteAuLsRapide=0;
        $livraison=0;
        $LivreurMontantNonAbouti=0;
        $LivreurMontant=0;
        


        $commandes = Commande::all();
        $livreurs = Livreur::all();
        return view('journals.livreur',compact('livreurs',
        'commandes',
        'LivreurMontantNonAbouti',
        'LivreurMontant',
        'creance','debut_entre','fin_entre','_livreur','livraison','ValeurRapporte','RapporteAuLsRapide'));
    }


    public function Filterlivreur(Request $request)
    {
        $wheres = "";
        $index = 0;
        $_livreur = "";
        $debut_entre = "";
        $fin_entre ="";
        $creance="";
        $livreurs = Livreur::all();

        if($request['livreur']){
            $_livreur = $request['livreur'];
            $wheres =$wheres."where livreur_id=$_livreur ";                
            $index=1;
        }
        if($request['creance']){
            
            $creance = $request['creance'];
            if($index==0){
                $wheres =$wheres."where creance_livreur= '$creance' ";
                $index = 2;
            }else{
                $wheres =$wheres."and creance_livreur= '$creance' ";
                $index=2;
            }
        }

        if($request['debut_entre']){
            $debut_entre = $request['debut_entre'];
            $debut_entre_2 = date('Y-m-d',strtotime($debut_entre . "+1 days"));
            if($index==0){
                $wheres =$wheres."where created_at >= '$debut_entre' ";
                $index = 2;
            }else{
                $wheres =$wheres."and created_at >= '$debut_entre' ";
                $index=2;
            }
        }
        if($request['fin_entre']){
            $fin_entre = $request['fin_entre'];
            $fin_entre_2 = date('Y-m-d',strtotime($fin_entre . "+1 days"));
            // dd($fin_entre , $fin_entre_2);
            if($index>0){
                $wheres =$wheres." and created_at <= '$fin_entre_2' ";
            }else{
                $wheres =$wheres."where created_at <= '$fin_entre_2' ";
                $index=2;
            }
        }
        $sql = "select * from commandes ";
        $sql = $sql.$wheres;
        $sql = $sql.'and (state="Livree" or state="non abouti" or state="confirmer")';
        $commandes=DB::select(DB::raw($sql));

        $ValeurRapporte = 0;
        $RapporteAuLsRapide=0;
        $LivreurMontant=0;
        $LivreurMontantNonAbouti=0;
        
        $livraison=0;

        foreach ($commandes as $key => $commande) {
            if($commande->state == 'Livree' and $commande->creance_livreur == 'non solder')
            {
                $c = Commande::find($commande->id);
                $LivreurMontant  = $LivreurMontant + Commande::getWilayaLivreurTarif($commande->wilaya);
                $ValeurRapporte = $ValeurRapporte+$commande->total;    
            }
            if($commande->state == 'non abouti' and $commande->creance_livreur == 'non solder' )
            {
                $c = Commande::find($commande->id);
                $LivreurMontantNonAbouti  = $LivreurMontantNonAbouti + Commande::getWilayaLivreurNonAboutiTarif($commande->wilaya);

            }
            // $ValeurRapporte = $ValeurRapporte+$commande->total;
        }
        $LivreurMontant  = $LivreurMontant + $LivreurMontantNonAbouti;

        $RapporteAuLsRapide = $livraison+$ValeurRapporte;
        return view('journals.livreur',compact('livreurs','commandes','_livreur','debut_entre',
        'fin_entre',
        'creance',
        'LivreurMontantNonAbouti',
        'livraison',
        'LivreurMontant',
        'ValeurRapporte','RapporteAuLsRapide'));     
    }
    

    public function Filterfournisseur(Request $request)
    {
        $wheres = "";
        $index = 0;
        $_fournisseur = "";
        $debut_entre = "";
        $fin_entre ="";
        $creance="";
        $fournisseurs = Fournisseur::all();

        if($request['fournisseur']){
            $_fournisseur = $request['fournisseur'];
            $wheres =$wheres."where fournisseur_id=$_fournisseur ";                
            $index=1;
        }
        if($request['creance']){
            
            $creance = $request['creance'];
            if($index==0){
                $wheres =$wheres."where creance_fournisseur='$creance' ";
                $index = 2;
            }else{
                $wheres =$wheres."and creance_fournisseur='$creance' ";
                $index=2;
            }
        }

        if($request['debut_entre']){
            $debut_entre = $request['debut_entre'];
            $debut_entre_2 = date('Y-m-d',strtotime($debut_entre . "+1 days"));
            if($index==0){
                $wheres =$wheres."where created_at >= '$debut_entre' ";
                $index = 2;
            }else{
                $wheres =$wheres."and created_at >= '$debut_entre' ";
                $index=2;
            }
        }
        if($request['fin_entre']){
            $fin_entre = $request['fin_entre'];
            $fin_entre_2 = date('Y-m-d',strtotime($fin_entre . "+1 days"));
            // dd($fin_entre , $fin_entre_2);
            if($index>0){
                $wheres =$wheres." and created_at <= '$fin_entre_2' ";
            }else{
                $wheres =$wheres."where created_at <= '$fin_entre_2' ";
                $index=2;
            }
        }


        $sql = "select * from commandes ";
        $sql = $sql.$wheres;
        $sql = $sql.' and (state="Livree" or state="non abouti" or state="confirmer")';
        
        $commandes=DB::select(DB::raw($sql));
        // dd($commandes);


        // $sql = $sql.' order by ville,wilaya desc';
        $ValeurRapporte = 0;
        $valuerJdida=0;
        $RapporteAuLsRapide=0;
        $fournisseurMontant=0;
        $tarifTelephonique =0; 
        foreach ($commandes as $key => $commande) {
            if($commande->state == 'Livree' )
            {
                $c = Commande::find($commande->id);
                $fournisseurMontant  = $fournisseurMontant + Commande::getWilayaFournisseurTarif($commande->wilaya);
                $ValeurRapporte = $ValeurRapporte+$commande->total;    
                $valuerJdida =$commande->total- Commande::getWilayaFournisseurTarif($commande->wilaya);
            }
            if($commande->state == 'non abouti' )
            {
                $c = Commande::find($commande->id);
                $fournisseurMontant  = $fournisseurMontant + Commande::getWilayaFournisseurNonAboutiTarif($commande->wilaya);
                // $ValeurRapporte = $ValeurRapporte+$commande->total;    
            }
        }

        foreach ($commandes as $key => $commande) {
            if($commande->confirmed == 1 )
            {
                $c = Commande::find($commande->id);
                if($c->isFournisseurHasPhone() == 1 ){
                    $tarifTelephonique=$tarifTelephonique+ 30;                         
                }
            }
        }

        $RapporteAuLsRapide = $ValeurRapporte-$fournisseurMontant;
        // $sql = $sql.' order by ville,wilaya desc';
        return view('journals.fournisseur',compact('fournisseurs','commandes','_fournisseur',
        'tarifTelephonique',
        'valuerJdida',  
        'debut_entre','fin_entre','creance','RapporteAuLsRapide','ValeurRapporte','fournisseurMontant'));     
    }
    
    
    public function fournisseur()
    {
        
        $commandes = DB::table('commandes')->where([
            ['state','=','Livree']
        ])
        ->orderBy('id', 'DESC')->paginate(10);
        $fournisseurs = Fournisseur::all();        
        $_fournisseur = "";
        $debut_entre = "";
        $fin_entre ="";
        $creance="";
        $soldage = ""; 
        $ValeurRapporte = 0;
        $RapporteAuLsRapide=0;
        $tarifTelephonique = 0;
        $fournisseurMontant=0;
        $RapporteAuLsRapide = 0;
        $valuerJdida=0;
        return view('journals.fournisseur',compact('commandes','fournisseurs','creance','debut_entre','fin_entre','_fournisseur','soldage',
            'ValeurRapporte',
            'valuerJdida',
            'RapporteAuLsRapide',
            'tarifTelephonique',
            'fournisseurMontant',
            'RapporteAuLsRapide'
        ));
        
    }


    public function Filterpersonnel(Request $request)
    {
        $wheres = "";
        $index = 0;
        $_admin = "";
        $debut_entre = "";
        $fin_entre ="";
        $creance="";
        $admins = Admin::all();

        if($request['admin']){
            $_admin = $request['admin'];
            $wheres =$wheres.'where sold_by_admin='.$_admin;                
            $index=1;
        }

        $sql = "select * from commandes ";
        $sql = $sql.$wheres;
        $commandes=DB::select(DB::raw($sql));
        $ValeurRapporte = 0;
        $RapporteAuLsRapide=0;
        $total=0;
        $soldage = 0;
        foreach ($commandes as $key => $commande) {
            $soldage  = $soldage + Commande::getWilayaFournisseurTarif($commande->wilaya);
            $ValeurRapporte = $ValeurRapporte+$commande->total;
        }
        $total = $ValeurRapporte+$soldage;
        return view('journals.personnel',compact('admins','commandes','_admin','debut_entre','fin_entre','creance','RapporteAuLsRapide','ValeurRapporte','total'));     
    }


    public function Filterls(Request $request)
    {

        $wheres = "";
        $index = 0;
        $_livreur = "";
        $and = "where ";
        $debut_entre = "";
        $fin_entre ="";
        $creance="";
        $livreurs = Livreur::all();

        // if($request['livreur']){
        //     $_livreur = $request['livreur'];
        //     $wheres =$wheres."where livreur_id=$_livreur ";                
        //     $index=1;
        // }
        // if($request['creance']){
        //     $creance = $request['creance'];
        //     if($index==0){
        //         $wheres =$wheres."where creance_livreur= '$creance'";
        //         $index = 2;
        //     }else{
        //         $wheres =$wheres."and creance_livreur= '$creance'";
        //         $index=2;
        //     }   
        // }

        if($request['debut_entre']){
            $debut_entre = $request['debut_entre'];
            $debut_entre_2 = date('Y-m-d',strtotime($debut_entre . "+1 days"));
            if($index==0){
                $wheres =$wheres."where created_at >= '$debut_entre' ";
                $index = 2;
            }else{
                $wheres =$wheres."and created_at >= '$debut_entre' ";
                $index=2;
            }
        }
        if($request['fin_entre']){
            $fin_entre = $request['fin_entre'];
            $fin_entre_2 = date('Y-m-d',strtotime($fin_entre . "+1 days"));
            // dd($fin_entre , $fin_entre_2);
            if($index>0){
                $wheres =$wheres." and created_at <= '$fin_entre_2' ";
            }else{
                $wheres =$wheres."where created_at <= '$fin_entre_2' ";
                $index=2;
            }
        }


        $sql = "select * from commandes ";
        $sql = $sql.$wheres;
        if($index != 0){
            $and = ' and ';
        }

        $sql = $sql.$and.' (state="Livree" or state="non abouti" or state="confirmer") and creance_livreur="solder livreur" and creance_fournisseur="solder fournisseur"';
        $commandes=DB::select(DB::raw($sql));
        $ValeurRapporte = 0;
        $RapporteAuLsRapide=0;
        $LivreurMontant=0;
        $LivreurMontantNonAbouti=0;
        
        $livraison=0;

        foreach ($commandes as $key => $commande) {
            if($commande->state == 'Livree' and $commande->creance_livreur == 'solder livreur' and $commande->creance_fournisseur == 'solder fournisseur')
            {
                $c = Commande::find($commande->id);
                // $LivreurMontant  = $LivreurMontant + Commande::getWilayaLivreurTarif($commande->wilaya);
                $ValeurRapporte = $ValeurRapporte+(Commande::getWilayaFournisseurTarif($commande->wilaya)-Commande::getWilayaLivreurTarif($commande->wilaya));
                
            }
        }

        return view('journals.ls',compact('livreurs','commandes','_livreur','debut_entre',
        'fin_entre',
        'creance',
        'LivreurMontantNonAbouti',
        'livraison',
        'LivreurMontant',
        'ValeurRapporte','RapporteAuLsRapide'));     
    }   
}
