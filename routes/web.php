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

Route::get('/impression', 'ImpressionController@impression')->name('impression');
Route::get('/rapport', 'RapportController@rapport')->name('rapport');
Route::post('/get/scanned/tickets', 'RapportController@getScannedTickets')->name('getScannedTickets');
Route::post('/ticket/impression/', 'ImpressionController@imprimer')->name('impression.tickets');

Route::get('/ticket', 'TicketController@index')->name('ticket.index');

Route::get('/ticket/affecter/livreur/{livreur}', 'TicketController@affecter')->name('ticket.affecter');
Route::post('/ticket/affecter/livreur', 'TicketController@assigner')->where('items', '(.*)');

Route::get('/ticket/detacher/livreur/{livreur}', 'TicketController@detacher')->name('ticket.detacher');
Route::post('/ticket/enlever/livreur', 'TicketController@enlever')->where('items', '(.*)');


Route::get('/ticket/retour/livreur/{livreur}', 'TicketController@retour')->name('ticket.retour');
Route::post('/ticket/retourner/livreur', 'TicketController@retourner')->where('items', '(.*)');


Route::get('/ticket/retour/destruction', 'TicketController@retourDestruction')->name('ticket.retour.destruction');
Route::post('/ticket/retourner/destruction', 'TicketController@retournerDestruction')->where('items', '(.*)');


Route::get('/ticket/retour/recyclage', 'TicketController@retourRecyclage')->name('ticket.retour.recyclage');
Route::post('/ticket/retourner/recyclage', 'TicketController@retournerRecyclage')->where('items', '(.*)');



Route::post('/ticket/filter/livreur/{livreur}', 'TicketController@filter')->name('ticket.filter.livreur');
Route::post('/ticket/filter/extra', 'TicketController@filterExtra')->name('ticket.filter.extra');


Route::get('/ticket/vers_depot', 'TicketController@vers_depot')->name('ticket.vers_depot');
Route::post('/ticket/vers_depot/action', 'TicketController@vers_depot_action');

Route::get('/ticket/au_depot', 'TicketController@au_depot')->name('ticket.au_depot');
Route::post('/ticket/au_depot/action', 'TicketController@au_depot_action');


Route::get('/ticket/bl/{livreur}', 'TicketController@bl')->name('ticket.bl');


Route::group(['prefix' => 'categorie', 'as' => 'categorie'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'CategorieController@index']);
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'CategorieController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'CategorieController@store']);
    Route::post('/update/{id_categorie}', ['as' => '.update', 'uses' => 'CategorieController@update']);
    Route::get('/destroy/{id_categorie}', ['as' => '.destroy', 'uses' => 'CategorieController@destroy']);
    Route::get('/edit/{id_categorie}', ['as' => '.edit', 'uses' => 'CategorieController@edit']);
});




Route::get('/test', function(){
    dd(date('Y-m-d H:m:s'));
    return view('template_for_dash');
});

Route::get('/sms', 'HomeController@sms')->name('sms');



Route::get('/', function(){
    return redirect()->route('login.admin');
});
Auth::routes();

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm')->name('login.admin');
Route::get('/login/livreur', 'Auth\LoginController@showLivreurLoginForm')->name('login.Livreur');
Route::get('/login/production', 'Auth\LoginController@showProductionLoginForm')->name('login.production');
Route::get('/login/depot', 'Auth\LoginController@showDepotLoginForm')->name('login.depot');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm')->name('register.admin');
Route::get('/register/livreur', 'Auth\RegisterController@showLivreurRegisterForm')->name('register.Livreur');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/login/livreur', 'Auth\LoginController@livreurLogin');
Route::post('/login/production', 'Auth\LoginController@productionLogin');
Route::post('/login/depot', 'Auth\LoginController@depotLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin')->name('register.admin');
Route::post('/register/livreur', 'Auth\RegisterController@createLivreur')->name('register.Livreur');


Route::get('/home', 'HomeController@redirect')->name('home');
// Route::get('/home', function(){
//         return redirect()->route('impression');
// })->name('home');
Route::group(['middleware' => 'auth:admin'], function () {
    Route::view('/admin', 'admin');
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
    Route::get('/edit/{id_admin}', ['as' => '.edit', 'uses' => 'AdminController@edit']);
    Route::post('/update/{id_admin}', ['as' => '.update', 'uses' => 'AdminController@update']);   
     
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


Route::group(['prefix' => 'depot', 'as' => 'depot'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'DepotController@index']);
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'DepotController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'DepotController@store']);
    Route::get('/destroy/{id_depot}', ['as' => '.destroy', 'uses' => 'DepotController@destroy']);    
    Route::get('/edit/{id_depot}', ['as' => '.edit', 'uses' => 'DepotController@edit']);
    Route::get('/show/{id_depot}', ['as' => '.show', 'uses' => 'DepotController@show']);
    Route::post('/update/{id_depot}', ['as' => '.update', 'uses' => 'DepotController@update']);    
});


Route::group(['prefix' => 'production', 'as' => 'production'], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'ProductionController@index']);
    Route::get('/show/create',['as'=>'.show.create', 'uses' => 'ProductionController@create']);
    Route::post('/create', ['as' => '.create', 'uses' => 'ProductionController@store']);
    Route::get('/destroy/{id_production}', ['as' => '.destroy', 'uses' => 'ProductionController@destroy']);    
    Route::get('/edit/{id_production}', ['as' => '.edit', 'uses' => 'ProductionController@edit']);
    Route::get('/show/{id_production}', ['as' => '.show', 'uses' => 'ProductionController@show']);
    Route::post('/update/{id_production}', ['as' => '.update', 'uses' => 'ProductionController@update']);    
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
    Route::get('/bl/{id_livruer}', ['as' => '.bl', 'uses' => 'LivreurController@bl']);
    Route::get('/show/{id_livruer}', ['as' => '.show', 'uses' => 'LivreurController@show']);
    Route::post('/update/livreur/{livreur}', ['as' => '.update', 'uses' => 'LivreurController@update']);    
    Route::get('/livraisons', ['as' => '.livraisons', 'uses' => 'LivreurController@maList']);

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


Route::get('/clear', function () {
    $clearcache = Artisan::call('cache:clear');
    echo "Cache cleared<br>";

    $clearview = Artisan::call('view:clear');
    echo "View cleared<br>";

    $clearconfig = Artisan::call('config:cache');
    echo "Config cleared<br>";
});


Route::get('/down', function () {
    $clearcache = Artisan::call('down');
    echo "site down <br>";
});