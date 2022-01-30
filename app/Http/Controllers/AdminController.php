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
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        $admin = Admin::find($id_admin);
        return view('admins.edit',compact('admin','wilayas','communes'));
    }

    public function update(Request $request,$id_admin)
    {
        $admin = Admin::find($id_admin);
        $admin->name = $request->get('name');
        $admin->email = $request->get('email');
        $admin->password = Hash::make($request->get('password'));
        $admin->password_text = $request->get('password');
        try {
            $admin->save();
            return redirect()->route('admin.index')->with('success', 'le  commercial a été supprimé ');
        } catch (\Throwable $e) {
            return redirect()->route('admin.index')->with('error', $e->getMessage());
        }

    }

    
    public function destroy($id_admin)
    {
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        $admin = Admin::find($id_admin);
        $admin->delete();    
        return redirect()->route('admin.index')->with('success', 'le  commercial a été supprimé ');
    }

}
