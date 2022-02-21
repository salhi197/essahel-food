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
        $sortie = $ticket->getSortie();
        $livreur = $ticket->getLivreur();
        
        $html = '        
            <!doctype html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
            <title>Bon de livraison </title>
            
            <style type="text/css">
                * {
                    font-size:15px;
                    font-family: Verdana, Arial, sans-serif;
                }
                table{
                    font-size: x-small;
                }
                 tr td{
                    font-weight: bold;

                    text-align:center;
                }

                tfoot tr td{
                    font-weight: bold;

                    text-align:center;
                }
                
            </style>
            
            </head>
            <body>
            
            <table width="100%">
                <tr>
                    <td valign="top"></td>
                    <td align="center">
                        <h1>Essahel Food</h1>
                        
                    </td>
                </tr>
            
            </table>
            
            <table width="100%">
                <tr>
                    <td><strong>Livreur:</strong> '.$livreur->prenom.'</td>
                </tr>
                <tr>
                    <td><strong>Téléphone:</strong> '.$livreur->telephone.'</td>
                </tr>
                <tr>
                    <td><strong>Date de Sortie:</strong> '.$sortie->created_at.'</td>
                </tr>
            
            </table>
            
            <br/>
            
            <table width="100%">
                <thead style="background-color: lightgray;">
                <tr>
                    <th style="cursor:pointer;">créé le</th>
                    <th style="cursor:pointer;">Mis à jour le : </th>
                    <th style="cursor:pointer;"> nom de produit</th>
                    <th style="cursor:pointer;">code bar </th>
                    <th style="cursor:pointer;">Staut </th>
                    <th style="cursor:pointer;">N°ticket_produit </th>
                </tr>
                </thead>
                <tbody>
                                                <tr id="">
                                                    <td>'.date('d-m-Y h:m:s',strtotime($ticket->created_at)).'</td>
                                                    <td>'.date('d-m-Y h:m:s',strtotime($ticket->updated_at)).'</td>
                                                    <td>'.$ticket->getProduit()['nom'].'</td>
                                                    <td>'.$ticket->codebar .'</td>
                                                    
                                                    <td >

                                                        '. $ticket->satut .'
                                                    </td>
                                                    
                                                    <td>'.$ticket->num_ticket_produit .'</td>                                                
                                                                                                
                                                </tr>                

                </tbody>
            
                
            </table>
            
            </body>
            </html>        
        
        ';
        return $html;   
    }

}