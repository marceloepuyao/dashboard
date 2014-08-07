<?php

?>

<?php echo CHtml::dropDownList("fechas", "", $fechas);?>
<table align="center"><tr><td>
<div id="Cumplimiento-SLA" style="width: 400; height: 300">
</div>
</td></tr>
<tr><td>
<div id="Cumplimiento-SLA-Cliente" style="width: 900; height: 500"></div>
</td></tr>
</table>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

// Load the Visualization API library and the piechart library.
google.load('visualization', '1.0', {'packages':['corechart']});
google.load('visualization', '1', {packages:['gauge']});

google.setOnLoadCallback(start);

$("#fechas").on("change",function(){
	var fecha = $("#fechas option:selected").text();	
	getData(fecha);
  getDataClientes(fecha);
	
});
function start(){
	var fecha = $("#fechas option:selected").text();
	getData(fecha);
  getDataClientes(fecha);
}

function getDataClientes(fecha){
  $.ajax({
        url: 'CumplimientoSlaPorClienteAjax',
    data: {'fecha':fecha},
      async: false,
      success: function (data){
          if (data){
            data = JSON.parse(data);
            drawChartCumplimientoSLACliente(data);
          }
      },
    });
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

  function drawChartCumplimientoSLA(tasa){
	
  var data2 = google.visualization.arrayToDataTable([
	                                                    ['Label', 'Value'],
	                                                    ['Tasa de SLA cumplido', parseFloat(tasa)]]);
  
  	var options2 = {
  		'title': 'Tasa de SLA cumplidos',
  		'width': 200,
  		'height': 200,
  	};

  	var chart2 = new google.visualization.Gauge(document.getElementById('Cumplimiento-SLA'));
  	chart2.draw(data2, options2);
  }  

  function drawChartCumplimientoSLACliente(clientes){
    var data = google.visualization.arrayToDataTable(clientes, true);
    var options = {
          title: 'Tasa de SLA Cumplidos por Cliente',
          vAxis: {title: 'Clientes',  titleTextStyle: {color: 'black'}},
          width: 900,
          height: 500,
          min: 0,
          max: 100,
    };

    var chart = new google.visualization.BarChart(document.getElementById('Cumplimiento-SLA-Cliente'));
    chart.draw(data, options);
  }
  </script>