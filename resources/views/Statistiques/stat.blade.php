@extends('layouts.ui')

@section('content')


<div class="container-fluid py-4">

    <div class="row">

		<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
		    <div class="card">
		        <div class="card-body p-3">
		            <div class="row">
		                <div class="col-8">
		                    <div class="numbers">
		                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Aujoud'hui</p>
		                        <h5 class="font-weight-bolder mb-0">
		                            {!! $nb_tickets_today !!} <span style="font-size:10px;">Générés</span> 
		                            
		                            @if ($pctg_ceation_ysterday_today>=0)

			                            <span class="text-success text-sm font-weight-bolder">

			                        @else    	
										<span class="text-danger text-sm font-weight-bolder">		                            	
		                            @endif
	
			                            {{ $pctg_ceation_ysterday_today }}%
			                        </span>
		                        </h5>
		                    </div>
		                </div>
		                <div class="col-4 text-end">
		                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
		                        <i class="ni ni-badge text-lg opacity-10" aria-hidden="true"></i>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>


		<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
		    <div class="card">
		        <div class="card-body p-3">
		            <div class="row">
		                <div class="col-8">
		                    <div class="numbers">
		                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Aujourd'hui</p>
		                        <h5 class="font-weight-bolder mb-0">
		                            {!! $nb_sorties_today !!} <span style="font-size:10px;">sorties</span>

		                            @if ($pctg_ceation_ysterday_today>=0)

			                            <span class="text-success text-sm font-weight-bolder">

			                        @else    	
										<span class="text-danger text-sm font-weight-bolder">		                            	
		                            @endif

		                            	{!! $pctg_sortie_ysterday_today !!}%
		                        	</span>
		                        </h5>
		                    </div>
		                </div>
		                <div class="col-4 text-end">
		                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
		                        <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" style="filter: blur(0.1rem);">
		    <div class="card">
		        <div class="card-body p-3">
		            <div class="row">
		                <div class="col-8">
		                    <div class="numbers">
		                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Vente </p>
		                        <h5 class="font-weight-bolder mb-0">
		                            
		                            <span class="text-success text-sm font-weight-bolder">Comming soon</span>
		                        </h5>
		                    </div>
		                </div>
		                <div class="col-4 text-end">
		                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
		                        <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="col-xl-3 col-sm-6" style="filter: blur(0.1rem);">
		    <div class="card">
		        <div class="card-body p-3">
		            <div class="row">
		                <div class="col-8">
		                    <div class="numbers">
		                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Vente</p>
		                        <h5 class="font-weight-bolder mb-0">
		                            {{-- $103,430 --}}
		                            <span class="text-success text-sm font-weight-bolder">Comming soon</span>
		                        </h5>
		                    </div>
		                </div>
		                <div class="col-4 text-end">
		                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
		                        <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>		



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="card">

	<div class="card-body p-3">

		<canvas id="myChart" style="margin-top:10%;" height="400" width="1500"></canvas>
	</div>

</div>	
	
<script>


  	const labels = {!! $jours_1 !!};

  	const data = 
  	{
	    labels: labels,
	    datasets: [{
	    label: 'Tickets Imprimés',
	    backgroundColor: 'rgb(25, 255, 233)',
	    borderColor: 'rgb(25, 255, 233)',
	    data: {!! $numbers_1 !!},
	    }]
  	};

  	const config = 
  	{
	    type: 'line',
	    data: data,
	    options: {}
  	};

	const myChart = new Chart(
	
	document.getElementById('myChart'),
	config
	);

  	//
</script>



<div class="card" style="margin-top: 2%;" >

	<div class="card-body p-3">

		<canvas id="myChart_sorties" style="margin-top:10%;" height="400" width="1500"></canvas>
	</div>	
</div>		

<script>

  	const labels_sorties = {!! $jours_sorties !!};
  	
  	const data_sorties = 
  	{
	    labels: labels_sorties,
	    datasets: [{
	    label: 'Tickets envoyés',
	    backgroundColor: 'rgb(25, 255, 233)',
	    borderColor: 'rgb(100, 255, 100)',
	    data: {!! $numbers_sorties !!},
	    }]
  	};


  	const config_sorties = 
  	{
	    type: 'line',
	    data: data_sorties,
	    options: {}
  	};

	const myChart_sorties = new Chart(
	document.getElementById('myChart_sorties'),
	config_sorties
	);


	/**/
</script>
 


@endsection