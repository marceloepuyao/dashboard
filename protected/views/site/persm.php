<?php
$this->breadcrumbs=array(
		'Percepcion Externa',
);
?>

<?php //echo CHtml::dropDownList("fechas", "", $fechas);?>
<h2>Vista General</h2>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts-more.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/modules/solid-gauge.src.js"></script>

<div id="Percepcion-General-Interna-Historico-Usuario" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Satisfaccion-SM" style="width: 700px; height: <?php echo 130 + count($satisfaccionsm)*35;?>px; margin:0 auto 0 auto;"></div>
<div id="Percepcion-General-Interna-Historico" style="min-width: 310px; height: 500px; margin: 0 auto"></div>
<div id="Percepcion-Servicio" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Percepcion-Historico-Servicio-Total" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<h2>Vista por Cliente</h2>
<?php echo CHtml::label("Selecciona Cliente", "clientes");?>
<?php echo CHtml::dropDownList("clientes", "", $clientes);?>
<div id="Percepcion-Historico-Servicio-Cliente" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Percepcion-Historico-Servicio-Cliente-Total" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">
	$(function () {
	
		percepcionGeneralInternaHistorico();
		percepcionGeneralInternaHistoricoUsuario();
		satisfaccionSm();
		percepcionServicio();
        percepcionHistoricoServicioTotal();
		percepcionHistoricoClienteServicios(<?php echo $cumplimientoDetallePorCliente;?>);
        var cliente = $("#clientes option:selected").val(); 
        getData2(cliente);

	});

    $("#clientes").on("change",function(){
        var cliente = $("#clientes option:selected").val(); 
        getData(cliente);
        getData2(cliente);
    });

    function getData(cliente){
        $.ajax({
            url: 'percepcionHistoricoClienteServiciosAjax',
            data: {'clienteid':cliente, 'type':'sm'},
            async: false,
            success: function(data){
                if(data){
                    data = JSON.parse(data);
                    percepcionHistoricoClienteServicios(data);
                }
            },
        });
    }
    function getData2(cliente){
        $.ajax({
            url: 'percepcionHistoricoClienteServiciosTotalAjax',
            data: {'clienteid':cliente, 'type':'sm'},
            async: false,
            success: function(data){
                if(data){
                    data = JSON.parse(data);
                    percepcionHistoricoClienteServiciosTotal(data);
                }
            },
        });
    }
    function percepcionHistoricoClienteServicios(Series){
    $('#Percepcion-Historico-Servicio-Cliente').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Percepcion Interna Historica de Servicios por Cliente'
        },
        subtitle: {
            text: ''
        },
        credits: {
	    	enabled: false
	    },
        xAxis: {
            categories: <?php echo json_encode($fechas);?>,
            labels: {
                step:1,
            }
        },
        yAxis: {
        	min: 0,
            max: 5,
            title: {
                text: 'Percepción Interna General'
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
    };
    function percepcionHistoricoClienteServiciosTotal(Series){
    $('#Percepcion-Historico-Servicio-Cliente-Total').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Satisfacción Interna Historica de Servicios por Cliente Total'
        },
        subtitle: {
            text: ''
        },
        credits: {
	    	enabled: false
	    },
        xAxis: {
            categories: <?php echo json_encode($fechas);?>,
            labels: {
                step:1,
            }
        },
        yAxis: {
        	min: 0,
            max: 100,
            title: {
                text: 'Satisfacción Interna General Total %'
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
    };

    function percepcionGeneralInternaHistorico(){
        $('#Percepcion-General-Interna-Historico').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Percepcion General Interna Histórica por Cliente'
            },
            subtitle: {
                text: ''
            },
            credits: {
		    	enabled: false
		    },
            xAxis: {
                categories: <?php echo json_encode($fechas);?>,
                labels: {
                    step:1,
                }
            },
            yAxis: {
            	min: 0,
	            max: 5,
                title: {
                    text: 'Percepción Interna General'
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
            series: <?php echo $persmgeneralhistorica;?>
        });
    }
    function percepcionHistoricoServicioTotal(){
        $('#Percepcion-Historico-Servicio-Total').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Satisfacción Histórica Interna por Línea de Servicio'
            },
            subtitle: {
                text: ''
            },
            credits: {
		    	enabled: false
		    },
            xAxis: {
                categories: <?php echo json_encode($fechas);?>,
                labels: {
                    step:1,
                }
            },
            yAxis: {
            	min: 0,
	            max: 100,
                title: {
                    text: 'Satisfacción'
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
            series: <?php echo $percepcionhistoricoserviciostotal;?>
        });
    }
    function percepcionGeneralInternaHistoricoUsuario(){
	    $('#Percepcion-General-Interna-Historico-Usuario').highcharts({
	        chart: {
	            type: 'line'
	        },
	        title: {
	            text: 'Satisfacción General Interna Histórica'
	        },
	        subtitle: {
	            text: ''
	        },
	        credits: {
		    	enabled: false
		    },
	        xAxis: {
	            categories: <?php echo json_encode($fechas);?>,
	            		 labels: {
	         	            step:1,
	         	        }
	        },
	        yAxis: {
	        	min: 0,
	            max: 100,
	            title: {
	                text: 'Satisfacción Externa General'
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

    function satisfaccionSm(){
    
	    $('#Satisfaccion-SM').highcharts({
	        chart: {
	            type: 'bar'
	        },
	        title: {
	            text: 'Percepcion General Interna por Cliente '
	        },
	        subtitle: {
	            text: 'fecha : <?php echo end($fechas);?> '
	        },
	        xAxis: {
	            categories: <?php echo json_encode(array_keys($satisfaccionsm));?>,
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
	                text: 'Percepción Interna',
	                align: 'high'
	            },
	            labels: {
	                overflow: 'justify'
	            }
	        },
	        tooltip: {
	            valueSuffix: ''
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
	            name: 'Percepción Interna: ',
	            data: <?php echo json_encode(array_values($satisfaccionsm));?>
	        }]
	    });
    }

    function percepcionServicio(){
    
	    $('#Percepcion-Servicio').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: 'Satisfacción Interna por líneas de Servicio'
	        },
	        subtitle: {
	        	text: 'fecha : <?php echo end($fechas);?> '
	        },
	        credits: {
		    	enabled: false
		    },
	        xAxis: {
	            categories: <?php echo json_encode(array_keys($percepcionsmservicio));?>,
	            		 labels: {
	         	            step:1,
	         	        }
	        },
	        yAxis: {
	        	allowDecimals: false,
	            title: {
	                text: 'Satisfacción Interna'
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
	            data: <?php echo json_encode(array_values($percepcionsmservicio));?>
	        }]
	    });
 }
</script>