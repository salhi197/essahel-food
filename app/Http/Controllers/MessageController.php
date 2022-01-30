<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $messages = Message::all();
        return view('newsletter.index',compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('newsletter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stack = json_encode($request['type']);
        $message = new Message();
        $message->type= $stack;
        $message->objet= $request->get('objet');
        $message->content= $request->get('content');
        if(request('image')){
                $image = $request->file('image')->store(
                    'newsletter/fichier',
                    'public'
                );
            $message->fichier = $image;
        }
        $message->save();
        return redirect()->route('newsletter.index')->with('success', 'New-leter envoyé avec succés ');        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show($id_produit)
    {
        $message = Message::find($id_produit);

        return view('newsletter.view',compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit($id_produit)
    {
        $produit = Produit::find($id_produit);
        return view('produits.edit',compact('produit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduit $request, Produit $produit)
    {
        $produit = Produit::find($request['id']);
        $produit->nom= $request->get('nom');
        $produit->prix_vente= $request->get('prix_vente');
        $produit->quantite= $request->get('quantite');
        $produit->categorie= $request->get('categorie');
        $produit->prix_fournisseur= $request->get('prix_fournisseur');
        $produit->prix_livraison= $request->get('prix_livraison');
        $produit->description = $request->get('description');

        if ($request->hasFile('image')) {
            
            $produit->image = $request->file('image')->store(
                'produits/images',
                'public'
            );
        }
        $produit->save();
        $produits = Produit::all();
        return redirect()->route('produit.index')->with('success', 'Produit modifé avec succés ');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_produit)
    {
        $produit = Produit::find($id_produit);
        $produit->delete();
        return redirect()->route('produit.index')->with('success', 'le Produit a été supprimé ');        
    }

}
