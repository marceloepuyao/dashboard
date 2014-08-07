<?php

?>

<?php echo CHtml::dropDownList("fechas", "", $fechas);?>
<table align="center"><tr><td>
<div id="Percepcion-Interna" style="width: 400; height: 300">
</div>
</td></tr>
<tr><td>
<div id="Percepcion-Interna-Cliente" style="width: 900; height: 500"></div>
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
  //getDataClientes(fecha);
	
});
function start(){
	var fecha = $("#fechas option:selected").text();	
	getData(fecha);
  getDataClientes(fecha);
}

function getDataClientes(fecha){
  $.ajax({
        url: 'percepcionSMporClienteAjax',
    data: {'fecha':fecha},
      async: false,
      success: function (data){
          if (data){
            data = JSON.parse(data);
            drawChartPercepcionSMporCliente(data);
          }
      },
    });
}

function getData(fecha){
	$.ajax({
        url: 'percepcionSMAjax',
		data: {'fecha':fecha},
        async: false,
        success: function(data){
            if(data){
				data = data;
				drawChartPercepcionSM(data);
            }
        },
    });
  }

  function drawChartPercepcionSM(tasa){
	
  var data2 = google.visualization.arrayToDataTable([
	                                                    ['Label', 'Value'],
	                                                    ['Satisfacción SM', parseFloat(tasa)]]);
  
  	var options2 = {
  		'title': 'Satisfacción según SM',
  		'width': 200,
  		'height': 200,
  	};

  	var chart2 = new google.visualization.Gauge(document.getElementById('Percepcion-Interna'));
  	chart2.draw(data2, options2);
  }  

  function drawChartPercepcionSMporCliente(clientes){
    var data = google.visualization.arrayToDataTable(clientes, true);
    var options = {
          title: 'Satisfacción según SM por Cliente',
          vAxis: {title: 'Clientes',  titleTextStyle: {color: 'black'}},
          width: 900,
          height: 500,
          min: 0,
          max: 100,
    };

    var chart = new google.visualization.BarChart(document.getElementById('Percepcion-Interna-Cliente'));
    chart.draw(data, options);
  }
  </script>