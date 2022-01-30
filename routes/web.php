<?php

use App\Commande;
use App\Commune;
use App\Wilaya;
use App\Produit;
use App\Livreur;
use App\User;
use App\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;


Route::get('/codes', function(){
    
    $commandes = Commande::all();
    foreach ($commandes as $key => $commande){
        file_put_contents('img/codebars/'.$commande->code_tracking.'.svg', DNS1D::getBarcodeSVG($commande->code_tracking, 'C128'));
    }
    dd('sasas');
});


Route::get('/sql', function(){
    $commandes = Commande::where('creance_fournisseur','=',null)->get();
    foreach ($commandes as $key => $commande){
        $c = Commande::find($commande->id);
        $c->creance_fournisseur = 'non solder';
        $c->save();
    }
    dd('sasas');
});




Route::get('/coliers', function(){
    if(!auth()->guard('admin')->check()){
        return redirect()->route('login');//->with('success', 'la commande vous a été accordée ');           
    }   
    $commandes = DB::table('commandes')->orderBy('id', 'DESC')->paginate(20);
    $communes = Commune::all();
    $fournisseurs = Fournisseur::all();
    $wilayas =Wilaya::all();
    $livreurs =Livreur::all();    
    return view('coliers',compact('fournisseurs','commandes','communes','wilayas','livreurs'));
})->name('coliers');



Route::get('/impression', 'ImpressionController@impression')->name('impression');
Route::post('/ticket/impression/', 'ImpressionController@imprimer')->name('impression.tickets');


Route::get('/codebar', 'HomeController@codebar')->name('codebar');
Route::get('/', function(){
    return redirect()->route('login.admin');
});
Auth::routes();

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm')->name('login.admin');
Route::get('/login/livreur', 'Auth\LoginController@showLivreurLoginForm')->name('login.Livreur');
Route::get('/login/fournisseur', 'Auth\LoginController@showFournisseurLoginForm')->name('login.Fournisseur');
Route::get('/login/freelancer', 'Auth\LoginController@showFreelancerLoginForm')->name('login.Freelancer');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm')->name('register.admin');
Route::get('/register/livreur', 'Auth\RegisterController@showLivreurRegisterForm')->name('register.Livreur');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/login/livreur', 'Auth\LoginController@livreurLogin');
Route::post('/login/fournisseur', 'Auth\LoginController@fournisseurLogin');
Route::post('/login/freelancer', 'Auth\LoginController@freelancerLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin')->name('register.admin');
Route::post('/register/livreur', 'Auth\RegisterController@createLivreur')->name('register.Livreur');

