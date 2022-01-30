<?php



namespace App\Http\Controllers;



use App\Fournisseur;

use App\Commune;

use App\Commande;

use App\Wilaya;

use Hash;

use Auth;

use DB;

use Response;

use Illuminate\Http\Request;



class FournisseurController extends Controller

{



    public function __construct()

    {

        // $this->middleware('auth');

    }



    public function coliers($fournisseur)

    {

        $commandes = Commande::where([

                ['fournisseur_id','=',$fournisseur],

                ['type', '=', 'arrive'],

            ])->get();

        $communes = Commune::all();

        $fournisseurs = Fournisseur::all();

        $wilayas =Wilaya::all();



        return view('fournisseurs.coliers',compact('fournisseurs','commandes','data','communes','wilayas','fournisseur'));

    }



    public function journal($fournisseur_id)

    {

        $sql = "select * from commandes ";

        $sql = $sql.'where fournisseur_id='.$fournisseur_id.' and (state="Livree" or state="non abouti" or state="confirmer")';

        $commandes=DB::select(DB::raw($sql));

        

        $ValeurRapporte = 0;

        $fournisseur = Fournisseur::find($fournisseur_id);

        $RapporteAuLsRapide=0;

        $soldage=0;

        $RapporteAuLsRapide = $ValeurRapporte-$soldage;

        $fournisseurs = Fournisseur::all();        

        $_fournisseur = "";

        $debut_entre = "";

        $fin_entre ="";

        $creance="";

        $fournisseurMontant=0;

        $tarifTelephonique = 0;

        foreach ($commandes as $key => $commande) {

            if($commande->state == 'Livree' and $commande->creance_fournisseur == 'non solder')

            {

                $c = Commande::find($commande->id);

                $fournisseurMontant  = $fournisseurMontant + Commande::getWilayaFournisseurTarif($commande->wilaya);

                $ValeurRapporte = $ValeurRapporte+$commande->total;    

                $valuerJdida =$commande->total- Commande::getWilayaFournisseurTarif($commande->wilaya);

            }

            if($commande->state == 'non abouti' and $commande->creance_fournisseur == 'non solder')

            {

                $c = Commande::find($commande->id);

                $fournisseurMontant  = $fournisseurMontant + Commande::getWilayaFournisseurNonAboutiTarif($commande->wilaya);

                // $ValeurRapporte = $ValeurRapporte+$commande->total;    

            }

        }



        foreach ($commandes as $key => $commande) {

            if($commande->confirmed == 1 and $commande->creance_fournisseur == 'non solder')

            {

                $c = Commande::find($commande->id);

                if($c->isFournisseurHasPhone() == 1 ){

                    $tarifTelephonique=$tarifTelephonique+ 30;                         

                }

            }

        }





        $RapporteAuLsRapide = $ValeurRapporte-$fournisseurMontant;

        



        return view('fournisseurs.journal',compact('commandes','fournisseurs',

        'fournisseur',

        'creance','debut_entre','fin_entre','_fournisseur','soldage',

            'ValeurRapporte',

            'RapporteAuLsRapide',

            'fournisseurMontant',

            'RapporteAuLsRapide',

            'tarifTelephonique'

        ));

        

    }



    public function filter(Request $request)
    {
        $result = Commande::query();
        $debut_entre = "";
        $fin_entre = "";
        $id = Auth::guard('fournisseur')->id();
        if (!empty($request['debut_entre'])) {
            $debut_entre = $request['debut_entre'];
            $result = $result->whereDate('created_at', '>=', $request['debut_entre']);
        }

        if (!empty($request['fin_entre'])) {
            $fin_entre = $request['fin_entre'];
            $result = $result->whereDate('created_at', '<=', $request['fin_entre']);
        }
        $result = $result->where('fournisseur_id',$id);
        $commandes = $result->get();//->orderBy('sortie','asc');
        $wilayas =Wilaya::all();
        $f = Fournisseur::find($id);
        $confirmation  = $f->confirmation_telephonique;

        return view('fournisseurs',compact('commandes','communes','wilayas','debut_entre','fin_entre','confirmation'));
    }



    public function index()

