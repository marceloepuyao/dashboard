<?php

?>

<?php echo CHtml::dropDownList("fechas", "", $fechas);?>

<div id="Issues-Cliente" style="width: 400; height: 300">
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
        url: 'ClientesSinIssuesAjax',
		data: {'fecha':fecha},
        async: false,
        success: function(data){
            if(data){
				data = data;
				drawChartIssuesCliente(data);
            }
        },
    });
	

  }
  //este segundo chart es, de hecho, el primero en programarse en php más arribita
  function drawChartIssuesCliente(tasa){
	
  var data1 = google.visualization.arrayToDataTable([
	                                                    ['Label', 'Value'],
	                                                    ['Tasa de Clientes Sin Issues', parseFloat(tasa)]]);
  
  	var options1 = {
  		'title': 'Tasa de Clientes Sin Issues Activos',
  		'width': 200,
  		'height': 200
  	};

  	var chart1 = new google.visualization.Gauge(document.getElementById('Issues-Cliente'));
  	chart1.draw(data1, options1);
  }  
  </script>