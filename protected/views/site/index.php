<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

?>

<h2>Dashboard Cliente</h2>

<?php

	$idUsuario = Yii::app()->user->id; //id del usuario usando el sistema

	$clientes = Cliente::model()->findAll("usuario_id" == $idUsuario); //clientes del usuario en el sistema

	$contratos = array();
	foreach($clientes as $cliente){
		$contratos = Contrato::model()->findAll("cliente_id" == $cliente['id']);  
	}	
	$slaCumplidos = $cumplimiento_sla;
	$clientesSinIssues = $porcentajeClientesSinIssues;

	$slaPorCumplir = 100 - $cumplimiento_sla;

?>

<div id="contents">
<?php $fechaActual = date('Y-W'); echo $fechaActual;?>
	<table align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td>
				<a href="<?php echo Yii::app()->baseUrl."/site/issuescliente";?>"><div id="Issues-Cliente" style="width: 400; height: 300"></div> </a>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl."/site/sla";?>"><div id="Cumplimiento-SLA" style="width: 400; height: 300"></div> </a>
			</td>
		</tr>
		<tr>
			<td>
				<a href="<?php echo Yii::app()->baseUrl."/site/percl";?>"><div id="Percepcion-Externa" style="width: 400; height: 300"></div> </a>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl."/site/persm";?>"><div id="Percepcion-Interna" style="width: 400; height: 300"></div> </a>
			</td>
		</tr>
	</table>
</div>

</br>
</br>
</br>
</br>
</br>
</br>
</br>
</html>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

  // Load the Visualization API library and the piechart library.
  google.load('visualization', '1.0', {'packages':['corechart']});
  google.load('visualization', '1', {packages:['gauge']});
  
  google.setOnLoadCallback(drawChartIssuesCliente);
  google.setOnLoadCallback(drawChartCumplimientoSLA);
  google.setOnLoadCallback(drawChartPercepcionCliente);
  google.setOnLoadCallback(drawChartPercepcionManager);
     // ... draw the chart...

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
  //este segundo chart es, de hecho, el primero en programarse en php más arribita
  function drawChartCumplimientoSLA(){
	
  var data2 = google.visualization.arrayToDataTable([
	                                                    ['Label', 'Value'],
	                                                    ['Tasa de SLA cumplido', parseFloat(<?php echo $slaCumplidos; ?>)] ]);
  
	                                          	
	
  	var options2 = {
  		'title': 'Tasa de SLA cumplidos',
  		'width': 200,
  		'height': 200
  	};

  	var chart2 = new google.visualization.Gauge(document.getElementById('Cumplimiento-SLA'));
  	chart2.draw(data2, options2);


  }  

  function drawChartPercepcionCliente(){
  	var data3 = new google.visualization.arrayToDataTable([
	                                                    ['Label', 'Value'],
	                                                    ['Satisfacción Clientes', parseFloat(<?php echo $percepcionCliente; ?>)] ]);

  	var options3 = {
  		'title': 'Percepcion del SM',
  		'width': 200,
  		'height': 200
  	};

  	var chart3 = new google.visualization.Gauge(document.getElementById('Percepcion-Externa'));
  	chart3.draw(data3, options3);


  }

  function drawChartPercepcionManager(){
  	var data4 = new google.visualization.arrayToDataTable([
	                                                    ['Label', 'Value'],
	                                                    ['Satisfacción SM', parseFloat(<?php echo $percepcionSM; ?>)] ]);

  	var options4 = {
  		'title': 'Percepcion del SM',
  		'width': 200,
  		'height': 200
  	};

  	var chart4 = new google.visualization.Gauge(document.getElementById('Percepcion-Interna'));
  	chart4.draw(data4, options4);


  }




</script>