Route::get('/home', function(){
    $commandes_en_attente = Commande::where('state','en attente')->get()->count();
    $commandes= Commande::all()->count();
    $commandes_accepter = Commande::where('state','accepte')->get()->count();
    $commandes_expedier = Commande::where('state','expedier')->get()->count();
    $commandes_en_attente_paiement = Commande::where('state','en_attente_paiement')->get()->count();
    $commandes_livre = Commande::where('state','livre')->get()->count();
    
    $commandes_livre = Commande::where('state','livre')->get()->count();
    $livreurs = Livreur::all()->count();
    $produits = Produit::all()->count();
    $users = User::all()->count();
    $data = [
        'commandes_en_attente'=>$commandes_en_attente,
        'commandes_accepter'=>$commandes_accepter,
        'commandes_accepter'=>$commandes_expedier,
        'commandes_livre'=>$commandes_livre,
        'commandes_en_attente_paiement'=> $commandes_en_attente_paiement,
        'livreurs'=>$livreurs,
        'produits'=>$produits,
        'users'=>$users,
        'commandes'=>$commandes,        
    ];



    if(auth()->guard('admin')->check()){
        return redirect()->route('coliers');//->with('success', 'la commande vous a été accordée ');           
        $commandes = DB::table('commandes')->orderBy('id', 'DESC')->paginate(20);
        $communes = Commune::all();
        $fournisseurs = Fournisseur::all();
        $wilayas =Wilaya::all();
        $livreurs =Livreur::all();

        return view('admin',compact('fournisseurs','commandes','data','communes','wilayas','livreurs'));
    }   
    if(auth()->guard('fournisseur')->check()){
        $id = Auth::guard('fournisseur')->id();
        $f = Fournisseur::find($id);
        $confirmation  = $f->confirmation_telephonique;
        $commandes = DB::table('commandes')->where('fournisseur_id',$id)->get();
        // $commandes = DB::table('commandes')->orderBy('id', 'DESC')->paginate(20);
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $debut_entre = "";
        $fin_entre = "";
        return view('fournisseurs',compact('commandes','communes','wilayas','debut_entre','fin_entre','confirmation'));
    }   

    
    if(auth()->guard('livreur')->check()){
        $id = Auth::guard('livreur')->id();
        // $sql = "select * from commandes where state<>'Livree' or state<>'Retour' "
//        $commandes = DB::table('commandes')
//                        ->where('livreur_id','=',$id) 
//                        ->orWhere('state', '=', 'sortie')
//                        ->orWhere('state', '=', 'annule')
//                        ->orWhere('state', '=', 'ne_reponds_pas')
//                        ->orWhere('state', '=', 'reporte')
//                    ->get();           
        $sql = 'select * from commandes where livreur_id='.$id.' and (state="sortie" or state="annule" or state="ne_reponds_pas" or state="reporte")';
        $commandes=DB::select(DB::raw($sql));

        $communes = Commune::all();
        $wilayas =Wilaya::all();
        return view('livreurs',compact('commandes','communes','wilayas'));
    }   

    if(Auth::user()){
        $commandes = DB::table('commandes')->orderBy('id', 'DESC')->paginate(20);
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        $produits =Produit::all();
        $livreurs =Livreur::all();
        return view('home',compact('commandes','wilayas','communes','produits','livreurs','data'));
    }
    $commandes = Commande::all();
    $communes = Commune::all();
    $wilayas =Wilaya::all();

    if(auth()->guard('livreur')->check()){
        return redirect()->route('livreur.index');                    
    }

    return redirect()->route('login');//->with('success', 'pub changé avec succés ');                    

})->name('home');
Route::group(['middleware' => 'auth:admin'], function () {
    Route::view('/admin', 'admin');
});


Route::get('/commande/prendre/{id_commande}', ['as' => 'commande.prendre', 'uses' => 'CommandeController@prendre']);

Route::get('/commande/consulter/{id_commande}', ['as' => 'commande.consulter', 'uses' => 'CommandeController@consulter']);




