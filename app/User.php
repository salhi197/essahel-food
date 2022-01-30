<?php



namespace App;

use App\Wilaya;

use App\Commune;

use App\Commande;

use App\Produit;

use App\Livreur;

use App\User;



use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable

{

    use Notifiable;


    protected $guard = 'user';


    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'name', 'email', 'password',

    ];



    /**

     * The attributes that should be hidden for arrays.

     *

     * @var array

     */

    protected $hidden = [

        'password', 'remember_token',

    ];



    public function getWilaya()

    {

        return Wilaya::where('id',$this->wilaya_id)->first()['name'] ?? '';

    }

   

    public function getCommune()

    {

        return Commune::where('id',$this->wilaya_id)->first()['name'] ?? '';

    }


    public function data()

    {


        $commandes = Commande::all()->count();
        
        $en_attente = Commande::where('state',0)->get();
        $accepter = Commande::where('state',1)->get();
        $expédier = Commande::where('state',2)->get();
        $retour = Commande::where('state',-1)->get();


        $livreurs = Livreur::all()->count();
        $produits = Produit::all()->count();
        $produits = Produit::all()->count();
        
        $users = User::all()->count();
        $data = [
            'livreurs'=>$livreurs,
            'commandes'=>$commandes,
            'produits'=>$produits,
            'users'=>$users,

        ];
        return $data;        
      

    }    



}

