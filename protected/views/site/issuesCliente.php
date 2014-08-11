<?php
$clientesSinIssues = $porcentajeClientesSinIssues;
$detalleIssuesClientes = $issuesClientesDetalle;
$detalleIssuesServicios = $issuesServiciosDetalle;
?>

<table align="center"><tr><td>
<div id="Issues-Cliente" style="width: 400; height: 300"></div>
</td></tr>
<tr><td>
<div id="Issues-Cliente-Detalle" style="width: 900; height: 500"></div>
</td></tr>
<tr><td>
<div id="Issues-Servicio-Detalle" style="width: 900; height: 500"></div>
</td></tr>
</table>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

// Load the Visualization API library and the piechart library.
google.load('visualization', '1.0', {'packages':['corechart']});
google.load('visualization', '1', {packages:['gauge']});
google.setOnLoadCallback(drawChartIssuesCliente);
google.setOnLoadCallback(drawChartIssuesClienteDetalle);
google.setOnLoadCallback(drawChartIssuesServicioDetalle);

function drawChartIssuesCliente(){
  var data1 = google.visualization.arrayToDataTable([
                                                      ['Label', 'Value'],
                                                      ['Clientes Sin Issues', parseFloat(<?php echo $clientesSinIssues;
                                                        ?>)] ]);
    var options1 = {
      'title': 'Tasa de Issues de Clientes',
      'width': 200,
      'height': 200
    };

    var chart1 = new google.visualization.Gauge(document.getElementById('Issues-Cliente'));
    chart1.draw(data1, options1);

}


  function drawChartIssuesClienteDetalle(){
  
    var data = google.visualization.arrayToDataTable(<?php $json = json_encode($detalleIssuesClientes); echo $json;?>, true);
  
    var options = {
          title: 'Tasa de Issues Cumplidos por Cliente',
          vAxis: {title: 'Clientes',  titleTextStyle: {color: 'black'}},
          width: 900,
          height: 500,
          min: 0,
          max: 100,
    };

    var chart = new google.visualization.BarChart(document.getElementById('Issues-Cliente-Detalle'));
    chart.draw(data, options);
  }  

  function drawChartIssuesServicioDetalle(){
  
    var data2 = google.visualization.arrayToDataTable(<?php $json = json_encode($detalleIssuesServicios); echo $json;?>, true);
  
    var options2 = {
          title: 'Issues Activos por Servicio',
          vAxis: {title: 'Servicios',  titleTextStyle: {color: 'black'}},
          width: 900,
          height: 500,
    };

    var chart = new google.visualization.BarChart(document.getElementById('Issues-Servicio-Detalle'));
    chart.draw(data2, options2);
  }  
  </script>