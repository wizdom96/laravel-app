<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>
<body>
<h2 style="text-align: center; padding-top:30px">
{{$name}}
</h2>
	<br><br><div>	
<div style="width: 48%;padding-left:50px; float:left">
<label><b>Please select to show graph</b></label>
<select onchange="getSelected()" id="interval" class="browser-default custom-select" >
<option selected value="0">Select...</option>
  <option  value="weekly">Weekly</option>
  <option value="monthly">Monthly</option>
</select>

<br><br>
<div id="chartContainer" style="height: 370px;"></div>

</div>


<div style="width: 48%;padding-right:50px; float:right">

<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">Client</th>
      <th scope="col">Client Type</th>
      <th scope="col">Date</th>
	  <th scope="col">Type Of Call</th>
    </tr>
  </thead>
  
  <tbody>
  @foreach ($lastcalls as $lastcall)
    <tr>
      <th>{{$lastcall->client}}</th>
      <td>{{$lastcall->client_type}}</td>
      <td>{{$lastcall->date}}</td>
      <td>{{$lastcall->type_of_call}}</td>
    </tr>
	@endforeach
  </tbody>
</table>

</div>





</body>
</html>

<script>

window.onload = function(e){ 
	
	let ars7 = {{ $ars7 }}; 
	let call7 = {{ $callduration7 }}; 
	 averageTotalWeek = ars7.map(function(x) { 
 	 return { 
    y: x[0] 
  }; 
});
 averageCallWeek = call7.map(function(x) { 
 	 return { 
    y: x[0] 
  }; 
});

let ars30 = {{ $ars30 }}; 
		let call30 = {{ $callduration30 }}; 
		 averageTotalMonth = ars30.map(function(x) { 
 	 	return { 
   			 y: x[0] 
 		 }; 
		});
		 averageCallMonth = call30.map(function(x) { 
 	 		return { 
    		y: x[0] 
 			 }; 
		});

console.log(averageTotalMonth);
console.log(averageTotalWeek);

}

function getSelected() {
    onchange = function() {
		interval= document.getElementById("interval").value
		if(interval == "weekly"){
			let averageTotal = averageTotalWeek;
			let averageCall = averageCallWeek;

			let chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Statistics"
	},
	axisX: {
		
	},
	axisY: {
		title: "Value",
	
	},
	legend:{
		cursor: "pointer",
		fontSize: 16,
		itemclick: toggleDataSeries
	},
	toolTip:{
		shared: true
	},
	data: [{
		name: "External Score",
		type: "spline",
		
		showInLegend: true,
		dataPoints: averageTotal
	},
	{
		name: "Call Duration(in hours)",
		type: "spline",
		
		showInLegend: true,
		dataPoints: averageCall
	},
	]
	
});
chart.render();

function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}

} 
else if(interval == 'monthly')
{
			let averageTotal = averageTotalMonth;
			let averageCall = averageCallMonth;

			let chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Statistics"
	},
	axisX: {
		
	},
	axisY: {
		title: "Value",
	
	},
	legend:{
		cursor: "pointer",
		fontSize: 16,
		itemclick: toggleDataSeries
	},
	toolTip:{
		shared: true
	},
	data: [{
		name: "External Score",
		type: "spline",
		
		showInLegend: true,
		dataPoints: averageTotal
	},
	{
		name: "Call Duration(in hours)",
		type: "spline",
		
		showInLegend: true,
		dataPoints: averageCall
	},
	]
	
});
chart.render();

function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) 
	{
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}


} else {
	return;
}
		}
  };
</script>