@extends('layouts.ui')

@section('content')


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<canvas id="myChart" style="margin-top:10%;" height="400" width="1500"></canvas>
	
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



<canvas id="myChart_sorties" style="margin-top:10%;" height="400" width="1500"></canvas>

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