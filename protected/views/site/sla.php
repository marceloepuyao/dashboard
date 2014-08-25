<?php
$this->breadcrumbs=array(
		'SLA',
);
?>

<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts-more.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/modules/solid-gauge.src.js"></script>

<div id="Cumplimiento-SLA-Cliente" style="width: 700px; height: 500px; margin:0 auto 0 auto;"></div>
<div id="Cumplimiento-SLA-Historico" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="Cumplimiento-SLA-Historico-Simple" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<?php echo CHtml::label("Selecciona Cliente", "clientes");?>
<?php echo CHtml::dropDownList("clientes", "", $clientes);?>
<div id="Cumplimiento-SLA-Historico-Servicios" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">

$(function () {
    $('#Cumplimiento-SLA-Historico').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Cumplimiento Histórico SLA Por Cliente'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: <?php echo json_encode($fechas);?>
        },
        yAxis: {
            title: {
                text: 'Cumplimiento SLA (%)',
            },
            min: 0,
            max: 100
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: <?php echo $cumplimientoSlaHistoricoPorCliente;?> 
    });
    
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
        xAxis: {
            categories: <?php echo json_encode($fechas);?>
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
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: <?php echo $cumplimientoSlaHistorico;?> 
    });


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
            categories: <?php echo json_encode(array_keys($cumplimientoSlaPorCliente));?>,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cumplimiento SLA (%)',
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
            data: <?php echo json_encode(array_values($cumplimientoSlaPorCliente));?>
        }]
    });

    
});


</script>

<?php  /*
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load('visualization', '1.0', {'packages':['corechart']});
google.load('visualization', '1', {packages:['gauge']});

google.setOnLoadCallback(start);

$("#fechas").on("change",function(){
	var fecha = $("#fechas option:selected").text();	
	getData(fecha);
  getDataClientes(fecha);
	
});
function start(){
	var fecha = $("#fechas option:selected").text();
	getData(fecha);
  getDataClientes(fecha);
}

function getDataClientes(fecha){
  $.ajax({
        url: 'CumplimientoSlaPorClienteAjax',
    data: {'fecha':fecha},
      async: false,
      success: function (data){
          if (data){
            data = JSON.parse(data);
            drawChartCumplimientoSLACliente(data);
          }
      },
    });
}

function getData(fecha){
	$.ajax({
        url: 'cumplimientoSlaAjax',
		data: {'fecha':fecha},
        async: false,
        success: function(data){
            if(data){
				data = data;
				drawChartCumplimientoSLA(data);
            }
        },
    });
	

  }

  function drawChartCumplimientoSLA(tasa){
	
  var data2 = google.visualization.arrayToDataTable([
	                                                    ['Label', 'Value'],
	                                                    ['Tasa de SLA cumplido', parseFloat(tasa)]]);
  
  	var options2 = {
  		'title': 'Tasa de SLA cumplidos',
  		'width': 200,
  		'height': 200,
  	};

  	var chart2 = new google.visualization.Gauge(document.getElementById('Cumplimiento-SLA'));
  	chart2.draw(data2, options2);
  }  

  function drawChartCumplimientoSLACliente(clientes){
    var data = google.visualization.arrayToDataTable(clientes, true);
    var options = {
          title: 'Tasa de SLA Cumplidos por Cliente',
          vAxis: {title: 'Clientes',  titleTextStyle: {color: 'black'}},
          width: 900,
          height: 500,
          min: 0,
          max: 100,
    };

    var chart = new google.visualization.BarChart(document.getElementById('Cumplimiento-SLA-Cliente'));
    chart.draw(data, options);
  }
  </script>
  */?>