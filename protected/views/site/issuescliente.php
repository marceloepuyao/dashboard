<?php
$this->breadcrumbs=array(
		'Issues',
);
?>


<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts-more.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/modules/solid-gauge.src.js"></script>

<div id="Clientes-Sin-Issues-Historico" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Issues-Cliente-Detalle" style="width: 700px; height: 500px; margin:0 auto 0 auto;"></div>
<div id="Issues-Servicio-Detalle" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Issues-Totales-Servicio" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<div id="Issues-Activos-Historicos-Cliente" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">

$(function () {
$('#Issues-Cliente-Detalle').highcharts({
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Issues Activos por Cliente (click para ver detalle)'
    },
    subtitle: {
        text: 'a la fecha'
    },
    xAxis: {
        categories: <?php echo json_encode(array_keys($issuesClientesDetalle));?>,
        		labels: {
             		step:1,
                },
        title: {
            text: null
        }
    },
    yAxis: {
    	allowDecimals: false,
        min: 0,
        title: {
            text: 'Issues',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' '
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        },
        series: {
        	cursor: 'pointer',
            point: {
                events: {
                    click: function () {
                    	window.location.replace("<?php echo $this->createUrl("issues"); ?>?cliente=" + this.category);
                    }
                }
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
        name: 'Issues Activos',
        data: <?php echo json_encode(array_values($issuesClientesDetalle));?>
    }]
});
$('#Issues-Servicio-Detalle').highcharts({
    chart: {
        type: 'column'
    },
    title: {
        text: 'Issues Activos por Lineas de Servicio'
    },
    subtitle: {
        text: 'a la fecha'
    },
    xAxis: {
        categories: <?php echo json_encode(array_keys($issuesServiciosDetalle))?> ,
        		labels: {
             		step:1,
                },
    },
    yAxis: {
      allowDecimals: false,
        min: 0,
        title: {
            text: 'Issues Activos'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
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
        name: 'Issues',
        data: <?php echo json_encode(array_values($issuesServiciosDetalle));?>

    }]
});
$('#Issues-Totales-Servicio').highcharts({
    chart: {
        type: 'column'
    },
    title: {
        text: 'Total Issues Creados por Servicios'
    },
    subtitle: {
        text: 'a la fecha'
    },
    xAxis: {
        categories: <?php echo json_encode(array_keys($issuesTotalesPorServicio))?> ,
        		labels: {
             		step:1,
                },
    },
    yAxis: {
      allowDecimals: false,
        min: 0,
        title: {
            text: 'Issues Activos'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
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
        name: 'Issues',
        data: <?php echo json_encode(array_values($issuesTotalesPorServicio));?>

    }]
});
 $('#Clientes-Sin-Issues-Historico').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Clientes sin Issues Histórico'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: <?php echo json_encode(array_keys($clientesSinIssuesHistorico));?> ,
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
        series: [{
            name: '% SLA cumplidos: ',
            data: <?php echo json_encode(array_values($clientesSinIssuesHistorico));?> 
        }]	
    });
 $('#Issues-Activos-Historicos-Cliente').highcharts({
	    chart: {
	        type: 'line'
	    },
	    title: {
	        text: 'Issues Activos Historicos por Cliente'
	    },
	    subtitle: {
	        text: ''
	    },
	    xAxis: {
	    	categories: <?php echo json_encode($fechas);?> ,
	    },
	    yAxis: {
	        title: {
	            text: 'Issues Activos'
	        },
	        min: 0,
	    },
	    plotOptions: {
	        line: {
	            dataLabels: {
	                enabled: true
	            },
	            enableMouseTracking: false
	        }
	    },
	    series: <?php echo $issuesHistoricosPorCliente;?> , 
	});

});

  </script>