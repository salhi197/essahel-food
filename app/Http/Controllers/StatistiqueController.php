<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Ticket;

class StatistiqueController extends Controller
{

    public function index()
    {

        $last_month = date('Y-m-d',strtotime("-30 days"));

        $tickets_jour_created = DB::select("select date(created_at) as created_at, count(id) as nb_ticket 
        from tickets where (satut='0' and date(created_at) >= date('$last_month') )group by date(created_at) order by date(created_at) asc limit 30");

        $tickets_jour_created = Ticket::extract_date_and_number($tickets_jour_created);

        $jours_1 = (json_encode($tickets_jour_created->date));
        $numbers_1 = (json_encode($tickets_jour_created->numbers));


        $tickets_jour_sorties = DB::select("select date(updated_at) as created_at, count(id) as nb_ticket 
        from tickets where (satut<>'0' and date(updated_at) >= date('$last_month') )group by date(updated_at) order by date(updated_at) asc limit 30");

        $tickets_jour_sorties = Ticket::extract_date_and_number($tickets_jour_sorties);

        $jours_sorties = (json_encode($tickets_jour_sorties->date));
        $numbers_sorties = (json_encode($tickets_jour_sorties->numbers));


        return view('Statistiques.stat',compact('jours_sorties','numbers_sorties','jours_1','numbers_1'));

        // code...
    }

    //
}
