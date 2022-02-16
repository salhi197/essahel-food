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
        from tickets where (date(created_at) >= date('$last_month') )group by date(created_at) order by date(created_at) asc limit 30");

        $tickets_jour_created = Ticket::extract_date_and_number($tickets_jour_created);

        $jours_1 = (json_encode($tickets_jour_created->date));
        $numbers_1 = (json_encode($tickets_jour_created->numbers));


        $tickets_jour_sorties = DB::select("select date(updated_at) as created_at, count(id) as nb_ticket 
        from tickets where (satut<>'0' and date(updated_at) >= date('$last_month') )group by date(updated_at) order by date(updated_at) asc limit 30");

        $tickets_jour_sorties = Ticket::extract_date_and_number($tickets_jour_sorties);

        $jours_sorties = (json_encode($tickets_jour_sorties->date));
        $numbers_sorties = (json_encode($tickets_jour_sorties->numbers));


        /*comparaison today yesterday*/

        $yesterday = date('Y-m-d',strtotime("-1 days"));
        
        $today = date('Y-m-d');
        
        $nb_tickets_today=DB::select("select count(satut) as nb_ticket_today from tickets where (date(created_at) = date('$today'))");
        
        $nb_tickets_today = ($nb_tickets_today[0]->nb_ticket_today);

        $nb_tickets_yesterday=DB::select("select count(satut) as nb_ticket_yesterday from tickets where (date(created_at) = date('$yesterday'))");
        
        $nb_tickets_yesterday = ($nb_tickets_yesterday[0]->nb_ticket_yesterday);

        ($nb_tickets_yesterday==0) ? $pctg_ceation_ysterday_today = 0 : $pctg_ceation_ysterday_today=number_format((float)((($nb_tickets_today/$nb_tickets_yesterday)-1)*100), 1, '.', '');

       
        /*sorties */

        $nb_sorties_today=DB::select("select count(satut) as nb_sortie_today from tickets where (date(updated_at) = date('$today') and satut='sortie')");
        
        $nb_sorties_today = ($nb_sorties_today[0]->nb_sortie_today);

        $nb_sorties_yesterday=DB::select("select count(satut) as nb_sortie_yesterday from tickets where (date(updated_at) = date('$yesterday') and satut='sortie')");
        
        $nb_sorties_yesterday = ($nb_sorties_yesterday[0]->nb_sortie_yesterday);

        ($nb_sorties_yesterday==0) ? $pctg_sortie_ysterday_today = 0 : $pctg_sortie_ysterday_today=number_format((float)((($nb_sorties_today/$nb_sorties_yesterday)-1)*100), 1, '.', '');

        return view('Statistiques.stat',compact('jours_sorties','numbers_sorties','jours_1','numbers_1','pctg_ceation_ysterday_today','nb_tickets_today','pctg_sortie_ysterday_today','nb_sorties_today'));

        // code...
    }

    //
}
