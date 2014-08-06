<?php

?>

<?php echo CHtml::dropDownList("fechas", "", $fechas);?>
<table><tr><td>
<div id="Cumplimiento-SLA" style="width: 400; height: 300">
</div>
</td></tr>
<tr><td>
<div id="Cumplimiento-SLA-Cliente" style="width: 900; height: 500">
</td></tr>

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
	getData("201428");
  getDataClientes("201428");
}

function getDataClientes(fecha){
  $.ajax({
        url: 'CumplimientoSlaPorClienteAjax',
    data: {'fecha':fecha},
      async: false,
      success: function (data){
          if (data){
            data = JSON.parse(data);
            alert(data);
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
    alert(clientes);

    //var chart = new google.visualization.BarChart(document.getElementById('Cumplimiento-SLA-Cliente'));

  }
  </script>