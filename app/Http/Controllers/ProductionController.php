<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use App\Commune;
use App\Production;

class ProductionController extends Controller
{
    public function index()
    {
        $productions =Production::all();
        return view('productions.index',compact('productions'));
    }

    
    public function create()
    {
        return view('productions.create');
    }
    public function store(Request $request)
    {
        $production = new Production();
        $production->name = $request->get('name');
        $production->email = $request->get('email');
        $production->password = Hash::make($request->get('password'));
        $production->password_text = $request->get('password');
        $production->save();
        return redirect()->route('production.index')->with('success', 'un nouveau commercial a été inséré avec succés ');
    }  
    public function edit($id_user)
    {
        $production = Production::find($id_user);
        return view('productions.edit',compact('production'));
    }

    public function update(Request $request,$id_production)
    {
        $production = production::find($id_production);

        if($request['password']==null){
            return redirect()->back()->with('error', 'mot de passe n\'a été entré ');
        }
        if($request['password']!=$production->password_text){
            return redirect()->back()->with('error', 'ancien mot de passe n\'est pas correcte ');
        }
        if($request['new_password']==null){
            return redirect()->back()->with('error', 'Nouveau mot de passe ne peut aps etre vide ');
        }

        $production->password = Hash::make($request->get('new_password'));
        $production->password_text = $request->get('new_password');
        try {
            $production->save();
            return redirect()->back()->with('success', 'Mot de passe modifié avec succés ');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }    

    
    public function destroy($id_user)
    {
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        $production = Production::find($id_user);
        $production->delete();    
        return redirect()->route('production.index')->with('success', 'le  commercial a été supprimé ');
    }

}
