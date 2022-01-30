<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Hash;
use App\Commune;
use App\Http\Requests\StoreUser;
use App\Wilaya;

class UserController extends Controller
{
    public function index()
    {
        // user sginife commercial
        $users =User::all();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        return view('users.create',compact('wilayas','communes'));
    }
    public function store(StoreUser $request)
    {
        $validatedData = $request->validate([
            "nom_prenom" => "required",
            "telephone" => "required",
            "grade" => "required",
            "email" => "required",
            "password" => "required"
        ]);

        $user = new User();
        $user->nom_prenom = $request->get('nom_prenom');
        $user->telephone = $request->get('telephone');
        $user->grade = $request->get('grade');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->password_text = $request->get('password');
        $user->wilaya_id = $request->get('wilaya_id');
        $user->commune_id = $request->get('commune_id');
        if ($request->hasFile('identite')) {
            $livreur->identite = $request->file('identite')->store(
                'users/identite',
                'public'
            );
        }

        $user->save();
        return redirect()->route('user.index')->with('success', 'un nouveau commercial a été inséré avec succés ');
    }  
    public function edit($id_user)
    {
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        $user = User::find($id_user);
        return view('users.edit',compact('user','wilayas','communes'));
    }

    public function update($id_user)
    {
        dd('update');
        $user = User::find($id_user);

        return view('users.edit',compact('user','wilayas','communes'));
    }

    
    public function destroy($id_user)
    {
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        $user = User::find($id_user);
        $user->delete();    
        return redirect()->route('user.index')->with('success', 'le  commercial a été supprimé ');
    }

}
