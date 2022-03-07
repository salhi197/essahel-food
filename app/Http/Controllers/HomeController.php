<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use App\Wilaya;
use App\Livreur;
use Picqer;

class HomeController extends Controller

{


    public function redirect()
    {
        if(auth()->guard('admin')->check()){
            return redirect()->route('stats');
        }
        if(auth()->guard('depot')->check()){
            return redirect()->route('impression');
        }
        if(auth()->guard('production')->check()){
            return redirect()->route('ticket.index');
        }

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

    public function sms(){
        $url="http://sms.icosnet.com:8000/bulksms/bulksms";

        $ch = curl_init();
        $variables = array(
            'username' => 'BIBAN_FRET',
            'password' => 'SMS3265',
            'type' => '0',
            'dlr' => '1',
            'destination' => "213794498727", 
            'source' => 'BIBAN FRET',
            'message' => "sms",
        );
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $variables);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400); 
        echo $result = curl_exec($ch);        
        $err = curl_error($ch);
        dd($err);
        dd('test');

    }
}

