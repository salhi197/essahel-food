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
        return redirect()->route('depot.index')->with('success', 'un nouveau agent a été inséré avec succés ');
    }  
    public function edit($id_user)
    {
        $depot = Depot::find($id_user);
        return view('depots.edit',compact('depot'));
    }

    public function update(Request $request,$id_depot)
    {
        $depot = Depot::find($id_depot);
        if($request['password']==null){
            return redirect()->back()->with('error', 'mot de passe n\'a été entré ');
        }
        if($request['password']!=$depot->password_text){
            return redirect()->back()->with('error', 'ancien mot de passe n\'est pas correcte ');
        }
        if($request['new_password']==null){
            return redirect()->back()->with('error', 'Nouveau mot de passe ne peut aps etre vide ');
        }

        $depot->password = Hash::make($request->get('new_password'));
        $depot->password_text = $request->get('new_password');
        try {
            $depot->save();
            return redirect()->back()->with('success', 'Mot de passe modifié avec succés ');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    
    public function destroy($id_user)
    {
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        $depots = Depot::find($id_user);
        $depot->delete();    
        return redirect()->route('depot.index')->with('success', 'le  agent a été supprimé ');
    }

}
