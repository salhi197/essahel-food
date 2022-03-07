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
        
    ];
    
    public static function templateBon($commande,$margin,$codebar,$number,$num_lot) 
    {
        $codebar = asset($codebar);
        $html='
            <div style="position:absolute;left:50%;margin-left:-40px;top:-35px;width:283px;height:283px;overflow:hidden">
                <div style="position:absolute;left:20.89px;top:10px" class="cls_002">
                    <span class="cls_002">
                        <img src="'.$codebar.'" width="50px" height="60px">
                    </span>
                    <div style="position:absolute;left:1.89px;top:50px;font-size:3px;" class="cls_006">
                        '.$number.'
                    </div>
                    <div style="position:absolute;left:0.5px;top:54px;font-size:12px;" class="cls_006"> Lot N° '.$num_lot.' </div>
                </div>
                
            </div>
                ';
        return $html;

    }

    public static  function bl(Livreur $livreur,$elements)
    {
        $total = 0;
        $total = 0;
        $html = '        
            <!doctype html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
            <title>Bon de livraison!</title>
            
            <style type="text/css">
                * {
                    font-family: Verdana, Arial, sans-serif;
                }
                table{
                    font-size: x-small;
                }
                tfoot tr td{
                    font-weight: bold;
                    font-size: x-small;
                }
                .gray {
                    background-color: lightgray
                }
            </style>
            
            </head>
            <body>
            
            <table width="100%">
                <tr>
                    <td align="left">
                        <h3>Essahel Food</h3>
                        <pre>
                            RC: 16/00-5127021A18
                            MF : 16302737197
                            Adresse : Alger CITE 32 KAIDI LOT 7 BORDK EL KIFFAN
                        </pre>
                    </td>
                    <td align="">
                        <h3>Client : Divers CLient 4</h3>
                        <pre>
                            RC :  Divers CLient 4
                            MF :  
                            Adresse : Alger 
                        </pre>
                    </td>

                </tr>
            
            </table>
            
            <table width="100%">
                <tr>
                    <td><strong>Suivi Par :</strong>Admin</td>
                    <td><strong>Facture Numéro:</strong>Admin</td>
                    <td><strong>Le:</strong> '.date('d-m-Y').'</td>
                </tr>
            
            </table>
            
            <br/>
            
            <table width="100%">
                <thead style="background-color: lightgray;">
                <tr>
                    <th style="cursor:pointer;">Nom Produit</th>
                    <th style="cursor:pointer;">Quantité </th>
                    <th style="cursor:pointer;">Prix Unitaire </th>
                    <th style="cursor:pointer;">Total </th>
                </tr>
                </thead>
                <tbody>
                    <tr>';
                    foreach($elements as $element){
                        $html = $html.'<td>'.$element->nom.'</td>';
                        $html = $html.'<td>'.$element->qte.'</td>';
                        $html = $html.'<td>'.$element->prix_gros.' DA</td>';
                        $html = $html.'<td>'.$element->prix_gros*$element->qte.' DA</td>';
                        $total = $total + $element->prix_gros*$element->qte;
                    }
                                                               
                $html=$html.'</tr>                
                </tbody>
            
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td align="right">Total HTA</td>
                        <td align="center">'.$total.' DA</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td align="center">Total TVA</td>
                        <td align="center">0.00</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td align="center">Total TTC</td>
                        <td align="right" class="gray">'.$total.' DA</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td align="center">Timbre</td>
                        <td align="right" class="gray"> </td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td align="center">Net à payer</td>
                        <td align="right" class="gray">'.$total.' DA</td>
                    </tr>

                </tfoot>
            </table>
            
            </body>
            </html>        
        
        ';
        return $html;   
    }

}