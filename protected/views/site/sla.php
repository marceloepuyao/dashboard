<?php

?>

<?php echo CHtml::dropDownList("fechas", "", $fechas);?>

<div id="Cumplimiento-SLA" style="width: 400; height: 300">
</div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

// Load the Visualization API library and the piechart library.
google.load('visualization', '1.0', {'packages':['corechart']});
google.load('visualization', '1', {packages:['gauge']});

google.setOnLoadCallback(start);

$("#fechas").on("change",function(){
	var fecha = $("#fechas option:selected").text();	
	getData(fecha);
	
});
function start(){
	getData("201431");
}


function getData(fecha){
	$.ajax({
        url: 'cumplimientoSlaAjax',
		data: {'fecha':fecha},
        async: false,
        success: function(data){
            if(data){
				data = data;
				drawChartCumplimientoSLA(data);
            }
        },
    });
	

  }
  //este segundo chart es, de hecho, el primero en programarse en php más arribita
  function drawChartCumplimientoSLA(tasa){
	
  var data2 = google.visualization.arrayToDataTable([
	                                                    ['Label', 'Value'],
	                                                    ['Tasa de SLA cumplido', parseFloat(tasa)]]);
  
  	var options2 = {
  		'title': 'Tasa de SLA cumplidos',
  		'width': 200,
  		'height': 200
  	};

  	var chart2 = new google.visualization.Gauge(document.getElementById('Cumplimiento-SLA'));
  	chart2.draw(data2, options2);
  }  
  </script>