Route::group(['prefix' => 'commande', 'as' => 'commande'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'CommandeController@index']);
    Route::get('/fournisseur/{fournisseur}', ['as' => '.fournisseur', 'uses' => 'CommandeController@fournisseur']);
    
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'CommandeController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'CommandeController@store']);
    Route::post('/create/for/fournisseur', ['as' => '.create-for-fournisseur', 'uses' => 'CommandeController@storeForFournisseur']);
    Route::post('/update/{commande}', ['as' => '.update', 'uses' => 'CommandeController@update']);
    Route::get('/destroy/{id_commande}', ['as' => '.destroy', 'uses' => 'CommandeController@destroy']);    
    Route::get('/relancer/{id_commande}', ['as' => '.relancer', 'uses' => 'CommandeController@relancer']);    
    Route::get('/edit/{id_demande}', ['as' => '.edit', 'uses' => 'CommandeController@edit']);
    Route::get('/show/{id_commande}', ['as' => '.show', 'uses' => 'CommandeController@show']);
    Route::get('/download/{id_commande}', ['as' => '.download', 'uses' => 'CommandeController@download']);
    Route::get('/display/{id_commande}', ['as' => '.display', 'uses' => 'CommandeController@display']);
    Route::get('/retirer/{id_commande}', ['as' => '.retirer', 'uses' => 'CommandeController@retirer']);
    Route::get('/affecter/livreur/{livreur}', ['as' => '.affecter', 'uses' => 'CommandeController@affecter']);
    Route::get('/detacher/liverur/{livreur}', ['as' => '.detacher', 'uses' => 'CommandeController@detacher']);
    Route::get('/retour/{livreur}', ['as' => '.retour', 'uses' => 'CommandeController@retour']);
    Route::get('/confirmer/fournisseur/{fournisseur}', ['as' => '.confirmer', 'uses' => 'CommandeController@confirmer']);
    Route::get('/affecter/action/{commande}/{livreur}', ['as' => '.affecter.action', 'uses' => 'CommandeController@assigner']);
    Route::get('/detacher/action/{commande}/{livreur}', ['as' => '.detacher.action', 'uses' => 'CommandeController@desassigner']);
    Route::get('/list/retour/', ['as' => '.list.retour', 'uses' => 'CommandeController@ListRetourCommandes']);
    Route::get('/list/des/retour/ls', ['as' => '.retour.list.ls', 'uses' => 'CommandeController@ListRetourCommandes']);
    
    Route::get('/accepter/{id_commande}', ['as' => '.accepter', 'uses' => 'CommandeController@accepter']);
    Route::get('/timeline/{id_commande}', ['as' => '.timeline', 'uses' => 'CommandeController@timeline']);
    Route::get('/non/abouti/{id_commande}', ['as' => '.non.abouti', 'uses' => 'CommandeController@NonAbouti']);
    
    Route::get('/edit/delete/produit/{id_commande}/{index}', ['as' => '.edit.delete.produit', 'uses' => 'CommandeController@editDeleteProduit']);

    
    
    Route::post('/date/update/', ['as' => '.update.date', 'uses' => 'CommandeController@updateDate']);    
    Route::post('/credit', ['as' => '.update.credit', 'uses' => 'CommandeController@updateCredit']);    
    Route::get('/retour/action/{commande}', ['as' => '.update.retour', 'uses' => 'CommandeController@updateRetour']);    

    Route::get('/retour/stock/one/{commande}', ['as' => '.retour.stock.one', 'uses' => 'CommandeController@retourStockOne']);    

    Route::post('/annuler', ['as' => '.annuler', 'uses' => 'CommandeController@annuler']);    
    Route::post('/livrer', ['as' => '.livrer', 'uses' => 'CommandeController@livrer']);    

    Route::get('/setstate/{commande}/{state}', ['as' => '.set.state', 'uses' => 'CommandeController@setState']);    


    // Route::get('/solder/{items?}', ['as' => '.solder', 'uses' => 'CommandeController@solder'])->where('items', '(.*)');    

    Route::get('/solder/livreur/{items?}', ['as' => '.solder', 'uses' => 'CommandeController@solderLivreur'])->where('items', '(.*)');    
    Route::get('/solder/fournisseur/{items?}', ['as' => '.solder', 'uses' => 'CommandeController@solderFournisseur'])->where('items', '(.*)');    



    // Route::get('/nonsolder/{items?}', ['as' => '.nonsolder', 'uses' => 'CommandeController@nonsolder'])->where('items', '(.*)');    
    Route::get('/nonsolder/livreur/{items?}', ['as' => '.nonsolder', 'uses' => 'CommandeController@nonsolderLivreur'])->where('items', '(.*)');    
    Route::get('/nonsolder/fournisseur/{items?}', ['as' => '.nonsolder', 'uses' => 'CommandeController@nonsolderFournisseur'])->where('items', '(.*)');    

    // Route::get('/retour/list/{items?}', ['as' => '.retourList', 'uses' => 'CommandeController@retourList'])->where('items', '(.*)');    
    Route::get('/detacher/list/livreur/{livreur}/{items?}', ['as' => '.detacherList', 'uses' => 'CommandeController@detacherList'])->where('items', '(.*)');    
    
    Route::get('/retour/list/livreur/{livreur}/{items?}', ['as' => '.retourListLs', 'uses' => 'CommandeController@retourListLs'])->where('items', '(.*)');    
    Route::get('/retour/list/stock/{items?}', ['as' => '.retourListStock', 'uses' => 'CommandeController@retourListStock'])->where('items', '(.*)');    

    
    
    Route::get('/affecter/list/livreur/{livreur}/{items?}', ['as' => '.detacherList', 'uses' => 'CommandeController@affecterList'])->where('items', '(.*)');    

    Route::get('/supprimer/list/{items?}', ['as' => '.destroyList', 'uses' => 'CommandeController@destroyList'])->where('items', '(.*)');    
    Route::get('/confirmer/list/fournisseur/{fournisseur}/{items?}', ['as' => '.confirmerList', 'uses' => 'CommandeController@confirmerList'])->where('items', '(.*)');    
    

    Route::get('/one/confirmer/{commande}', ['as' => '.confirmerOne', 'uses' => 'CommandeController@confirmerOne']);

    Route::get('/print/a4/{items?}', ['as' => '.printA4', 'uses' => 'CommandeController@printA4'])->where('items', '(.*)');    
    Route::get('/print/ticket{items?}', ['as' => '.printTicket', 'uses' => 'CommandeController@printTicket'])->where('items', '(.*)');    

    Route::get('/download/single/{commande}/{type}', ['as' => '.download.single', 'uses' => 'CommandeController@printSingle']);    

    
    Route::post('/search', ['as' => '.search', 'uses' => 'CommandeController@search']);    
    Route::post('/change/state', ['as' => '.update.state', 'uses' => 'CommandeController@updateState']);

    
});

