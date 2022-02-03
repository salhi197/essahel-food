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
        return view('productions.edit',compact('user','wilayas','communes'));
    }

    public function update($id_user)
    {
        dd('update');
        $production = Production::find($id_user);

        return view('productions.edit',compact('user','wilayas','communes'));
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
