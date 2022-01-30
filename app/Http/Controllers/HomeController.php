<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use App\Wilaya;
use App\Livreur;
use Picqer;

class HomeController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {

    }

    public function codebar()
    {
        $codebar = DNS1D::getBarcodePNG('4', 'C39+');
        file_put_contents('img/codebars/barcode.png', DNS1D::getBarcodePNG('4', 'C39+'));

        return view('codebar',compact('codebar'));
    }

    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        return view('home');

    }

    // public function livreurs()
    // {
    //     $livreur = Livreur::all();
    //     $wilayas = Wilaya::all();
    //     return view('livreurs',compact('livreur','wilayas'));
    // }
    public function aboutis()
    {
        $wilayas = Wilaya::all();
        return view('wilayas-aboutis',compact('wilayas'));
    }

    public function aboutiLivreur(Request $request)
    {
        $wilaya = Wilaya::find($request['wilaya']);
        $wilaya->abouti_livreur = $request['abouti_livreur'];
        $wilaya->save();
        return redirect()->back()->with('success', 'insertion effectué !  ');     
    }

    public function aboutiFournisseur(Request $request)
    {
        // dd($request['abouti_fournisseur']);
        $wilaya = Wilaya::find($request['wilaya']);
        $wilaya->abouti_fournisseur = $request['abouti_fournisseur'];
        $wilaya->save();
        return redirect()->back()->with('success', 'insertion effectué !  ');     
    }



    public function fournisseurs()
    {
        $wilayas = Wilaya::all();
        return view('wilayas-fournisseurs',compact('wilayas'));
    }

    public function fournisseur(Request $request)
    {
        $wilaya = Wilaya::find($request['wilaya']);
        $wilaya->fournisseur = $request['fournisseur'];
        $wilaya->save();
        return redirect()->back()->with('success', 'insertion effectué !  ');     
    }



    public function livreurs()
    {
        $wilayas = Wilaya::all();
        return view('wilayas-livreurs',compact('wilayas'));
    }

    public function livreur(Request $request)
    {
        $wilaya = Wilaya::find($request['wilaya']);
        $wilaya->livreur = $request['livreur'];
        $wilaya->save();
        return redirect()->back()->with('success', 'insertion effectué !  ');     
    }



    public function livraison(Request $request)
    {
        $wilaya = Wilaya::find($request['wilaya']);
        $wilaya->livraison = $request['livraison'];
        $wilaya->save();
        return redirect()->route('wilaya.livreurs')->with('success', 'insertion effectué !  ');     
    }


}

