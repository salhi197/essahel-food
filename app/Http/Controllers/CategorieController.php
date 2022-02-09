<?php

namespace App\Http\Controllers;


use App\Categorie;
use App\Wilaya;
use App\Sub;
use Response;
use Illuminate\Http\Request;

class CategorieController extends Controller
{

    public function index()
    {
        $categories = Categorie::all();
        return view('categories.index',compact('categories'));
    }

    public function store(Request $request)
    {
        $categorie = new Categorie();   
        $categorie->nom = $request['nom'];
        $categorie->reference = $request['reference'];
        $categorie->description = $request['description'] ?? '';
        $categorie->save();
        return redirect()->route('categorie.index')->with('success', 'inserted successfuly ! ');
    }
    public function destroy($categorie)
    {
        $categorie = Categorie::find($categorie);
        $categorie->delete();
        return redirect()->route('categorie.index')->with('success', 'supprimé avec succé !');
    }

    public function update(Request $request)
    {
        $categorie = Categorie::find($request['id_categorie']);
        $categorie->nom = $request['nom'];
        $categorie->reference = $request['reference'];
        $categorie->description = $request['description'] ?? '';
        $categorie->save();
        return redirect()->route('categorie.index')->with('success', 'Categorie Modifié ! ');
    }
}
