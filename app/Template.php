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
    
    public static function templateBon($commande,$margin,$codebar,$number) 
    {
        $codebar = asset($codebar);
        $html='
            <div style="position:absolute;left:50%;margin-left:-65px;top:-45px;width:283px;height:283px;overflow:hidden">
                <div style="position:absolute;left:20.89px;top:10px" class="cls_002">
                    <span class="cls_002">
                        <img src="'.$codebar.'" width="50px" height="60px">
                    </span>
                    <div style="position:absolute;left:1.89px;top:50px;font-size:5px;" class="cls_006">
                        '.$number.'
                    </div>
                
                </div>ref1n439id489
                
            </div>
                ';
        return $html;

    }

    public static  function bl(Ticket $ticket)
    {
        $html = '        
            <!doctype html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
            <title>Aloha!</title>
            
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
                    <td valign="top"><img src="https://via.placeholder.com/150" alt="" width="150"/></td>
                    <td align="right">
                        <h3>Shinra Electric power company</h3>
                        <pre>
                            Company representative name
                            Company address
                            Tax ID
                            phone
                            fax
                        </pre>
                    </td>
                </tr>
            
            </table>
            
            <table width="100%">
                <tr>
                    <td><strong>From:</strong> Linblum - Barrio teatral</td>
                    <td><strong>To:</strong> Linblum - Barrio Comercial</td>
                </tr>
            
            </table>
            
            <br/>
            
            <table width="100%">
                <thead style="background-color: lightgray;">
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price $</th>
                    <th>Total $</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Playstation IV - Black</td>
                    <td align="right">1</td>
                    <td align="right">1400.00</td>
                    <td align="right">1400.00</td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td>Metal Gear Solid - Phantom</td>
                    <td align="right">1</td>
                    <td align="right">105.00</td>
                    <td align="right">105.00</td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td>Final Fantasy XV - Game</td>
                    <td align="right">1</td>
                    <td align="right">130.00</td>
                    <td align="right">130.00</td>
                </tr>
                </tbody>
            
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td align="right">Subtotal $</td>
                        <td align="right">1635.00</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td align="right">Tax $</td>
                        <td align="right">294.3</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td align="right">Total $</td>
                        <td align="right" class="gray">$ 1929.3</td>
                    </tr>
                </tfoot>
            </table>
            
            </body>
            </html>        
        
        ';
        return $html;   
    }

}