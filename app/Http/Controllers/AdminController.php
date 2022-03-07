<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;
use Hash;
use App\Commune;
use App\Http\Requests\Storeadmin;
use App\Wilaya;

class AdminController extends Controller
{
    public function index()
    {
        $admins=Admin::all();
        return view('admins.index',compact('admins'));
    }

    public  function remiseZero($admin_id)
    {
        $admin = Admin::find($admin_id);
        $admin->solde = 0;
        $admin->save();
        return redirect()->route('admin.index')->with('success', 'un nouveau admin a été inséré avec succés ');
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
        return view('admins.create',compact('wilayas','communes'));
    }
    public function store(Request $request)
    {
        $admin = new Admin();
        $admin->name = $request->get('name');
        $admin->email = $request->get('email');
        $admin->password = Hash::make($request->get('password'));
        $admin->password_text = $request->get('password');
        $admin->save();
        return redirect()->route('admin.index')->with('success', 'un nouveau admin a été inséré avec succés ');
    }  
    public function edit($id_admin)
    {
        $admin = Admin::find($id_admin);
        return view('admins.edit',compact('admin'));
    }

    public function update(Request $request,$id_admin)
    {
        $admin = Admin::find($id_admin);
        if($request['password']==null){
            return redirect()->back()->with('error', 'mot de passe n\'a été entré ');
        }
        if($request['password']!=$admin->password_text){
            return redirect()->back()->with('error', 'ancien mot de passe n\'est pas correcte ');
        }
        if($request['new_password']==null){
            return redirect()->back()->with('error', 'Nouveau mot de passe ne peut aps etre vide ');
        }

        $admin->password = Hash::make($request->get('new_password'));
        $admin->password_text = $request->get('new_password');
        try {
            $admin->save();
            return redirect()->back()->with('success', 'Mot de passe modifié avec succés ');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    
}
