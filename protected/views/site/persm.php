<?php
$this->breadcrumbs=array(
		'Percepcion Externa',
);
?>

<?php //echo CHtml::dropDownList("fechas", "", $fechas);?>

<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts-more.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/modules/solid-gauge.src.js"></script>


<div id="Satisfaccion-SM" style="width: 700px; height: 500px; margin:0 auto 0 auto;"></div>
<div id="Percepcion-General-Interna-Historico" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Percepcion-Servicio" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">
$(function () {
    $('#Percepcion-General-Interna-Historico').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Percepcion General Interna Histórica'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: <?php echo json_encode($fechas);?>
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
        series: <?php echo $persmgeneralhistorica;?>
    });
    
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

    
    $('#Percepcion-Servicio').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Percepción Interna por líneas de Servicio'
        },
        subtitle: {
        	text: 'fecha : <?php echo end($fechas);?> '
        },
        xAxis: {
            categories: <?php echo json_encode(array_keys($percepcionsmservicio));?>,
        },
        yAxis: {
        	allowDecimals: false,
            min: 0,
            max: 5,
            title: {
                text: 'Percepción Interna'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{point.key}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
    
});

</script>