<?php

namespace App\Http\Controllers;

use App\Type;
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
use Milon\Barcode\DNS1D;

class CommandeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:admin');
    }

    public function affecterList(Request $request,$livreur)
    {
        $l = Livreur::find($livreur);
        $data = explode(',',  $_GET['id']);
        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande = Commande::find($c);
                if ($commande->livreur_id != null) {
                    return redirect()->back()->with('error', 'la commande a été déja affecté !');           
                }
        
                $commande->livreur = json_encode($l, true);
                $commande->state = 'sortie';
                $dat = Carbon::now();
                Commande::where('id', '=', $commande->id)->update(['sortie' => $dat]);
                $commande->livreur_id = $livreur;
                $commande->save();        
            }
        }
        return redirect()->route('livreur.filter',['livreur'=>$livreur])->with('success', 'les commandes ont été affectés  ');           
    }

    public function confirmerOne($c)
    {
        $commande =  Commande::find($c);
        // $fournisseur = json_decode($commande->fournisseur); 
        // $commande->type = 'colier';
        $commande->confirmed = 1;
        $commande->state = 'confirmer';

        // $dat = Carbon::now();
        // Commande::where('id', '=', $commande->id)->update(['confirmer' => $dat]);
        $commande->save();
        return redirect()->back()->with('success', 'les commandes ont été confirmé  ');           

    }
    public function confirmerList(Request $request,$fournisseur)
    {
        $data = explode(',',  $_GET['id']);
        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande =  Commande::find($c);
                $commande->type = 'colier';
                $commande->state = 'en_cours';
                $dat = Carbon::now();
                Commande::where('id', '=', $commande->id)->update(['en_cours' => $dat]);
                $commande->save();
            }
        }
        return redirect()->route('fournisseur.coliers',['id_fournisseur'=>$fournisseur])
            ->with('success', 'les commandes ont été confirmé et déplacés on coliers .');           
    }


    public function destroyList(Request $request)
    {
        $data = explode(',',  $_GET['id']);

        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande =  Commande::find($c);
                $commande->delete();
            }
        }
        return redirect()->back()->with('success', 'les commandes ont annulés ');           
    }

    public function detacherList(Request $request,$livreur)
    {
        $l = Livreur::find($livreur);
        $data = explode(',',  $_GET['id']);
        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande =  Commande::find($c);
                $commande->livreur_id = null;
                $commande->livreur = null;
                $dat = Carbon::now();
                Commande::where('id', '=', $commande->id)->update(['en_cours' => $dat]);
                $commande->state = "en_cours";
                $commande->save();
                }
        }
        return redirect()->route('livreur.filter',['livreur'=>$l->id])->with('success', 'les commandes ont été retirés  ');           
    }



    public function solderFournisseur(Request $request)
    {
        
        $data = explode(',',  $_GET['id']);
        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande =  Commande::find($c);
                if ($commande->creance_fournisseur == "non solder") {
                    $admin = Auth::guard('admin')->user();
                    $commande->creance_fournisseur = "solder fournisseur";
                    $commande->sold_by_admin = $admin->id;

                    $commande->save();
                }
            }
        }
        return redirect()->route('journal.fournisseur')->with('success', 'les commandes ont été soldés . . . ');           
    }

    public function solderLivreur(Request $request)
    {
        
        $data = explode(',',$_GET['id']);
        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande =  Commande::find($c);
                if ($commande->creance_livreur == "non solder") {
                    $admin = Auth::guard('admin')->user();
                    $commande->creance_livreur = "solder livreur";
                    $commande->sold_by_admin = $admin->id;
                    $commande->save();
                }
            }
        }
        return redirect()->route('journal.fournisseur')->with('success', 'les commandes ont été soldés . . . ');           
    }






    public function solder(Request $request)
    {
        
        $data = explode(',',  $_GET['id']);
        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande =  Commande::find($c);
                if ($commande->creance == "non solder") {
                    $admin = Auth::guard('admin')->user();
                    // Admin::where('id', '=', $admin->id)->update(['solde' => ]);
                    // dd($admin->id);
                    $commande->creance = "solder";
                    $commande->sold_by_admin = $admin->id;

                    $commande->save();
                }
            }
        }
        return redirect()->route('journal.fournisseur')->with('success', 'les commandes ont été soldés . . . ');           
    }

    public function nonsolderLivreur(Request $request)
    {
        $data = explode(',',  $_GET['id']);
        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande =  Commande::find($c);
                $commande->creance_livreur = "non solder";
                // $commande->creance_fournisseur = "non solder";
                $commande->save();
            }
        }
        return redirect()->route('journal.livreur')->with('success', 'les commandes ont été non soldés . . . ');           
    }

    public function nonsolderFournisseur(Request $request)
    {
        $data = explode(',',  $_GET['id']);
        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande =  Commande::find($c);
                $commande->creance_livreur = "non solder";
                // $commande->creance_fournisseur = "non solder";
                $commande->save();
            }
        }
        return redirect()->route('journal.fournisseur')->with('success', 'les commandes ont été non soldés . . . ');           
    }


    
    public function index()
    {
        $confirmation=""; 

        if(auth()->guard('fournisseur')->check()){
            $id = Auth::guard('fournisseur')->id();
            $commandes = DB::table('commandes')->where('fournisseur_id',$id)->orderBy('created_at','desc')->paginate(30);
            $communes = Commune::all();
            $wilayas =Wilaya::all();
            return view('fournisseurs',compact('confirmation','commandes','communes','wilayas'));    
        }  
        $commandes = Commande::where('type','colier')->get();
        $commandes = DB::table('commandes')->orderBy('created_at','desc')->paginate(30);
        //$communes = Commune::all();
        $fournisseurs = Fournisseur::all();
        $wilayas =Wilaya::all();
        $livreurs =Livreur::all();
        $fournisseur_id = "";      
        return view('admin',compact('confirmation','fournisseurs','commandes','data','communes','wilayas','livreurs','fournisseur_id'));
    }

    public function show($id_commande){
        $commande =  Commande::find($id_commande);
        return view('commandes.display',compact('commande'));
    }



    public function download($id_commande){
        $commande =  Commande::find($id_commande);

        $dompdf = new Dompdf();

        $options = $dompdf->getOptions(); 
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);

        $html = Commande::template2($commande);
        $customPaper = array(0,0,230,250);
        $dompdf->setPaper($customPaper);
 
        $dompdf->loadHtml($html);
        $dompdf->render();
        $current = date('Y-m-d');
        $file = "facture_".$current;
        $dompdf->stream("$file", array('Attachment'=>1));

    }

    public function printSingle($commande,$type)
    {
        $html = '
            <html style="page-break-before: always;">
            <head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
            <style type="text/css">
            @page { size: 215pt 215pt;margin:0; }
            span.cls_008{font-family:"Trebuchet MS",serif;font-size:7.0px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_008{font-family:"Trebuchet MS",serif;font-size:7.0px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_003{font-family:"Trebuchet MS",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_003{font-family:"Trebuchet MS",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_004{font-family:"Trebuchet MS Bold",serif;font-size:10.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_004{font-family:"Trebuchet MS Bold",serif;font-size:10.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_002{font-family:"Trebuchet MS Bold",serif;font-size:48.0px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_002{font-family:"Trebuchet MS Bold",serif;font-size:48.0px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_005{font-family:"Trebuchet MS Bold",serif;font-size:14.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_005{font-family:"Trebuchet MS Bold",serif;font-size:14.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_006{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_006{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_007{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_007{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_009{font-family:"Trebuchet MS",serif;font-size:12.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_009{font-family:"Trebuchet MS",serif;font-size:12.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            </style>
            <script type="text/javascript" src="525ab86c-3723-11eb-8b25-0cc47a792c0a_id_525ab86c-3723-11eb-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
            </head>
            <body>
        ';

        $dompdf = new Dompdf();
        $c = $commande;
        $options = $dompdf->getOptions(); 
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);
        if($type == 'a4'){
            $html = '
            <html style="page-break-before: always;">
            <head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
            <style type="text/css">
            @page { width: 100% ;margin:0;padding:0; }
            span.cls_002{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_002{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_007{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_007{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_006{font-family:"Trebuchet MS Bold",serif;font-size:47.0px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_006{font-family:"Trebuchet MS Bold",serif;font-size:47.0px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_005{font-family:"Trebuchet MS Bold",serif;font-size:11.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_005{font-family:"Trebuchet MS Bold",serif;font-size:11.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_003{font-family:"Trebuchet MS",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_003{font-family:"Trebuchet MS",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_008{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_008{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_004{font-family:"Trebuchet MS Bold",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_004{font-family:"Trebuchet MS Bold",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_009{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(44,44,44);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_009{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(44,44,44);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_010{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_010{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            
            </style>
            <script type="text/javascript" src="a75dddf0-3997-11eb-8b25-0cc47a792c0a_id_a75dddf0-3997-11eb-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
            </head>
            <body>
            ';    
            $html = $html.Commande::templateA4($commande,0);
            $html = $html.'
            </body>
            </html>                
        ';

            
        }else{
            // $html = Commande::template2($commande);
            // $customPaper = array(0,0,230,249);
            // $dompdf->setPaper($customPaper);
            $html = $html.Commande::templateTicket($commande);
            //$html = Commande::template2($commande);
            $html = $html.'
            </body>
            </html>                
        ';

        }
        $dompdf->loadHtml($html);
        $dompdf->render();
        $current = date('Y-m-d');
        $file = "facture_".$current;
        $dompdf->stream("$file", array('Attachment'=>1));

    }

    public function printA4(Request $request){

        
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions(); 
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);
        $html = '
        
        <html style="page-break-before: always;">
        <head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
        <style type="text/css">
        
        @page { width: 100% ;margin:0;padding:0; }
        span.cls_002{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_002{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
        span.cls_007{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
        div.cls_007{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
        span.cls_006{font-family:"Trebuchet MS Bold",serif;font-size:47.0px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
        div.cls_006{font-family:"Trebuchet MS Bold",serif;font-size:47.0px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
        span.cls_005{font-family:"Trebuchet MS Bold",serif;font-size:11.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
        div.cls_005{font-family:"Trebuchet MS Bold",serif;font-size:11.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
        span.cls_003{font-family:"Trebuchet MS",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_003{font-family:"Trebuchet MS",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
        span.cls_008{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_008{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
        span.cls_004{font-family:"Trebuchet MS Bold",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
        div.cls_004{font-family:"Trebuchet MS Bold",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
        span.cls_009{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(44,44,44);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_009{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(44,44,44);font-weight:normal;font-style:normal;text-decoration: none}
        span.cls_010{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
        div.cls_010{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
        .page_breaking
        {
          position:absolute;
          bottom: 0px;
          page-break-after: always;
        } 
        
       
        </style>
        <script type="text/javascript" src="a75dddf0-3997-11eb-8b25-0cc47a792c0a_id_a75dddf0-3997-11eb-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
        </head>
        <body>
        ';
        $data = explode(',',  $_GET['id']);
        $margin = 20;
        foreach($data as $key=>$commande){
            if($key!=0 and $key%4==0){
                $html = $html.'
                <div class="page_breaking"></div>
                ';
                $margin = 0;                
            }
            if (strlen($commande)>0) {
                $h = Commande::templateA4($commande,$margin);
                $html=$html.$h;
                $margin = $margin+120;
            }
        }
        $html = $html.'
            </body>
            </html>                
        ';
        $dompdf->loadHtml($html);
        $dompdf->render();
        $current = date('Y-m-d');
        $file = "facture_".$current;
        $dompdf->stream("$file", array('Attachment'=>1));

    }

    

    public function printTicket(Request $request){

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions(); 
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);
        $html = '
            <html style="page-break-before: always;">
            <head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
            <style type="text/css">
            @page { size: 215pt 215pt;margin:0; }
            span.cls_008{font-family:"Trebuchet MS",serif;font-size:7.0px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_008{font-family:"Trebuchet MS",serif;font-size:7.0px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_003{font-family:"Trebuchet MS",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_003{font-family:"Trebuchet MS",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_004{font-family:"Trebuchet MS Bold",serif;font-size:10.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_004{font-family:"Trebuchet MS Bold",serif;font-size:10.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_002{font-family:"Trebuchet MS Bold",serif;font-size:48.0px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_002{font-family:"Trebuchet MS Bold",serif;font-size:48.0px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_005{font-family:"Trebuchet MS Bold",serif;font-size:14.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_005{font-family:"Trebuchet MS Bold",serif;font-size:14.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_006{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_006{font-family:"Trebuchet MS Bold",serif;font-size:9.1px;color:rgb(24,24,24);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_007{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_007{font-family:"Trebuchet MS",serif;font-size:8.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_009{font-family:"Trebuchet MS",serif;font-size:12.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_009{font-family:"Trebuchet MS",serif;font-size:12.1px;color:rgb(24,24,24);font-weight:normal;font-style:normal;text-decoration: none}
            </style>
            <script type="text/javascript" src="525ab86c-3723-11eb-8b25-0cc47a792c0a_id_525ab86c-3723-11eb-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
            </head>
            <body>
        ';
        $data = explode(',',  $_GET['id']);
        foreach($data as $key=>$commande){
            if (strlen($commande)>0) {
                $h = Commande::templateTicket($commande);
                $html=$html.$h;//Commande::templateTicket($commande);                
                if($key < count($data)-2){
                    $html=$html.'
                    <div style="page-break-before: always;"></div>
                ';
                }
            }
        }
        $html = $html.'
            </body>
            </html>                
        ';
        $dompdf->loadHtml($html);
        $dompdf->render();
        $current = date('Y-m-d');
        $file = "facture_".$current;
        $dompdf->stream("$file", array('Attachment'=>1));

    }


    public function accepter($id_commande){
        $livreur = Auth::guard('livreur')->user();
        //$livreurs = Livreur::all();
        $commande = Commande::find($id_commande);
        $type = Type::where('label',$commande->command_express)->first();
        $commande->state = 'accepte';
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

    public function retirer($id_commande){
        $commande =  Commande::find($id_commande);
        $commande->livreur_id = null;
        $commande->livreur = null;
        $commande->save();
        return redirect()->back()->with('success', 'la commande a été retiré ');           
    }

    public function create()
    {
        $livreurs =Livreur::all();
        $fournisseurs =Fournisseur::all();
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $types = Type::all();
        //mt_rand(100000,999999);        
        $number = 0;
        do {
            $number = mt_rand(100000,999999);
        } while ( DB::table( 'commandes' )->where( 'code_tracking', $number )->exists() );
        $code='ls'.$number;
         
        

        if(Auth::guard('fournisseur')->user()){
            $f = Auth::guard('fournisseur')->user();
            $id= $f->id;
            $fournisseur=json_encode($f,true);

            $produits = Produit::where('fournisseur_id',$id)->get();
            return view('commandes.create-fournisseur',compact('wilayas','communes','produits','livreurs','types','fournisseur','code'));        
        }else{
            $produits = Produit::all();
            return view('commandes.create',compact('wilayas','communes','produits','livreurs','types','fournisseurs','code'));
        }



    }

    public function search(Request $request)
    {
        $fournisseur_id ="";
        $result = Commande::query();
        $fournisseurs = Fournisseur::all();
        $livreurs = Livreur::all();
        
        if (!empty($request['id_commande'])) {
            $result = $result->where('id',$request['id_commande']);
        }

        if (!empty($request['code_tracking'])) {
            $result = $result->where('code_tracking',$request['code_tracking']);
        }

        if (!empty($request['state'])) {
            $result = $result->where('state','=',$request['state']);
        }
        
        if (!empty($request['fournisseur'])) {
            $fournisseur_id = $request['fournisseur'];
            $result = $result->where('fournisseur_id','=',$request['fournisseur']);
        }

        
        if (!empty($request['date_debut'])) {
            $result = $result->where('created_at', '=>', $request['date_debut']);
        }

        if (!empty($request['date_fin'])) {
            $result = $result->where('created_at', '<=', $request['date_fin']);
        }

        
        if (!empty($request['wilaya_id'])) {
            $result = $result->where('wilaya', $request['wilaya_id']);
        }
        $commandes = $result->get();

        $communes = Commune::all();
        $wilayas =Wilaya::all();
        return view('commandes.results',compact('commandes',
        'fournisseurs',
        'livreurs',
        'fournisseur_id',
        'wilayas','
        communes'
    ));
    }


    public function storeForFournisseur(Request $request)
    {       
        $produits = array();
        $total_produit = 0;
        $total= 0;
        $acteur = "";
        $id_acteur = 0;        
        $fournisseur = json_decode($request->get('fournisseur'), true);
        
        foreach ($request['dynamic_form']['dynamic_form'] as $array) {

            if ($array['produit'] and $array['quantite']) {
                $produit_json = json_decode($array['produit'], true);
                $produit  = Produit::find($produit_json['id']);
                $qteOld = $produit->quantite;
                $qteNew = $qteOld - $array['quantite'];  
                $produit->quantite = $qteNew;
                $produit->save();
                $total_produit = 1*$array['prix'];
                $total = $total + $total_produit;
                $produit_json['quantite'] = $array['quantite'];
                $produit_json['prix_vente'] = $array['prix'];
                array_push($produits,$produit_json);
                $stock = new  Stock();
                $stock->produit = $array['produit'];
                $stock->produit_id = $produit->id;
                $stock->fournisseur_id = $fournisseur['id'];
                $stock->quantite = $array['quantite'];
                $stock->operation = 'sortie';
                $stock->save();                    
            }else{
                return redirect()->back()->with('error', 'vous avez essayé d\'insére une comamnde sans articlees ! ');
            }
        }    

        $produits = json_encode($produits);
        $livreur = json_decode($request->get('livreur'), true);
        $dat = Carbon::now();
        $commande = new Commande([
            'prix'=>$request->get('prix'),
            'code_tracking'=> $request['code_tracking'],
            'nom_client'=>$request->get('nom_client'),
            'telephone'=>$request->get('telephone'),
            'wilaya'=>$request->get('wilaya_id'),
            'commune'=>$request->get('commune'),
            'note'=>$request->get('note'),
            'type'=>'arrive',
            'adress'=>$request->get('adress') ?? '',
            'state'=>'en_preparation',
            'livreur'=>$request->get('livreur'),
            'fournisseur'=>$request->get('fournisseur'),
            'livreur_id'=>$livreur['id'],
            'fournisseur_id'=>$fournisseur['id'],
            'date_livraison'=>$request->get('date_livraison'),
            'acteur'=>$acteur,
            'en_preparation'=>$dat,
            'creance_livreur'=>'non solder',
            'creance_fournisseur'=>'non solder',
            'id_acteur'=>$id_acteur,   
        ]);
        $commande->produit = $produits; 
        $commande->total = $total; 
        try {
            file_put_contents('img/codebars/'.$request['code_tracking'].'.svg', DNS1D::getBarcodeSVG($request['code_tracking'], 'C128'));    
            $commande->save();
        } catch (\Throwable $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
        return redirect()->route('commande.index')->with('success', 'commande inséré avec succés ! ');

    }
     public function store(Request $request)
    {       
        $produits = array();
        $total_produit = 0;
        $total= 0;
        $acteur = "";
        $id_acteur = 0;        
        $fournisseur = json_decode($request->get('fournisseur'), true);
        
        foreach ($request['dynamic_form']['dynamic_form'] as $array) {

            if ($array['produit'] and $array['quantite']) {
                $produit_json = json_decode($array['produit'], true);
                $produit  = Produit::find($produit_json['id']);
                $qteOld = $produit->quantite;
                $qteNew = $qteOld - $array['quantite'];  
                $produit->quantite = $qteNew;
                $produit->save();
                $total_produit = 1*$array['prix'];
                $total = $total + $total_produit;
    
                $produit_json['quantite'] = $array['quantite'];
                $produit_json['prix_vente'] = $array['prix'];
                array_push($produits,$produit_json);
    
                $stock = new  Stock();
                $stock->produit = $array['produit'];
                $stock->produit_id = $produit->id;//$array['produit'];
                $stock->fournisseur_id = $fournisseur['id'];//$fournisseur->id;//$array['produit'];
                $stock->quantite = $array['quantite'];
                $stock->operation = 'sortie';
                $stock->save();                    
            }else{
                return redirect()->back()->with('error', 'vous avez essayé d\'insére une comamnde sans articlees ! ');
            }
        }    
        $produits = json_encode($produits);
        $livreur = json_decode($request->get('livreur'), true);
        $dat = Carbon::now();
        $commande = new Commande([
            'prix'=>$request->get('prix'),
            'code_tracking'=> $request['code_tracking'],
            'nom_client'=>$request->get('nom_client'),
            'telephone'=>$request->get('telephone'),
            'wilaya'=>$request->get('wilaya_id'),
            'commune'=>$request->get('commune'),
            'note'=>$request->get('note'),
            // 'type'=>'colier',
            'type'=>'arrive',
            'confirmed'=>0,
            'adress'=>$request->get('adress') ?? '',
            'state'=>'en_preparation',
            'livreur'=>$request->get('livreur'),
            'fournisseur'=>$request->get('fournisseur'),
            'livreur_id'=>$livreur['id'],
            'fournisseur_id'=>$fournisseur['id'],
            'date_livraison'=>$request->get('date_livraison'),
            'acteur'=>$acteur,
            'id_acteur'=>$id_acteur,
            'en_preparation'=>$dat,
            'creance_livreur'=>'non solder',
            'echange_nouveau'=>$request['echange_nouveau'],
            'creance_fournisseur'=>'non solder',
        ]);
        file_put_contents('img/codebars/'.$request['code_tracking'].'.svg', DNS1D::getBarcodeSVG($request['code_tracking'], 'C128'));    
        $commande->produit = $produits; 
        $commande->total = $total; 
        try {
            $commande->save();
        } catch (\Throwable $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }

        return redirect()->route('coliers')->with('success', 'commande inséré avec succés ! ');
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

    public function affecter($livreur)
    {
        $_livreur = $livreur;
        $wilayas =Wilaya::all();
        // $commandes = Commande::where('id','>',0)->get();
        $commandes = Commande::where('type', '=', 'colier')->get();
        return view('commandes.affecter',compact('commandes','wilayas','_livreur'));
    }

    public function confirmer($fournisseur)
    {
        $_fournisseur = $fournisseur;
        $commandes = Commande::where([
            ['fournisseur_id','=',$fournisseur],
            ['type', '=', 'arrive'],
        ])->get();
    return view('commandes.confirmer',compact('commandes','_fournisseur'));
    }


    public function retourListLs(Request $request,$livreur)
    {
        $l = Livreur::find($livreur);
        $data = explode(',',  $_GET['id']);
        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande =  Commande::find($c);
                $commande->state = 'retour_ls';
                $dat = Carbon::now();
                Commande::where('id', '=', $commande->id)->update(['retour_ls' => $dat]);
                $commande->type_retour = 'retour_ls';
                $commande->save();
            }
        }
        return redirect()->route('livreur.filter',['livreur'=>$livreur])->with('success', 'les commandes ont été retirés  ');           
    }

    public function retourListStock(Request $request)
    {
        $data = explode(',',  $_GET['id']);
        foreach ($data as $key => $c) {
            if (strlen($c)) {
                $commande =  Commande::find($c);        

                $commande->state = 'retour_client';
                $dat = Carbon::now();
                Commande::where('id', '=', $commande->id)->update(['retour_client' => $dat]);
                $commande->type_retour = 'retour_client';
                $commande->state = 'retour_client';
                $commande->save();
            }
        }
        return redirect()->route('commande.retour.list.ls')->with('success', 'les commandes ont été mises retour client ');           
    }
    public function ListRetourCommandes()
    {
        $wilayas =Wilaya::all();
        $commandes = Commande::where('type_retour', '=', 'retour_ls')->get();
        return view('commandes.retour-list',compact('commandes','wilayas'));
    }
    public function retourStockOne($commande)
    {
        $wilayas =Wilaya::all();
        $commandes = Commande::where('type_retour', '=', 'retour_ls')->get();
        return view('commandes.retour-list',compact('commandes','wilayas'));
    }

    
    // public function retourAction($commande , $livreur)
    // {   
    //     $commande =  Commande::find($commande);
    //     $livreurs = Livreur::all();
    //     $l = Livreur::find($livreur);
    //     $commande->livreur = json_encode($l, true);
    //     $commande->livreur_id = $livreur;
    //     $commande->save();
    //     return redirect()->route('livreur.filter',['livreur'=>$livreur])->with('success', 'la commande a été accordée ');           
    // }

    public function retour($livreur)
    {
        $_livreur = $livreur;
        $wilayas =Wilaya::all();
        $commandes = Commande::where([
            ['livreur_id','=',$livreur],
            ['type', '=', 'colier'],
        ])->get();
        // $commandes = DB::table('commandes')->where('livreur_id',$livreur)->orderBy('id', 'ASC')->paginate(10);
        return view('commandes.retour',compact('commandes','wilayas','_livreur'));
    }


    public function commanded($livreur)
    {
        $_livreur = $livreur;
        $wilayas =Wilaya::all();
        $commandes = Commande::where([
            ['livreur_id','=',$livreur],
            ['type', '=', 'colier'],
        ])->get();

        $commandes = DB::table('commandes')->where('livreur_id',$livreur)->orderBy('id', 'ASC')->paginate(10);
        return view('commandes.retour',compact('commandes','wilayas','_livreur'));
    }



    public function detacher($livreur)
    {
        $_livreur = $livreur;
        $wilayas =Wilaya::all();
        $commandes = DB::table('commandes')->where('livreur_id',$livreur)->orderBy('id', 'ASC')->get();
        return view('commandes.detacher',compact('commandes','wilayas','_livreur'));
    }


    public function assigner($commande , $livreur)
    {   
        $commande =  Commande::find($commande);
        if ($commande->livreur_id != null) {
            return redirect()->back()->with('error', 'la commande a été déja affecté !');           
        }
        $livreurs = Livreur::all();
        $l = Livreur::find($livreur);
        $commande->livreur = json_encode($l, true);
        $dat = Carbon::now();
        Commande::where('id', '=', $commande->id)->update(['sortie' => $dat]);
        $commande->livreur_id = $livreur;
        $commande->state = 'sortie';
        
        $commande->save();

        return redirect()->route('livreur.filter',['livreur'=>$livreur])->with('success', 'la commande a été accordée ');           
    }
    
    public function desassigner($commande , $livreur)
    {   
        $commande =  Commande::find($commande);
        $livreurs = Livreur::all();
        $l = Livreur::find($livreur);
        $commande->livreur = json_encode($l, true);
        $commande->livreur_id = $livreur;
        $commande->save();

        return redirect()->route('livreur.filter',['livreur'=>$livreur])->with('success', 'la commande a été accordée ');           
    }

    public function edit($id_commande)
    {
        $livreurs =Livreur::all();
        $fournisseurs =Fournisseur::all();
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $produits = Produit::all();
        $types = Type::all();
        $commande = Commande::find($id_commande);
        $products = json_decode($commande->produit);
        return view('commandes.edit',compact('commande','wilayas','communes','produits','livreurs','types','products','fournisseurs'));

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
        $commande = Commande::find($commande);
        $produits = array();
        $total_produit = 0;
        $total= 0;
        $acteur = "";
        $id_acteur = 0;        
        $fournisseur = $commande->fournisseur_id;
        
        // dd($request['dynamic_form']['dynamic_form']);
        foreach ($request['dynamic_form']['dynamic_form'] as $array) {
            if(!is_null($array['prix'])){
                $produit_json = json_decode($array['produit'], true);
                $produit  = Produit::find($produit_json['id']);
                $qteOld = $produit->quantite;
                $qteNew = $qteOld - $array['quantite'];  
                $produit->quantite = $qteNew;
                $produit->save();
                $total_produit = 1*$array['prix'];
                $total = $total + $total_produit;
                $produit_json['quantite'] = $array['quantite'];
                $produit_json['prix_vente'] = $array['prix'];
                array_push($produits,$produit_json);
    
                // $stock = new  Stock();
                // $stock->produit = $array['produit'];
                // $stock->produit_id = $produit->id;
                // $stock->fournisseur_id = $fournisseur;
                // $stock->quantite = $array['quantite'];
                // $stock->operation = 'sortie';
                // $stock->save();    
            }
        }    

        $produits = json_encode($produits);
        
        $commande->code_tracking=$request['code_tracking'];
        $commande->nom_client=$request->get('nom_client');
        $commande->telephone=$request->get('telephone');
        $commande->wilaya=$request->get('wilaya_id');
        $commande->commune=$request->get('commune');
        $commande->note=$request->get('note');
        $commande->adress=$request->get('adress');
        $commande->date_livraison=$request->get('date_livraison');
        $commande->produit = $produits; 
        $commande->total = $total; 
        $commande->produit = $produits; 

        $commande->save();
        return redirect()->route('commande.index')->with('success', 'commande inséré avec succés ! ');
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
                switch ($request['state']) {
                    case 'en_cours':
                        $c->en_cours = Carbon::now();
                        break;    
                    case 'sortie':
                        $c->sortie = Carbon::now();
                        break;    
                    case 'annule':
                        $c->annule = Carbon::now();
                        break;    
                    case 'reporte':
                        $c->reporte = Carbon::now();
                        break;    
                    case 'non_abouti':
                        $c->non_abouti = Carbon::now();
                        break;    
                    case 'ne_repond_pas':
                        $c->ne_repond_pas = Carbon::now();
                        break;    
                    case 'livree':
                        $c->livree = Carbon::now();
                        break;    
                    case 'retour_ls':
                        $c->retour = Carbon::now();
                        break; 
                }
            $c->state = $request['state'];
            $c->save();
            return redirect()->route('commande.index')->with('success', 'la commande a été modifié ');     
    }


    public function updateDate(Request $request)
    {
        $c = Commande::find($request['commande']);
        $c->date_livraison = $request['date_livraison'];                        
        $c->state = 'reporte';                                
        $dat = Carbon::now();
        Commande::where('id', '=', $c->id)->update(['reporte' => $dat]);
        $c->save();
        return redirect()->back()->with('success', 'la date de la commande a été modifié ');     
    }


    public function updateRetour($id_commande)
    {
        $commande = Commande::find($commande_id);
        $produits = json_decode($commande->reste,true) ?? json_decode($commande->produit,true) ;
        $products = json_decode($commande->reste,true) ?? json_decode($commande->produit,true) ;
        for ($key=0; $key < count($request['quantites']); $key++) { 
            $produit = Produit::where('id',$produits[$key]['id'])->first();            
            // $produits[$key]['quantite'] += $request['quantites'][$key];    
            // $products[$key]['quantite'] = $request['quantites'][$key];     
            $stock = new  Stock();
            $stock->produit = json_encode($produit);
            $stock->quantite = $request['quantites'][$key];
            $stock->operation = 'entré';
            $stock->save(); 
            // $produit->quantite = $produit->quantite + $request['quantites'][$key];
            // $produit->save();            
 
        }
        $commande->save();    
        return redirect()->route('commande.index')->with('success', 'la commande a été modifié ');     
    }
    
    public function updateCredit(Request $request)
    {
        $c = Commande::find($request['commande']);

        $c->credit_livreur = $request['montant_credit'];
        $c->save();
        return redirect()->route('home')->with('success', 'crédit a été inséré !');     
    }


    public function setState($commande,$state){
        $c = Commande::find($commande);
        $livreur_id = $c->livreur_id;
        $c->state = $state;
        $dat = Carbon::now();
        Commande::where('id', '=', $c->id)->update([$state => $dat]);
        $c->save();
        // return redirect()->route('livreur.filter',['livreur'=>$livreur_id])->with('success', 'l\'état  a été  modifié');           
        return redirect()->back()->with('success', 'l\'état  a été  modifié');
    }

    public function timeline($id_commande){
        $commande =  Commande::find($id_commande);
        return view('commandes.timeline',compact('commande'));
    }

    public function NonAbouti($id_commande){
        $commande =  Commande::find($id_commande);
        $livreur_id = $commande->livreur_id;
        $commande->state = 'non abouti';
        $commande->save();
        return redirect()->back()->with('success', 'l\'état  a été  modifié');           
    }


    public function editDeleteProduit($commande,$index)
    {
        $commande = Commande::find($commande);
        $products = json_decode($commande->produit);
        unset($products[$index]);
        $products = json_encode($products,true);
        $commande->produit = $products;
        $commande->save();
        return redirect()->route('commande.edit',['commade'=>$commande->id])->with('success', 'la commande a été  annulé');           
    }
    public function fournisseur($fournisseur)
    {
        
    }
}
