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
            min: 0,
            title: {
                text: 'Percepción',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
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
            name: 'seguimiento: ',
            data: <?php echo json_encode(array_values($satisfaccionsm));?>
        }]
    });
    
});

</script>