Route::group(['prefix' => 'journal', 'as' => 'journal'], function () {

    Route::get('/livreur', ['as' => '.livreur', 'uses' => 'JournalController@livreur']);
    Route::get('/fournisseur', ['as' => '.fournisseur', 'uses' => 'JournalController@fournisseur']);
    Route::get('/personnel', ['as' => '.personnel', 'uses' => 'JournalController@personnel']);
    Route::get('/ls', ['as' => '.ls', 'uses' => 'JournalController@ls']);
    
    Route::post('/filter/livreur', ['as' => '.filter.livreur', 'uses' => 'JournalController@Filterlivreur']);

    Route::post('/filter/personnel', ['as' => '.filterpourpersonnel', 'uses' => 'JournalController@Filterpersonnel']);
    Route::post('/filter/fournisseur', ['as' => '.filter.fournisseur', 'uses' => 'JournalController@Filterfournisseur']);
    Route::post('/filter/ls', ['as' => '.filter.ls', 'uses' => 'JournalController@Filterls']);


});


Route::group(['prefix' => 'user', 'as' => 'user'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'UserController@index']);
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'UserController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'UserController@store']);
    Route::get('/destroy/{id_user}', ['as' => '.destroy', 'uses' => 'UserController@destroy']);    
    Route::get('/remise/{id_user}', ['as' => '.destroy', 'uses' => 'UserController@destroy']);    
    Route::get('/edit/{id_user}', ['as' => '.edit', 'uses' => 'UserController@edit']);
    Route::get('/show/{id_user}', ['as' => '.show', 'uses' => 'UserController@show']);
    Route::post('/update/{id_user}', ['as' => '.update', 'uses' => 'UserController@update']);    
});

Route::group(['prefix' => 'admin', 'as' => 'admin'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'AdminController@index']);
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'AdminController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'AdminController@store']);
    Route::get('/destroy/{id_admin}', ['as' => '.destroy', 'uses' => 'AdminController@destroy']);    
    Route::get('/destroy/{id_admin}', ['as' => '.destroy', 'uses' => 'AdminController@destroy']);    
    Route::get('/edit/{id_admin}', ['as' => '.edit', 'uses' => 'AdminController@edit']);
    Route::get('/show/{id_admin}', ['as' => '.show', 'uses' => 'AdminController@show']);
    Route::post('/update/{id_admin}', ['as' => '.update', 'uses' => 'AdminController@update']);   
    Route::get('/remise/zero/{id_admin}', ['as' => '.remise.zero', 'uses' => 'AdminController@remiseZero']);   
     
});


Route::group(['prefix' => 'produit', 'as' => 'produit'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'ProduitController@index']);
    Route::get('/create',['as'=>'.create', 'uses' => 'ProduitController@create']);
    Route::post('/create', ['as' => '.store', 'uses' => 'ProduitController@store']);
    Route::get('/destroy/{id_demande}', ['as' => '.destroy', 'uses' => 'ProduitController@destroy']); 
    Route::get('/stock/{id_demande}', ['as' => '.stock', 'uses' => 'ProduitController@stock']); 
    Route::get('/print/stock/{id_demande}', ['as' => '.print.stock', 'uses' => 'ProduitController@printStock']); 
       
    Route::get('/edit/{id_demande}', ['as' => '.edit', 'uses' => 'ProduitController@edit']);
    Route::get('/show/{id_produit}', ['as' => '.show', 'uses' => 'ProduitController@show']);
    Route::post('/update/{produit}', ['as' => '.update', 'uses' => 'ProduitController@update']);    
});

