<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

?>

<h2>Dashboard Cliente</h2>

<?php

	/* 
	queries directas:
	Yii::app()->db->createCommand($slq)->execute();
	*/

	/*SCRIPS CSS Y JS
	<script src="../protected/lib/Highcharts/js/highcharts.js"></script>
	<script src="../protected/lib/Highcharts/js/highcharts-more.js"></script>
	<script src="../protected/lib/Highcharts/js/modules/exporting.js"></script>
	<script src="../protected/lib/Highcharts/js/modules/solid-gauge.src.js"></script>
	<script src="../protected/lib/Highmaps/js/highmaps.js"></script>
	<script src="../protected/lib/Highmaps/js/modules/exporting.js"></script>
	<script src="../protected/south-america.js"></script>
	*/
	/*
	$baseUrl = Yii::app()->baseurl;
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile($baseUrl.'/protected/lib/Highcharts/js/highcharts.js');
	$cs->registerScriptFile($baseUrl.'/protected/lib/Highcharts/js/highcharts-more.js');
	$cs->registerScriptFile($baseUrl.'/protected/lib/Highcharts/js/modules/exporting.js');
	$cs->registerScriptFile($baseUrl.'/protected/lib/Highcharts/js/modules/solid-gauge.src.js');
	$cs->registerScriptFile($baseUrl.'/protected/lib/Highmaps/js/highmaps.js');
	$cs->registerScriptFile($baseUrl.'/protected/lib/Highmaps/js/modules/exporting.js');
	$cs->registerScriptFile($baseUrl.'/protected/south-america.js');
	*/
	//$cs->registerScriptFile($baseUrl.'/js/highmaps.js');
	//$cs->registerScriptFile($baseUrl.'/js/highcharts.js');

	$idUsuario = Yii::app()->user->id; //id del usuario usando el sistema

	/*
	CUMPLIMIENTO DE SLAS, SEGUN LOS CLIENTES DEL USUARIO Y TODOS SUS CONTRATOS RESPECTIVOS - INICIO
	*/

	//$clientes = Usuario::model()->findByPk($idUsuario)->clientes; uso alternativo
	$clientes = Cliente::model()->findAll("usuario_id" == $idUsuario); //clientes del usuario en el sistema

	$contratos = array();
	foreach($clientes as $cliente){
		$contratos = Contrato::model()->findAll("cliente_id" == $cliente['id']);  
	}
	//se obtienen todos los contratos de todos los clientes del usuario
	
	
	$slaCumplidos = $cumplimiento_sla;
	$clientesSinIssues = $porcentajeClientesSinIssues;
	$slaPorCumplir = 100 - $cumplimiento_sla;

?>

<div id="contents">
	<table align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td>
				<a href="<?php echo Yii::app()->baseUrl."/site/issuesCliente";?>"><div id="Issues-Cliente" style="width: 400; height: 300"></div> </a>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl."/site/sla";?>"><div id="Cumplimiento-SLA" style="width: 400; height: 300"></div> </a>
			</td>
		</tr>
		<tr>
			<td>
				<a href="#"><div id="Percepcion-Externa" style="width: 400; height: 300"></div> </a>
			</td>
			<td>
				<a href="#"><div id="Percepcion-Interna" style="width: 400; height: 300"></div> </a>
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
<!-- JAVASCRIPT -->
<!--><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script><!-->

<!-->
<script type="text/javascript">

$(document).ready(function () {

    var gaugeOptions = {

	    chart: {
	        type: 'solidgauge'
	    },
	    
	    title: null,
	    
	    pane: {
	    	center: ['50%', '85%'],
	    	size: '140%',
	        startAngle: -90,
	        endAngle: 90,
            background: {
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
	    },

	    tooltip: {
	    	enabled: true
	    },
	       
	    // the value axis
	    yAxis: {
			stops: [
				[0.75, '#DF5353'], // red
	        	[0.8, '#DDDF0D'], // yellow
	        	[0.9, '#55BF3B'] // Green
			],
			lineWidth: 0,
            minorTickInterval: null,
            tickPixelInterval: 400,
            tickWidth: 0,
	        title: {
                y: -70
	        },
            labels: {
                y: 16
            }        
	    },
        
        plotOptions: {
            solidgauge: {
                dataLabels: {
                    y: -30,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        }
    };


          // The Issues cliente
    $('#Issues-Cliente').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
	        min: 0,
	        max: 100,
	        title: {
	            text: 'Clientes sin Issues Activos'
	        }       
	    },

	    credits: {
	    	enabled: false
	    },
			exporting: {
            enabled: false
        },
	
	    series: [{
	        name: '',
	        dataLabels: {
	        	format: '<div style="text-align:center"><span style="font-size:25px;color:' + 
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>' + 
                   	'<span style="font-size:12px;color:silver"></span></div>'
	        },
	        tooltip: {
	            valueSuffix: ' %',
				pointFormat: '% de Clientes que no tienen issues<br> activos : <strong>{point.y}</strong>'
	        }
	    }]
	
	
	}));



});




</script>
<!-->

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
	                                                    ['Percepcion Clientes', parseFloat(<?php echo $percepcionCliente; ?>)] ]);

  	var options3 = {
  		'title': 'Percepcion del SM',
  		'width': 200,
  		'height': 200,
  		'max': 5,
  		'min': 1,
  	};

  	var chart3 = new google.visualization.Gauge(document.getElementById('Percepcion-Externa'));
  	chart3.draw(data3, options3);


  }

  function drawChartPercepcionManager(){
  	var data4 = new google.visualization.arrayToDataTable([
	                                                    ['Label', 'Value'],
	                                                    ['Percepcion SM', parseFloat(<?php echo $percepcionSM; ?>)] ]);

  	var options4 = {
  		'title': 'Percepcion del SM',
  		'width': 200,
  		'height': 200,
  		'max': 5,
  		'min': 1,
  	};

  	var chart4 = new google.visualization.Gauge(document.getElementById('Percepcion-Interna'));
  	chart4.draw(data4, options4);


  }




</script>

