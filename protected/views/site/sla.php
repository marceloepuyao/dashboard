<?php
$this->breadcrumbs=array(
		'SLA',
);
?>
<h2>Vista General</h2>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts-more.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/modules/solid-gauge.src.js"></script>

<div id="Cumplimiento-SLA-Cliente" style="width: 700px; height: 500px; margin:0 auto 0 auto;"></div>
<div id="Cumplimiento-SLA-Historico" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<h2>Vista por Cliente</h2>
<?php echo CHtml::label("Selecciona Cliente", "clientes");?>
<?php echo CHtml::dropDownList("clientes", "", $clientes);?>

<div id="Cumplimiento-SLA-Contrato" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">

$(function () { 
	cumplimientoSlaHistorico(<?php echo json_encode($fechas);?> , <?php echo $cumplimientoSlaHistoricoPorCliente;?> );
    cumplimientoSlaCliente(<?php echo json_encode(array_keys($cumplimientoSlaPorCliente));?> ,  <?php echo json_encode(array_values($cumplimientoSlaPorCliente));?>);
    cumplimientoSlaContrato(<?php echo json_encode(array_keys($cumplimientoSlaPorContrato));?> ,  <?php echo json_encode(array_values($cumplimientoSlaPorContrato));?>);
});

$("#clientes").on("change",function(){
	var cliente = $("#clientes option:selected").val();	
	getData(cliente);
});

function getData(cliente){
	$.ajax({
        url: 'cumplimientoSlaContratoAjax',
		data: {'fecha':<?php echo end($fechas);?>, 'clienteid':cliente},
        async: false,
        success: function(data){
            if(data){
                data = JSON.parse(data);
				cumplimientoSlaContrato(data.categories, data.data);
            }
        },
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
	        xAxis: {
	            categories: categories
	        },
	        yAxis: {
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
            name: '% SLA cumplidos: ',
            data: data 
        }]
    });	
}

function cumplimientoSlaContrato(categories, data){
	 $('#Cumplimiento-SLA-Contrato').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: '% SLA cumplidos por Contrato'
	        },
	        subtitle: {
	        	text: 'fecha : <?php echo end($fechas);?> '
	        },
	        xAxis: {
	            categories: categories
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
	                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
	            name: '% SLA cumplidos: ',
	            data: data 
	        }]
	    });

	
}


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