Route::group(['prefix' => 'livreur', 'as' => 'livreur'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'LivreurController@index']);
    Route::get('/ajax', ['as' => '.ajax', 'uses' => 'LivreurController@indexAjax']);
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'LivreurController@create']);
    Route::get('/edit/{livreur}', ['as' => '.edit', 'uses' => 'LivreurController@edit']);

    Route::get('/filter/{livreur}', ['as' => '.filter', 'uses' => 'LivreurController@filter']);
    Route::post('/extra/{livreur_id}', ['as' => '.extra.filter', 'uses' => 'LivreurController@extraFilter']);
    
    Route::get('/journal/{livreur}', ['as' => '.journal', 'uses' => 'LivreurController@journal']);

    Route::post('/create', ['as' => '.create', 'uses' => 'LivreurController@store']);
    Route::get('/destroy/{id_livruer}', ['as' => '.destroy', 'uses' => 'LivreurController@destroy']);    
    Route::get('/change/state/{id_livruer}', ['as' => '.change.state', 'uses' => 'LivreurController@changeState']);
    Route::get('/show/{id_livruer}', ['as' => '.show', 'uses' => 'LivreurController@show']);
    Route::post('/update', ['as' => '.update', 'uses' => 'LivreurController@update']);    
    Route::get('/livraisons', ['as' => '.livraisons', 'uses' => 'LivreurController@maList']);

});


Route::group(['prefix' => 'fournisseur', 'as' => 'fournisseur'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'FournisseurController@index']);
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'FournisseurController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'FournisseurController@store']);
    Route::post('/create/ajax', ['as' => '.store.ajax', 'uses' => 'FournisseurController@storeAjax']);
    Route::get('/destroy/{id_fournisseur}', ['as' => '.destroy', 'uses' => 'FournisseurController@destroy']);    
    Route::get('/edit/{id_fournisseur}', ['as' => '.edit', 'uses' => 'FournisseurController@edit']);
    Route::get('/show/{id_fournisseur}', ['as' => '.show', 'uses' => 'FournisseurController@show']);
    Route::post('/update', ['as' => '.update', 'uses' => 'FournisseurController@update']); 
    Route::post('/filter', ['as' => '.filter', 'uses' => 'FournisseurController@filter']); 
       
    Route::get('/stock', ['as' => '.stock', 'uses' => 'FournisseurController@stock']);    
    Route::get('/coliers/{fournisseur}', ['as' => '.coliers', 'uses' => 'FournisseurController@coliers']);  
    Route::get('/journal/{fournisseur}', ['as' => '.journal', 'uses' => 'FournisseurController@journal']);  

    Route::post('/stock/entrer', ['as' => '.stock.entrer', 'uses' => 'FournisseurController@entrer']);
    Route::post('/stock/sortie', ['as' => '.stock.sortie', 'uses' => 'FournisseurController@sortie']);
    Route::post('/fournisseur/filter/journal', ['as' => '.filter.journal', 'uses' => 'FournisseurController@fournisseurFilterJournal']);
    


    
});
Route::group(['prefix' => 'type', 'as' => 'type'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'TypeController@index']);
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'TypeController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'TypeController@store']);
    Route::post('/create/ajax', ['as' => '.store.ajax', 'uses' => 'TypeController@storeAjax']);
    Route::get('/destroy/{id_type}', ['as' => '.destroy', 'uses' => 'TypeController@destroy']);    
    Route::get('/edit/{id_type}', ['as' => '.edit', 'uses' => 'TypeController@edit']);
    Route::get('/show/{id_type}', ['as' => '.show', 'uses' => 'TypeController@show']);
    Route::post('/update', ['as' => '.update', 'uses' => 'TypeController@update']);    
});


