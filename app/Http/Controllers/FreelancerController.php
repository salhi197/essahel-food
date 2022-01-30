<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Commune;
use App\Freelancer;
use App\Wilaya;
use App\Livreur;
use App\Produit;
use Auth;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    public function index()
    {
        $freelancers =Freelancer::all();
        return view('freelancers.index',compact('freelancers'));
    }
    public function create()
    {
        $communes = Commune::all();
        $wilayas = Wilaya::all();
        return view('freelancers.create',compact('wilayas','communes'));
    }


    public function store(Request $request)
    {
        $freelancer = new Freelancer();
        $freelancer->nom_prenom = $request->get('nom_prenom');
        $freelancer->telephone = $request->get('telephone');
        $freelancer->email = $request->get('email');
        $freelancer->password = Hash::make($request->get('password'));
        $freelancer->password_text = $request->get('password');
        $freelancer->save();
        return redirect()->route('freelancer.index')->with('success', 'un nouveau freelancer a été inséré avec succés ');
    }  

    public function edit($freelancer)
    {
        $communes = Commune::all();
        $wilayas =Wilaya::all();
        $freelancer = Freelancer::find($freelancer);
        return view('freelancers.edit',compact('livreur','wilayas','communes'));
    }

    public function update(Request $request)
    {
        $freelancer = Freelancer::find($request['freelancer_id']);
        $freelancer->nom_prenom = $request->get('nom_prenom');
        $freelancer->telephone = $request->get('telephone');
        $freelancer->email = $request->get('email');
        $freelancer->wilaya = $request->get('wilaya_id');
        $freelancer->commune_id = $request->get('commune_id');
        $freelancer->adress = $request->get('adress');
        $freelancer->save();
        return redirect()->route('freelancer.index')
            ->with('success', 'modification efféctué !');

    }
    

}

