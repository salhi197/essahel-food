<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use App\Wilaya;
use App\Template;
use App\Commande;
use App\Livreur;
use Dompdf\Dompdf;


class ImpressionController  extends Controller
{

    public function impression()
    {
        return view('impression');
    }


    public function imprimer(Request $request){

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
        $margin = 20;
        for($i=0;$i<$request['tickets'];$i++){
            if($i!=0 and $i%4==0){
                $html = $html.'
                <div class="page_breaking"></div>
                ';
                $margin = 0;                
            }
            $h = Commande::templateBon($i,$margin);
            $html=$html.$h;
            $margin = $margin+120;

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



    public function aboutis()
    {
        $wilayas = Wilaya::all();
        return view('wilayas-aboutis',compact('wilayas'));
    }

    public function aboutiLivreur(Request $request)
    {
        $wilaya = Wilaya::find($request['wilaya']);
        $wilaya->abouti_livreur = $request['abouti_livreur'];
        $wilaya->save();
        return redirect()->back()->with('success', 'insertion effectué !  ');     
    }

    public function aboutiFournisseur(Request $request)
    {
        // dd($request['abouti_fournisseur']);
        $wilaya = Wilaya::find($request['wilaya']);
        $wilaya->abouti_fournisseur = $request['abouti_fournisseur'];
        $wilaya->save();
        return redirect()->back()->with('success', 'insertion effectué !  ');     
    }



    public function fournisseurs()
    {
        $wilayas = Wilaya::all();
        return view('wilayas-fournisseurs',compact('wilayas'));
    }

    public function fournisseur(Request $request)
    {
        $wilaya = Wilaya::find($request['wilaya']);
        $wilaya->fournisseur = $request['fournisseur'];
        $wilaya->save();
        return redirect()->back()->with('success', 'insertion effectué !  ');     
    }



    public function livreurs()
    {
        $wilayas = Wilaya::all();
        return view('wilayas-livreurs',compact('wilayas'));
    }

    public function livreur(Request $request)
    {
        $wilaya = Wilaya::find($request['wilaya']);
        $wilaya->livreur = $request['livreur'];
        $wilaya->save();
        return redirect()->back()->with('success', 'insertion effectué !  ');     
    }



    public function livraison(Request $request)
    {
        $wilaya = Wilaya::find($request['wilaya']);
        $wilaya->livraison = $request['livraison'];
        $wilaya->save();
        return redirect()->route('wilaya.livreurs')->with('success', 'insertion effectué !  ');     
    }


}

