<?php

namespace App;

use App\Commande;

use App\Produit;

use App\Livreur;

use App\User;

use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;



class Admin extends Authenticatable

{

    use Notifiable;



    /**

     * @var string

     */

    protected $guard = 'admin';



    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'name', 'email', 'password','password_text','solde'

    ];



    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $hidden = [

        'password', 'remember_token',

    ];



    public function data()

    {

        $commandes_en_attente = Commande::where('state','en attente')->get()->count();
        $commandes= Commande::all()->count();
        $commandes_accepter = Commande::where('state','accepter')->get()->count();
        $commandes_livre = Commande::where('state','livre')->get()->count();
        $livreurs = Livreur::all()->count();
        $produits = Produit::all()->count();
        $users = User::all()->count();

        $data = [
            'commandes_en_attente'=>$commandes_en_attente,
            'commandes_accepter'=>$commandes_accepter,
            'commandes_livre'=>$commandes_livre,
            'livreurs'=>$livreurs,
            'produits'=>$produits,
            'users'=>$users,
            
            'commandes'=>$commandes,
            
        ];

        return $data;        

        

    }    

}

