<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Membre;
use App\Inscription;
use App\Setting;
use App\Ouverture;
use App\Ticket;

class ApiController extends Controller
{
    public function scan_production(Request $request)
    {      
        $ticket =Ticket::where('codebar',$request['code'])->first();
        $ticket->satut= "vers_depot";
        $ticket->save();
        return response()->json(['reponse' => $ticket]);    
    } 
    /**
     * 
     */
    
     public function scan_depot(Request $request)
    {      
        $ticket =Ticket::where('codebar',$request['code'])->first();
        $ticket->satut= "au_depot";
        $ticket->save();
        return response()->json(['reponse' => $ticket]);    
    } 


}
