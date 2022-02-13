<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use App\Commune;
use App\Depot;

class DepotController extends Controller
{
    public function index()
    {
        $depots =Depot::all();
        return view('depots.index',compact('depots'));
    }

    
    public function create()
    {
        return view('depots.create');
    }
    public function store(Request $request)
    {
        $depot = new Depot();
        $depot->name = $request->get('name');
        $depot->email = $request->get('email');
        $depot->password = Hash::make($request->get('password'));
        $depot->password_text = $request->get('password');
        $depot->save();
        return redirect()->route('depot.index')->with('success', 'un nouveau commercial a été inséré avec succés ');
    }  
    public function edit($id_user)
    {
        $depots = Depot::find($id_user);
        return view('depots.edit',compact('user','wilayas','communes'));
    }

    public function update(Request $request,$id_user)
    {
        $depots = Depot::find($id_user);
        $depot->name = $request->get('name');
        $depot->email = $request->get('email');
        $depot->password = Hash::make($request->get('password'));
        $depot->password_text = $request->get('password');
        $depot->save();
        return redirect()->route('depot.index')->with('success', 'les informations de l\'agent ont été modifié ');
    }

    
    public function destroy($id_user)
    {
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        $depots = Depot::find($id_user);
        $depot->delete();    
        return redirect()->route('depot.index')->with('success', 'le  commercial a été supprimé ');
    }

}