    {

        $fournisseurs = Fournisseur::all();

        return view('fournisseurs.index',compact('fournisseurs'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $communes = Commune::all();

        $wilayas =Wilaya::all();

        return view('fournisseurs.create',compact('wilayas','communes'));

    }



    public function stock()

    {

        if(auth()->guard('fournisseur')->check()){

            $id = Auth::guard('fournisseur')->id();

            $communes = Commune::all();

            $wilayas =Wilaya::all();

            $produits = DB::select("select * from produits where fournisseur_id=$id");

                $fournisseurs =Fournisseur::all();

            $stocks = DB::select("select * from stocks where produit_id in (select id from produits where fournisseur_id=$id)");

            return view('stocks.index3',compact('stocks','fournisseurs','produits','communes','wilayas','id'));

        }                  

    }





    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $f = new Fournisseur();

        $f->nom_prenom = $request->get('nom_prenom');

        $f->telephone = $request->get('telephone');

        $f->email = $request->get('email');

        $f->num_service=$request->get('num_service');

        $f->wilaya = $request->get('wilaya_id');

        $f->commune_id = $request->get('commune_id');

        $f->adress = $request->get('adress');

        $f->password = Hash::make($request['password']);

        $f->password_text = $request['password'];

        $f->confirmation_telephonique = $request->input('confirmation_telephonique') ? 1 : 0;

        $f->gestion_stock = $request->input('gestion_stock') ? 1 : 0;

        $f->save();

        return redirect()->route('fournisseur.index')

            ->with('success', 'ajout efféctué !');

    }



    /**

     * Display the specified resource.

     *

     * @param  \App\Fournisseur  $fournisseur

     * @return \Illuminate\Http\Response

     */

    public function show(Fournisseur $fournisseur)

    {

        //

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Fournisseur  $fournisseur

     * @return \Illuminate\Http\Response

     */

    public function edit($fournisseur)

    {

        $communes = Commune::all();

        $wilayas =Wilaya::all();

        $fournisseur = Fournisseur::find($fournisseur);

        return view('fournisseurs.edit',compact('fournisseur','wilayas','communes'));

    }



    public function update(Request $request)

    {

        $fournisseur = Fournisseur::find($request['fournisseur_id']);

        $fournisseur->nom_prenom = $request->get('nom_prenom');

        $fournisseur->telephone = $request->get('telephone');

        $fournisseur->email = $request->get('email');

        $fournisseur->wilaya = $request->get('wilaya_id');

        $fournisseur->commune_id = $request->get('commune_id');

        $fournisseur->adress = $request->get('adress');

        $fournisseur->password = Hash::make($request['password']);

        $fournisseur->password_text = $request['password'];

        $fournisseur->num_service = $request['num_service'];





        $fournisseur->confirmation_telephonique = $request->get('confirmation_telephonique');

        $fournisseur->gestion_stock = $request->get('gestion_stock');

        $fournisseur->save();

        return redirect()->route('fournisseur.index')

            ->with('success', 'modification efféctué !');



    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Fournisseur  $fournisseur

     * @return \Illuminate\Http\Response

     */

    public function destroy($id_fournisseur)

    {

        $fournisseur = Fournisseur::find($id_fournisseur);

        $fournisseur->delete();

        return redirect()->route('fournisseur.index')

            ->with('success', 'supprimé avec succé !');

    }







    public function entrer(Request $request)

    {

        if(Auth::guard('fournisseur')->user()){

            $fournisseur_id = Auth::guard('fournisseur')->id();

        }else{

            return redirect()->route('login');     

        }



        $fournisseur = $request['fournisseur_entre'];

        foreach ($request['dynamic_form']['dynamic_form'] as $array) {

            $produit_json = json_decode($array['produit'], true);

            $produit  = Produit::find($produit_json['id']);

            $qteOld = $produit->quantite;

            $qteNew = $qteOld + $array['quantite'];  

            $produit->quantite = $qteNew;

            $produit->save();

            $stock = new  Stock();

            $stock->produit = $array['produit'];

            $stock->produit_id = $produit->id;

            $stock->quantite = $array['quantite'];

            $stock->fournisseur_id =$fournisseur_id;

            $stock->operation = 'entré';



            $stock->save();

        }    

        return redirect()->route('stock.index')->with('success', 'insertion effectué !  ');     



    }



    public function sortie(Request $request)

    {

        if(Auth::guard('fournisseur')->user()){

            $fournisseur_id = Auth::guard('fournisseur')->id();

        }else{

            return redirect()->route('login');     

        }



        $fournisseur = $request['fournisseur_sortie'];

        foreach ($request['dynamic_form_sortie']['dynamic_form_sortie'] as $array) {

            $produit_json = json_decode($array['produit'], true);

            $produit  = Produit::find($produit_json['id']);

            $qteOld = $produit->quantite;

            $qteNew = $qteOld - $array['quantite'];  

            $produit->quantite = $qteNew;

            $produit->save();

            $stock = new  Stock();

            $stock->produit = $array['produit'];

            $stock->produit_id = $produit->id;

            $stock->quantite = $array['quantite'];

            $stock->fournisseur_id =$fournisseur_id;

            $stock->operation = 'sortie';



            $stock->save();

        }    

        return redirect()->route('stock.index')->with('success', 'insertion effectué !  ');     

    }











    public function storeAjax(Request $request)

    {

        if($request->ajax()){

            $array = $request['data'];        

            $data=  array();

            parse_str($array, $data);        

            $f = new Fournisseur([

                'nom_prenom' => $data['nom_prenom'],

                'telephone' => $data['telephone'],

                'email' => $data['email'],

                'wilaya' => $data['wilaya_id'],

                'commune_id' => $data['commune_id'],

                'adress' => $data['adress'],

            ]);

    

            $f->save();

    

            $response = array(

                'fournisseur' => $data,

                'msg' => 'fournisseur ajouté',

            );

            return Response::json($response);  // <<<<<<<<< see this line    

        }

    }

}

