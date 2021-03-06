<?php
$this->breadcrumbs=array(
		'SLA',
);
?>
<h2>Vista General</h2>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts-more.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/modules/solid-gauge.src.js"></script>

<div id="Cumplimiento-SLA-Historico-Simple" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Cumplimiento-SLA-Cliente" style="width: 700px; height: <?php echo 130 + count($cumplimientoSlaPorCliente)*35;?>px; margin: 0 auto 0 auto;"></div>
<div id="Cumplimiento-SLA-Historico" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<h2>Vista por Cliente</h2>
<?php echo CHtml::label("Selecciona Cliente", "clientes");?>
<?php echo CHtml::dropDownList("clientes", "", $clientes);?>
<div id="Cumplimiento-Detalle-Cliente" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Cumplimiento-SLA-Detalle-Historico" style="min-width: 310px; height: 400px; margin: 0 auto"></div>



<script type="text/javascript">

$(function () { 
	cumplimientoSlaHistorico(<?php echo json_encode($fechas);?> , <?php echo $cumplimientoSlaHistoricoPorCliente;?> );
    cumplimientoSlaCliente(<?php echo json_encode(array_keys($cumplimientoSlaPorCliente));?> ,  <?php echo json_encode(array_values($cumplimientoSlaPorCliente));?>);
    cumplimientoDetalleCliente(<?php echo json_encode(array_keys($cumplimientoDetallePorCliente));?> ,  <?php echo json_encode(array_values($cumplimientoDetalleObjetivo));?>,  <?php echo json_encode(array_values($cumplimientoDetalleValor));?>);
    cumplimientoHistoricoSimple(<?php echo json_encode($fechas);?> , <?php echo json_encode(array_values($cumplimientoSlaHistorico));?>);
    cumplimientoSlaDetalleHistorico(<?php echo json_encode($fechas);?> , <?php echo $cumplimientoSlaDetalleHistorico;?> );

	<?php //$cumplimientoSlaDetalleHistorico ?>
});

$("#clientes").on("change",function(){
	var cliente = $("#clientes option:selected").val();	
	getData(cliente);
	getData2(cliente);
});

function getData(cliente){
	$.ajax({
        url: 'cumplimientoDetalleClienteAjax',
        data: {'fecha':<?php echo end($fechas);?>, 'clienteid':cliente},
        async: false,
        success: function(data){
            if(data){
                data = JSON.parse(data);
                cumplimientoDetalleCliente(data.categories, data.objetivo, data.valor);
            }
        },
    });
}
function getData2(cliente){
	$.ajax({
        url: 'cumplimientoDetalleHistoricoClienteAjax',
		data: {'clienteid':cliente},
        async: false,
        success: function(data){
            if(data){
                data = JSON.parse(data);
                cumplimientoSlaDetalleHistorico(<?php echo json_encode($fechas);?>, data);
            }
        },
    });
}

function cumplimientoHistoricoSimple(categories, data){
    $('#Cumplimiento-SLA-Historico-Simple').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Cumplimiento Histórico SLA'
        },
        subtitle: {
            text: ''
        },
        credits: {
	    	enabled: false
	    },
        xAxis: {
        	categories: categories
        },
        yAxis: {
            title: {
                text: 'Cumplimiento SLA (%)'
            },
            min: 0,
            max: 100
        },

        plotOptions: {
            line: {
            	pointPadding: 0.2,
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: '% SLA cumplidos: ',
            data: data 
        }] 
    });

	
}


function cumplimientoSlaHistorico(categories, data){
	 $('#Cumplimiento-SLA-Historico').highcharts({
	        chart: {
	            type: 'line'
	        },
	        title: {
	            text: 'Cumplimiento Histórico SLA'
	        },
	        subtitle: {
	            text: ''
	        },
	        credits: {
		    	enabled: false
		    },
	        xAxis: {
	            categories: categories,
	            labels: {
		            step:1,
		        }
	        },
	        yAxis: {
		        min:0,
		        max:100,
	            title: {
	                text: 'Cumplimiento SLA (%)'
	            }
	        },
	        plotOptions: {
	            line: {
	                dataLabels: {
	                    enabled: true
	                },
	                enableMouseTracking: false
	            }
	        },
	        series: data 
	    });
}

function cumplimientoSlaCliente(categories, data){
	$('#Cumplimiento-SLA-Cliente').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Cumplimiento SLA por cliente'
        },
        subtitle: {
            text: 'fecha : <?php echo end($fechas);?> '
        },
        xAxis: {
            categories: categories,
	        labels: {
	            step:1,
	        }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cumplimiento SLA (%)',
                align: 'high'
            },
            labels: {
                overflow: 'justify',
                step:2,
            }
        },
        tooltip: {
            valueSuffix: ' %'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: '% SLA cumplidos: ',
            data: data 
        }]
    });	
}

function cumplimientoDetalleCliente(categories, dataobjetivo, datavalor){
	 $('#Cumplimiento-Detalle-Cliente').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: 'SLA objetivo-valor Detalle Cliente'
	        },
	        subtitle: {
	        	text: 'fecha : <?php echo end($fechas);?> '
	        },
	        credits: {
		    	enabled: false
		    },
	        xAxis: {
	            categories: categories,
	            labels: {
		            step:1,
		        }
	        },
	        yAxis: {
	            min: 0,
	            max: 100,
	            title: {
	            	text: 'Cumplimiento SLA (%)',
	                align: 'high'
	            }
	        },
	        tooltip: {
	            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	                '<td style="padding:0"><b>{point.y:.1f} % </b></td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
	        plotOptions: {
	            column: {
	                pointPadding: 0.2,
	                borderWidth: 0
	            }
	        },
	        series: [{
	            name: '% SLA Objetivo: ',
	            data: dataobjetivo
	        },{
				name: '% SLA Valor: ',
				data: datavalor
	        }]
	    });

	
}

function cumplimientoSlaDetalleHistorico(categories, data){
	 $('#Cumplimiento-SLA-Detalle-Historico').highcharts({
	        chart: {
	            type: 'line'
	        },
	        title: {
	            text: 'Valor seguimiento de Cliente por SLA'
	        },
	        subtitle: {
	            text: ''
	        },
	        credits: {
		    	enabled: false
		    },
	        xAxis: {
	            categories: categories,
	            labels: {
		            step:1,
		        }
	        },
	        yAxis: {
		        min:0,
		        max:100,
	            title: {
	                text: 'Cumplimiento SLA (%)'
	            }
	        },
	        plotOptions: {
	            line: {
	                dataLabels: {
	                    enabled: true
	                },
	                enableMouseTracking: false
	            }
	        },
	        series: data 
	    });
}

</script>
