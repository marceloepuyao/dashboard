<?php
$this->breadcrumbs=array(
		'Percepcion Externa',
);
?>

<?php //echo CHtml::dropDownList("fechas", "", $fechas);?>

<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts-more.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/modules/solid-gauge.src.js"></script>

<div id="Percepcion-General-Externa-Historico-Usuario" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Satisfaccion-Cliente" style="width: 700px; height: <?php echo 65 + count($satisfaccioncliente)*30;?>px; margin:0 auto 0 auto;"></div>
<div id="Percepcion-General-Externa-Historico" style="min-width: 310px; height: 500px; margin: 0 auto"></div>
<div id="Percepcion-Historico-Servicio-Total-Externa" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Percepcion-Servicio" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<h2>Vista por Cliente</h2>
<?php echo CHtml::label("Selecciona Cliente", "clientes");?>
<?php echo CHtml::dropDownList("clientes", "", $clientes);?>
<div id="Percepcion-Historico-Servicio-Cliente" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">

$(function () {
	
	percepcionGeneralExternaHistorico();
	percepcionGeneralExternaHistoricoUsuario();
	satisfaccionCliente();
	percepcionServicio();
	percepcionHistoricoServicioTotalExterna();
	percepcionHistoricoClienteServicios(<?php echo $cumplimientoDetallePorCliente;?>);

});

	$("#clientes").on("change",function(){
	    var cliente = $("#clientes option:selected").val(); 
	    getData(cliente);
	});
	
	function getData(cliente){
	    $.ajax({
	        url: 'percepcionHistoricoClienteServiciosAjax',
	        data: {'clienteid':cliente, 'type':'cl'},
	        async: false,
	        success: function(data){
	            if(data){
	                data = JSON.parse(data);
	                percepcionHistoricoClienteServicios(data);
	            }
	        },
	    });
	}

	function percepcionGeneralExternaHistorico(){
	    $('#Percepcion-General-Externa-Historico').highcharts({
	        chart: {
	            type: 'line'
	        },
	        title: {
	            text: 'Percepcion General Externa Histórica por Cliente'
	        },
	        subtitle: {
	            text: ''
	        },
	        xAxis: {
	            categories: <?php echo json_encode($fechas);?>,
	            		labels: {
	                 		step:1,
	                    },
	        },
	        yAxis: {
	            title: {
	                text: 'Percepción Externa General'
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
	        series: <?php echo $perclgeneralhistorica;?>
	    });
	}
	function percepcionGeneralExternaHistoricoUsuario(){
	    $('#Percepcion-General-Externa-Historico-Usuario').highcharts({
	        chart: {
	            type: 'line'
	        },
	        title: {
	            text: 'Satisfacción General Externa Histórica'
	        },
	        subtitle: {
	            text: ''
	        },
	        xAxis: {
	            categories: <?php echo json_encode($fechas);?>,
	            		labels: {
	                 		step:1,
	                    },
	                
	        },
	        yAxis: {
	            title: {
	                text: 'Percepción Externa General (%)'
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
	        series: <?php echo $pergeneralhistoricausuario;?>
	    });
	}
    function percepcionHistoricoServicioTotalExterna(){
        $('#Percepcion-Historico-Servicio-Total-Externa').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Satisfacción Histórica Externa por Línea de Servicio'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: <?php echo json_encode($fechas);?>,
                labels: {
                    step:1,
                }
            },
            yAxis: {
                title: {
                    text: 'Percepción'
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
            series: <?php echo $percepcionhistoricatotalclientesexterna;?>
        });
    }

	function satisfaccionCliente(){
	    $('#Satisfaccion-Cliente').highcharts({
	        chart: {
	            type: 'bar'
	        },
	        title: {
	            text: 'Percepcion General Externa por Cliente '
	        },
	        subtitle: {
	            text: 'fecha : <?php echo end($fechas);?> '
	        },
	        xAxis: {
	            categories: <?php echo json_encode(array_keys($satisfaccioncliente));?>,
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
	            max: 5,
	            title: {
	                text: 'Percepción',
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
	            name: 'seguimiento: ',
	            data: <?php echo json_encode(array_values($satisfaccioncliente));?>
	        }]
	    });
	}

	function percepcionServicio(){
	    $('#Percepcion-Servicio').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: 'Percepción Externa por líneas de Servicio'
	        },
	        subtitle: {
	        	text: 'fecha : <?php echo end($fechas);?> '
	        },
	        xAxis: {
	            categories: <?php echo json_encode(array_keys($percepcionclienteservicio));?>,
	        },
	        yAxis: {
	        	allowDecimals: false,
	            min: 0,
	            max: 5,
	            title: {
	                text: 'Percepción Externa'
	            }
	        },
	        tooltip: {
	            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	            pointFormat: '<tr><td style="color:{series.color};padding:0">{point.key}: </td>' +
	                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
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
	            name: 'líneas de servicio ',
	            data: <?php echo json_encode(array_values($percepcionclienteservicio));?>
	        }]
	    });
	}
	 function percepcionHistoricoClienteServicios(Series){
		    $('#Percepcion-Historico-Servicio-Cliente').highcharts({
		        chart: {
		            type: 'line'
		        },
		        title: {
		            text: 'Percepcion Externa Historica de Servicios por Cliente'
		        },
		        subtitle: {
		            text: ''
		        },
		        xAxis: {
		            categories: <?php echo json_encode($fechas);?>,
		            labels: {
		                step:1,
		            }
		        },
		        yAxis: {
		            title: {
		                text: 'Percepción Externa General'
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
		        series: Series
		    });
	}

</script>