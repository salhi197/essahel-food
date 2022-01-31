<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{

    public function livreur()
    {
        return $this->belongsTo('App\Livreur');
    }
    
    public function produits()
    {
        return $this->hasMany('App\Produit');
    }
    
    


    public static function templateA4($commande,$margin) {

        $commande = Commande::find($commande);
        $produits = json_decode($commande->produit);
        $total = $commande->getTotal();
        $current = date('Y-m-d');
        $fournisseur = json_decode($commande->fournisseur); 
        $livreur = json_decode($commande->livreur); 
        // $livreur->name
        // $livreur->prenom
        // $livreur->telephone
        $codebar = asset("img/codebars/".$commande->code_tracking.".svg");
        $html='
            <div style="position:absolute;left:50%;margin-left:-297px;top:'.(int)($margin+0).'px;width:795px;height:550px;overflow:hidden">
            <div style="position:absolute;left:0px;top:'.(int)($margin+0).'px">
                <img src="'.asset("img/background2.jpg").'" width=595 height=841></div>
                <div style="position:absolute;left:144.73px;top:'.(int)($margin+22.56).'px" class="cls_002"><span class="cls_002">Date</span></div>
                <div style="position:absolute;left:172.57px;top:'.(int)($margin+22.56).'px" class="cls_002"><span class="cls_002">'.$current.'</span></div>
                <div style="position:absolute;left:306.49px;top:'.(int)($margin+23.04).'px" class="cls_002"><span class="cls_002">Numéro Téléphone</span></div>
                <div style="position:absolute;left:306.49px;top:'.(int)($margin+40.04).'px" class="cls_002"><span class="cls_002">Fournisseur : </span></div>
                <div style="position:absolute;left:404.89px;top:'.(int)($margin+22.52).'px" class="cls_007"><span class="cls_007">'.$fournisseur->num_service.'</span></div>
                <div style="position:absolute;left:404.89px;top:'.(int)($margin+40.52).'px" class="cls_007"><span class="cls_007">'.$fournisseur->nom_prenom.'</span></div>
                <div style="position:absolute;left:144.25px;top:'.(int)($margin+40.32).'px" class="cls_002"><span class="cls_002">'.$commande->code_tracking.' </span></div>
                <div style="position:absolute;left:510.97px;top:'.(int)($margin+15.24).'px" class="cls_006"><span class="cls_006">'.$commande->code.'</span></div>
                <div style="position:absolute;left:20.89px;top:'.(int)($margin+33.36).'px" class="cls_002"><span class="cls_002"><img src="'.$codebar.'" width=80 height=30></span></div>
                <div style="position:absolute;left:20.89px;top:'.(int)($margin+22.36).'px" class="cls_002"><span class="cls_002">'.$commande->code_tracking.'</span></div>
                ';
        if($livreur){
            $html =$html.'
                <div style="position:absolute;left:500.33px;top:'.(int)($margin+33.56).'px" class="cls_003"><span class="cls_003" >Livreur : '.$livreur->name.' | '.$livreur->prenom.' </span></div>
                <div style="position:absolute;left:500.33px;top:'.(int)($margin+44.56).'px" class="cls_003"><span class="cls_003" >Téléphone : '.$livreur->telephone.' </span></div>    
            ';
        }


            $html = $html.'<div style="position:absolute;left:500.33px;top:'.(int)($margin+22.56).'px" class="cls_003"><span class="cls_003" >'.$current.' </span></div>


                <div style="position:absolute;left:526.33px;top:'.(int)($margin+55.56).'px" class="cls_005"><span class="cls_005" style="font-size:25px;">'.$commande->wilaya.'</span></div>
                <div style="position:absolute;left:510.33px;top:'.(int)($margin+88.56).'px" class="cls_005"><span class="cls_005" style="font-size:10px;">'.$commande->commune.'-'.Commande::getWilaya($commande->wilaya).'</span></div>

                <div style="position:absolute;left:131.77px;top:'.(int)($margin+84.92).'px" class="cls_003"><span class="cls_003">Produit</span></div>
                <div style="position:absolute;left:269.69px;top:'.(int)($margin+84.92).'px" class="cls_003"><span class="cls_003">Qtn</span></div>
                <div style="position:absolute;left:289.69px;top:'.(int)($margin+84.92).'px" class="cls_003"><span class="cls_003">prix</span></div>
            ';
                $top = 20;
                $t=0;
                foreach($produits as $produit){
                    $produit = json_decode(json_encode($produit), true);
                    $t = $t+$produit['prix_vente'];
                    $html = $html.'
                        <div style="position:absolute;left:131.77px;top:'.(int)($margin+84.92+$top).'px" class="cls_003"><span class="cls_003">'.$produit['nom'].'</span></div>
                        <div style="position:absolute;left:269.69px;top:'.(int)($margin+84.92+$top).'px" class="cls_003"><span class="cls_003">'.$produit['quantite'].'</span></div>
                        <div style="position:absolute;left:289.69px;top:'.(int)($margin+84.92+$top).'px" class="cls_003"><span class="cls_003">'.$produit['prix_vente'].'</span></div>
                    ';
                    $top = $top+10;
                }
        

                $html=$html.'
                <div style="position:absolute;left:319.45px;top:'.(int)($margin+104.16).'px" class="cls_008"><span class="cls_008">Client : </span></div>
                <div style="position:absolute;left:319.45px;top:'.(int)($margin+124.16).'px" class="cls_008"><span class="cls_008">Téléphone  client : </span></div>

                <div style="position:absolute;left:370.45px;top:'.(int)($margin+104.16).'px" class="cls_008"><span class="cls_008">'.$commande->nom_client.'</span></div>
                <div style="position:absolute;left:395.45px;top:'.(int)($margin+124.16).'px" class="cls_008"><span class="cls_008">'.$commande->telephone.'</span></div>
                <div style="position:absolute;left:519.13px;top:'.(int)($margin+112.80).'px" class="cls_008"><span class="cls_008">ReportÈ Le</span></div>
                <div style="position:absolute;left:349.69px;top:'.(int)($margin+149.28).'px" class="cls_008"><span class="cls_008">++++++++++++++++++++++++</span></div>
                <div style="position:absolute;left:529.21px;top:'.(int)($margin+149.28).'px" class="cls_008"><span class="cls_008">N.R.P</span></div>
                <div style="position:absolute;left:351.13px;top:'.(int)($margin+166.56).'px" class="cls_004"><span class="cls_004">Note  : '.$commande->note.'</span></div>
                <div style="position:absolute;left:268.09px;top:'.(int)($margin+167.48).'px" class="cls_010"><span class="cls_010">'.$t.' Da</span></div>
                <div style="position:absolute;left:254.65px;top:'.(int)($margin+189.12).'px" class="cls_008"><span class="cls_008">SociÈtÈ de livraison Ls-Rapide</span></div>
            </div>
        
        ';
         return $html;

    

    }
    
    public static function templateTicket($commande) {
        $commande = Commande::find($commande);
        $current = date('Y-m-d');
        $produits = json_decode($commande->produit);
        $total = $commande->getTotal();
        $fournisseur = json_decode($commande->fournisseur); 

        $html='

        <div style="position:absolute;left:50%;margin-left:-141px;top:0px;width:283px;height:283px;overflow:hidden">
        <div style="position:absolute;left:0px;top:0px">
        <img src="'.asset("img/background3.jpg").'" width=283 height=283></div>
        <div style="position:absolute;left:218.88px;top:45.41px" class="cls_008"><span style="font-size:11px;" class="cls_008">'.$commande->code_tracking.'</span></div>
        <div style="position:absolute;left:222.88px;top:65.41px" class="cls_008"><span style="font-size:11px;" class="cls_008">'.$current.'</span></div>
        <div style="position:absolute;left:44.16px;top:11.65px" class="cls_003"><span class="cls_003">Fournisseur : </span></div>
        <div style="position:absolute;left:92.16px;top:11.65px" class="cls_003"><span class="cls_003">'.$fournisseur->nom_prenom        .'</span></div>
        <div style="position:absolute;left:20.76px;top:45.73px" class="cls_003"><span class="cls_003">N° Service Client</span></div>
        <div style="position:absolute;left:90.32px;top:45.21px" class="cls_004"><span class="cls_004">'.$commande->telephone.'</span></div>
        <div style="position:absolute;left:210.24px;top:50.33px" class="cls_002"><span class="cls_002">'.$commande->code.'</span></div>
        <div style="position:absolute;left:47.04px;top:75.01px" class="cls_003"><span class="cls_003">Nom: '.$commande->nom_client.'</span></div>
        <div style="position:absolute;left:225.24px;top:130.77px" class="cls_006"><span class="cls_006">'.Commande::getWilaya($commande->wilaya).'</span></div>
        <div style="position:absolute;left:220.24px;top:79.77px; class="cls_006"><span style="font-size:40px;" class="cls_006">'.$commande->wilaya.'</span></div>
        <div style="position:absolute;left:148.80px;top:85.57px" class="cls_003"><span class="cls_003">Fragile</span></div>
        <div style="position:absolute;left:47.04px;top:96.13px" class="cls_003"><span class="cls_003">'.$commande->telephone.'</span></div>
        <div style="position:absolute;left:17.28px;top:120.65px" class="cls_007"><span class="cls_007">Produit</span></div>
        <div style="position:absolute;left:125.44px;top:120.65px" class="cls_007"><span class="cls_007">Qtn</span></div>
        <div style="position:absolute;left:150.44px;top:120.65px" class="cls_007"><span class="cls_007">prix</span></div>
        ';
        
        $margin = 140.17;
        $t= 0;
        foreach($produits as $produit){
            $produit = json_decode(json_encode($produit), true);
            $t = $t+$produit['prix_vente'];
            $html = $html.'
                <div style="position:absolute;left:17.28px;top:'.$margin.'px" class="cls_007"><span class="cls_007">'.$produit['nom'].'</span></div>
                <div style="position:absolute;left:125.44px;top:'.$margin.'px" class="cls_007"><span class="cls_007">'.$produit['quantite'].'</span></div>    
                <div style="position:absolute;left:150.44px;top:'.$margin.'px" class="cls_007"><span class="cls_007">'.$produit['prix_vente'].'</span></div>    
                
            ';
            $margin = $margin+10;
        }





        $html=$html.'<div style="position:absolute;left:220.24px;top:153.29px" class="cls_007"><span class="cls_007">'.$commande->commune.'</span></div>
        <div style="position:absolute;left:54.72px;top:200.17px" class="cls_009"><span class="cls_009">Total</span></div>
        <div style="position:absolute;left:96.96px;top:200.17px" class="cls_009"><span class="cls_009">'.$t.' Da</span></div>
        <div style="position:absolute;left:49.92px;top:224.29px" class="cls_003"><span class="cls_003">++++++++++++++++++++++++</span></div>
        <div style="position:absolute;left:50.88px;top:241.57px" class="cls_006"><span class="cls_006">Aucun Article a Recuperer</span></div>
        </div>    
        ';
            return $html;

    }



    protected $fillable = [
        'produit',
        'code_tracking',
        'quantite',
        'prix',
        'prix_livraison',
        'command_express',
        'nom_client',
        'total',
        'telephone',
        'fournisseur',
        'adress',
        'date_livraison',
        'wilaya',
        'commune',
        'note',
        'state',
        'livreur',
        'livreur_id',
        'fournisseur_id',
        'acteur',
        'id_acteur',
        'credit_livreur',
        'boutique'
    ];

    
    public static function templateBon($commande,$margin,$codebar,$number) 
    {
        $codebar = asset($codebar);
        $html='
            <div style="position:absolute;left:50%;margin-left:-70px;top:0px;width:283px;height:283px;overflow:hidden">
                <div style="position:absolute;left:20.89px;top:10px" class="cls_002">
                    <span class="cls_002">
                        <img src="'.$codebar.'" width=80 height=30>
                    </span>
                </div>
                <div style="position:absolute;left:20.89px;top:70px" class="cls_006">
                    '.$number.'
                </div>
                
            </div>
                ';
        return $html;
    }


}
