<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h2>Dashboard Cliente</h2>

<p>Aquí van dashboard de estado regiones </p>

<?php

	/* 
	queries directas:
	Yii::app()->db->createCommand($slq)->execute();
	*/

	$idUsuario = Yii::app()->user->id; //id del usuario usando el sistema

	//VOY A REPETIR TODO EL CÓDIGO Y LAS VARIABLES LAS VOY A DEFINIR DE NUEVO PORQUE TENGO HASTA EL VIERNES PARA HACER TODAS LAS WEAS
	//Y TODAVÍA NI SIQUIERA HE USADO LA LIBRERÍA JAVASCRIPT QUE SE VA A VER AL FINAL - MIÉRCOLES 30 DE JULIO, 20:21 HORAS
	// /RANT

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
	
	$SLAs = array();
	foreach($contratos as $contrato){
		$SLAs = Sla::model()->findAll("sla_id" == $contrato['id']);
	}
	//se obtienen todos los SLA de los contratos de los clientes del usuario

	//contar SLAs
	$totalSLAs = 0; //todos los SLA
	$cumplimientoSLAs = 0; //% de cumplimiento acumulado de los SLA
	foreach($SLAs as $SLA){
		$totalSLAs += 1;
		$cumplimientoSLAs += $SLA['objetivo']/100;
	}

	/*
	CUMPLIMIENTO DE SLAS, SEGUN LOS CLIENTES DEL USUARIO Y TODOS SUS CONTRATOS RESPECTIVOS - FIN
	*/

	/*
	CLIENTES SIN ISSUES ACTIVOS, SEGÚN EL USUARIO - INICIO
	*/
	$clientes = Cliente::model()->findAll("usuario_id" == $idUsuario);

	$issues = array();
	$totalClientes = 0;
	$clientesConIssues = 0;
	foreach($clientes as $cliente){
		$totalClientes += 1;
		$issues = Issue::model()->findAll('cliente_id' == $cliente['id']);
		foreach($issues as $issue){
			if($issue['solucionado'] != 2){ 
				$clientesConIssues += 1;
				break;
			}
		}
	}
	/*
	CLIENTES SIN ISSUES ACTIVOS, SEGÚN EL USUARIO - FIN
	*/

	/*
	
	*/


?>

<a href="#"><div id="Issues-Cliente" style="width: 300px; height: 200px; float: left"></div> </a>

</br>
</br>
</br>
</br>
</br>
</br>
</br>

<!-- JAVASCRIPT -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<script type="text/javascript">

$(function () {
	
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
	            text: '% Clientes sin Issues Activos'
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
	        data: [<?=round(($clientesConIssues/$totalClientes)*100)?>],
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

	// Bring life to the dials
    setInterval(function () {
    	// Speed
        var chart = $('#Issues-Cliente').highcharts();
        if (chart) {
            var point = chart.series[0].points[0],
                newVal,
                inc = Math.round((Math.random() - 0.5) * 1);
            
            newVal = point.y + inc;
            if (newVal < 0 || newVal > 200) {
                newVal = point.y - inc;
            }
            
            point.update(newVal);
        }
}




</script>

<script src="../protected/lib/Highcharts/js/highcharts.js"></script>
<script src="../protected/lib/Highcharts/js/highcharts-more.js"></script>
<script src="../protected/lib/Highcharts/js/modules/exporting.js"></script>
<script src="../protected/lib/Highcharts/js/modules/solid-gauge.src.js"></script>
<script src="../protected/lib/Highmaps/js/highmaps.js"></script>
<script src="../protected/lib/Highmaps/js/modules/exporting.js"></script>
<script src="../protected/south-america.js"></script>