Route::group(['prefix' => 'freelancer', 'as' => 'freelancer'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'FreelancerController@index']);
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'FreelancerController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'FreelancerController@store']);
    Route::post('/create/ajax', ['as' => '.store.ajax', 'uses' => 'FreelancerController@storeAjax']);
    Route::get('/destroy/{freelancer}', ['as' => '.destroy', 'uses' => 'FreelancerController@destroy']);    
    Route::get('/edit/{freelancer}', ['as' => '.edit', 'uses' => 'FreelancerController@edit']);
    Route::get('/show/{freelancer}', ['as' => '.show', 'uses' => 'FreelancerController@show']);
    Route::post('/update/{freelancer}', ['as' => '.update', 'uses' => 'FreelancerController@update']);    
});


    Route::get('/pub', function(){
        return view('pubs.index');
    })->name('pub.index');

    Route::post('/pub', function(Request $request){
        if(request('image')){
            $imageName = 'pub.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/'), $imageName);
            return redirect()->route('pub.index')->with('success', 'pub changé avec succés ');                    

        }
    })->name('pub.store');


    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'FournisseurController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'FournisseurController@store']);



    Route::get('/rapport', function(){
        return view('rapport');    
    })->name('rapport');


Route::group(['prefix' => 'achat', 'as' => 'achat'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'AchatController@index']);
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'AchatController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'AchatController@store']);
    Route::get('/destroy/{id_achat}', ['as' => '.destroy', 'uses' => 'AchatController@destroy']);    
    Route::get('/edit/{id_achat}', ['as' => '.edit', 'uses' => 'AchatController@edit']);
    Route::get('/facture/{id_achat}', ['as' => '.facture', 'uses' => 'AchatController@facture']);
    Route::post('/update/{id_achat}', ['as' => '.update', 'uses' => 'AchatController@update']);    
    Route::post('/update/retour', ['as' => '.update.retour', 'uses' => 'AchatController@updateRetour']);    

});
    

Route::group(['prefix' => 'stock', 'as' => 'stock'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'StockController@index']);

    Route::post('/entrer', ['as' => '.entrer', 'uses' => 'StockController@entrer']);
    Route::post('/sortie', ['as' => '.sortie', 'uses' => 'StockController@sortie']);
    Route::post('/print/{stock}', ['as' => '.print', 'uses' => 'StockController@print']);
    Route::post('/delete/{stock}', ['as' => '.delete', 'uses' => 'StockController@delete']);
    
    Route::get('/detail/{stock}', ['as' => '.detail', 'uses' => 'StockController@detail']);
});


Route::group(['prefix' => 'wilaya', 'as' => 'wilaya'], function () {
    Route::get('/fournisseurs', ['as' => '.fournisseurs', 'uses' => 'HomeController@fournisseurs']);
    Route::post('/fournisseur', ['as' => '.fournisseur', 'uses' => 'HomeController@fournisseur']);

    Route::get('/livreurs', ['as' => '.livreurs', 'uses' => 'HomeController@livreurs']);
    Route::post('/livreur', ['as' => '.livreur', 'uses' => 'HomeController@livreur']);

    Route::get('/aboutis', ['as' => '.aboutis', 'uses' => 'HomeController@aboutis']);
    Route::post('/abouti_livreur', ['as' => '.abouti.livreur', 'uses' => 'HomeController@aboutiLivreur']);
    Route::post('/abouti_fournisseur', ['as' => '.abouti.fournisseur', 'uses' => 'HomeController@aboutiFournisseur']);

    Route::post('/livraison', ['as' => '.livraison', 'uses' => 'HomeController@livraison']);
    
    Route::get('/sortie', ['as' => '.sortie', 'uses' => 'HomeController@sortie']);
    
});


Route::group(['prefix' => 'payment', 'as' => 'payment'], function () {
    Route::get('/{achat}', ['as' => '.index', 'uses' => 'PaymentController@index']);
    Route::get('/list/{achat}', ['as' => '.list', 'uses' => 'PaymentController@list']);
    
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'PaymentController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'PaymentController@store']);
    Route::get('/destroy/{id_payment}', ['as' => '.destroy', 'uses' => 'PaymentController@destroy']);    
    Route::get('/edit/{id_payment}', ['as' => '.edit', 'uses' => 'PaymentController@edit']);
    Route::get('/facture/{id_payment}', ['as' => '.facture', 'uses' => 'PaymentController@facture']);
    Route::post('/update/{id_payment}', ['as' => '.update', 'uses' => 'PaymentController@update']);    
});

Route::get('/down', function () {
    $clearcache = Artisan::call('down');
    echo "site down <br>";
});