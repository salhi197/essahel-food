<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Template;
class Commande extends Model
{

    public function livreur()
    {
        return $this->belongsTo('App\Livreur');
    }
    
    public function produits()
    {
        return $this->hasMany('App\Produit');
    }



    
    public static function template2($commande){
        $commande = Commande::find($commande);
        $html='
        <html style="page-break-before: always;">
        <head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
        <style type="text/css">
        <!--
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
        -->
        </style>
        <script type="text/javascript" src="a75dddf0-3997-11eb-8b25-0cc47a792c0a_id_a75dddf0-3997-11eb-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
        </head>
        <body>
        <div style="position:absolute;left:50%;margin-left:-141px;top:0px;width:283px;height:283px;border-style:outset;overflow:hidden">
        <div style="position:absolute;left:0px;top:0px">
        <img src="'.asset("img/background1.jpg").'" width=283 height=283></div>
        <div style="position:absolute;left:218.88px;top:7.41px" class="cls_008"><span class="cls_008">'.$commande->code_tracking.'</span></div>
        <div style="position:absolute;left:44.16px;top:11.65px" class="cls_003"><span class="cls_003">27/09/2020</span></div>
        <div style="position:absolute;left:41.76px;top:45.73px" class="cls_003"><span class="cls_003">N° Service Client</span></div>
        <div style="position:absolute;left:124.32px;top:45.21px" class="cls_004"><span class="cls_004">0658634233</span></div>
        <div style="position:absolute;left:210.24px;top:4.33px" class="cls_002"><span class="cls_002">30</span></div>
        <div style="position:absolute;left:214.08px;top:55.13px" class="cls_005"><span class="cls_005">'.Commande::getWilaya($commande->wilaya).'</span></div>
        <div style="position:absolute;left:47.04px;top:75.01px" class="cls_003"><span class="cls_003">Nom: '.$commande->nom_client.'</span></div>
        <div style="position:absolute;left:222.24px;top:80.77px" class="cls_006"><span class="cls_006">'.Commande::getWilaya($commande->wilaya).'</span></div>
        <div style="position:absolute;left:148.80px;top:85.57px" class="cls_003"><span class="cls_003">Fragile</span></div>
        <div style="position:absolute;left:47.04px;top:96.13px" class="cls_003"><span class="cls_003">'.$commande->telephone.'</span></div>
        <div style="position:absolute;left:17.28px;top:120.65px" class="cls_007"><span class="cls_007">Produit</span></div>
        <div style="position:absolute;left:169.44px;top:120.65px" class="cls_007"><span class="cls_007">Qtn</span></div>
        <div style="position:absolute;left:221.76px;top:153.29px" class="cls_007"><span class="cls_007">ReportÈ Le</span></div>
        <div style="position:absolute;left:231.84px;top:190.25px" class="cls_007"><span class="cls_007">N.R.P</span></div>
        <div style="position:absolute;left:54.72px;top:200.17px" class="cls_009"><span class="cls_009">Total</span></div>
        <div style="position:absolute;left:96.96px;top:200.17px" class="cls_009"><span class="cls_009">'.$commande->total.' Da</span></div>
        <div style="position:absolute;left:49.92px;top:224.29px" class="cls_003"><span class="cls_003">++++++++++++++++++++++++</span></div>
        <div style="position:absolute;left:50.88px;top:241.57px" class="cls_006"><span class="cls_006">Aucun Article a Recuperer</span></div>
        <div style="position:absolute;left:46.08px;top:266.57px" class="cls_007"><span class="cls_007">SociÈtÈ de livraison LsRapide </span></div>
        </div>    
        </body>
        </html>                
    
        ';

         return $html;
        
    }
    public static function templateA4($commande,$margin) {
        $current = date('Y-m-d');
        $html=Template::templateA4($commande,$margin);
        return $html;   
    }

    public static function templateBon($commande,$margin,$codebar) {
        $current = date('Y-m-d');
        $html=Template::templateBon($commande,$margin,$codebar);
        return $html;   
    }


    public static function templateTicket($commande) {
        $current = date('Y-m-d');
        $html=Template::templateTicket($commande);
        return $html;

    }



    protected $fillable = [
        'confirmation_telephonique',
        'gestion_stock',
        'produit',
        'code_tracking',
        'quantite',
        'prix',
        'prix_livraison',
        'command_express',
        'nom_client',
        'type_retour',
        'total',
        'telephone',
        'fournisseur',
        'adress',
        'date_livraison',
        'echange_nouveau',
        'wilaya',
        'commune',
        'note',
        'state',
        'solded_by_admin',
        'livreur',
        'livreur_id',
        'fournisseur_id',
        'acteur',
        'isRetour',
        'id_acteur',
        'confirmed',
        'credit_livreur',
        'creance',
        'creance_livreur',
        'creance_fournisseur',
     
        'en_preparation',
        'en_cours',
        'retour_ls',
        'retour_client',
        'tarif_confirmation',
        'type'
    ];
    
    public function getTotal()
    {
        $total_produit = 0;
        $total = 0;
        $produits = json_decode($this->produit);
        foreach($produits as $produit){
            $produit = json_decode(json_encode($produit), true);
            $total_produit = 1*$produit['prix_vente'];
            $total = $total + $total_produit;
        }
        return $total_produit; 
    }
    public static function getWilaya($wilaya)
    {
        $nom_wilaya = Wilaya::where('code',$wilaya)->first();
        if($nom_wilaya){
            return $nom_wilaya->name;
        }else{
            return 'non spécifié';
        }

    }

    
    public static function getWilayaNonAboutiTarif($wilaya)
    {
        $nom_wilaya = Wilaya::find($wilaya);
        if($nom_wilaya){
            return $nom_wilaya->abouti;
        }else{
            return 0;
        }

    }


    public static function getWilayaLivreurTarif($wilaya)
    {
        $nom_wilaya = Wilaya::find($wilaya);
        if($nom_wilaya){
            return $nom_wilaya->livreur;
        }else{
            return 0;
        }

    }

    public static function getWilayaFournisseurTarif($wilaya)
    {
        $nom_wilaya = Wilaya::find($wilaya);
        if($nom_wilaya){
            return $nom_wilaya->fournisseur;
        }else{
            return 0;
        }

    }

    public static function getWilayaFournisseurNonAboutiTarif($wilaya)
    {
        $nom_wilaya = Wilaya::find($wilaya);
        if($nom_wilaya){
            return $nom_wilaya->abouti_fournisseur;
        }else{
            return 0;
        }

    }

    public static function getWilayaLivreurNonAboutiTarif($wilaya)
    {
        $nom_wilaya = Wilaya::find($wilaya);
        if($nom_wilaya){
            return $nom_wilaya->abouti_livreur;
        }else{
            return 0;
        }

    }

    public static function getCommune($commune)
    {
        $nom_wilaya = Commune::find($commune);
        return $nom_wilaya['name'];
    }

    public function isFournisseurHasPhone()
    {
        $commande = Commande::find($this->id);

        $fournisseur = Fournisseur::find($commande->fournisseur_id);
        if($fournisseur){
            // json_decode($commande->fournisseur_); 
            if($fournisseur->confirmation_telephonique == 1){
                return 1;
            }else{
                return 0;
            }
        }
    }

    public static function setState($commande,$state)
    {
        $c = Commande::find($commande);
        $c->state = $state;
        $dat = Carbon::now();
        try {
            Commande::where('id', '=', $c->id)->update([$state => $dat]);
            try {
                $c->save();
                return redirect()->back()->with('success', 'l\'état  a été  modifié');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'une erreur ...');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'une erreur ...');
        }
    }


}
