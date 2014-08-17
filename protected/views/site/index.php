<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h2>Dashboard Cliente</h2>


<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/highcharts-more.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/js/highcharts/modules/solid-gauge.src.js"></script>


<div style="width: 600px; height: 215px; margin: 0 auto">
	<a href="<?php echo Yii::app()->baseUrl."/site/sla";?>"><div id="Cumplimiento-SLA" style="width: 300px; height: 200px; float: left"></div></a>
	<a href="<?php echo Yii::app()->baseUrl."/site/issuescliente";?>"><div id="Issues-Cliente" style="width: 300px; height: 200px; float: left"></div></a>
</div>
<div style="width: 600px; height: 200px; margin: 0 auto">
	<a href="<?php echo Yii::app()->baseUrl."/site/percl";?>"><div id="Percepcion-Externa" style="width: 300px; height: 200px; float: left"></div></a>
	<a href="<?php echo Yii::app()->baseUrl."/site/persm";?>"><div id="Percepcion-Interna" style="width: 300px; height: 200px; float: left"></div></a>
</div>

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
            enabled: false
        },

        // the value axis
        yAxis: {
            stops: [
                [0.6, '#DF5353'], // red
	        	[0.7, '#DDDF0D'], // yellow
	        	[0.8, '#55BF3B'] // Green
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
                    y: 5,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        }
    };

    // The speed gauge
    $('#Cumplimiento-SLA').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Cumpliento SLA'
            }
        },

        credits: {
	    	enabled: false
	    },
		exporting: {
            enabled: false
        },

        series: [{
            name: 'SLA',
            data: [<?php echo (int)$cumplimiento_sla;?>],
            dataLabels: {
            	format: '<div style="text-align:center"><span style="font-size:25px;color:' + 
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>' + 
               	'<span style="font-size:12px;color:silver"></span></div>'
            },
            tooltip: {
            	valueSuffix: ' %',
				pointFormat: '% de Clientes que tienen al menos el 75% <br> de sus SLAs cumplidos: <strong>{point.y}</strong>'
            }
        }]

    }));

    // The RPM gauge
    $('#Issues-Cliente').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Clientes sin Issues'
            }
        },
        credits: {
	    	enabled: false
	    },
		exporting: {
            enabled: false
        },

        series: [{
            name: 'Issues',
            data: [<?php echo $porcentajeClientesSinIssues;?>],
            dataLabels: {
            	format: '<div style="text-align:center"><span style="font-size:25px;color:' + 
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>' + 
               	'<span style="font-size:12px;color:silver"></span></div>'
            },
            tooltip: {
            	valueSuffix: ' %',
				pointFormat: '% de Clientes que tienen al menos el 75% <br> de sus SLAs cumplidos: <strong>{point.y}</strong>'
            }
        }]

    }));


 // The speed gauge
    $('#Percepcion-Externa').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Satisfacción General Externa'
            }
        },

        credits: {
	    	enabled: false
	    },
		exporting: {
            enabled: false
        },

        series: [{
            name: 'Cliente',
            data: [<?php echo $percepcionCliente;?>],
            dataLabels: {
            	format: '<div style="text-align:center"><span style="font-size:25px;color:' + 
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>' + 
               	'<span style="font-size:12px;color:silver"></span></div>'
            },
            tooltip: {
            	valueSuffix: ' %',
				pointFormat: '% de Clientes que tienen al menos el 75% <br> de sus SLAs cumplidos: <strong>{point.y}</strong>'
            }
        }]

    }));

    // The RPM gauge
    $('#Percepcion-Interna').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Satisfacción General Interna'
            }
        },

        credits: {
	    	enabled: false
	    },
		exporting: {
            enabled: false
        },

        series: [{
            name: 'SM',
            data: [<?php echo $percepcionSM;?>],
            dataLabels: {
            	format: '<div style="text-align:center"><span style="font-size:25px;color:' + 
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>' + 
               	'<span style="font-size:12px;color:silver"></span></div>'
            },
            tooltip: {
            	valueSuffix: ' %',
				pointFormat: '% de Clientes que tienen al menos el 75% <br> de sus SLAs cumplidos: <strong>{point.y}</strong>'
            }
        }]

    }));

});

</script>




<?php /*


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
	                                                    ['Clientes Sin Issues', parseFloat(<?php echo $porcentajeClientesSinIssues;
	                                                    	?>)] ]);
  var formatter = new google.visualization.NumberFormat(
          {suffix: '%'});
      formatter.format(data1, 1);
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
	                                                    ['Cumplimiento SLA', parseFloat(<?php echo $cumplimiento_sla; ?>)] ]);

  var formatter = new google.visualization.NumberFormat(
          {suffix: '%'});
      formatter.format(data2, 1); 
      
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
	                                                    ['Satisfacción Clientes', parseFloat(<?php echo $percepcionCliente; ?>)] ]);

  	var formatter = new google.visualization.NumberFormat(
            {suffix: '%'});
    formatter.format(data3, 1);
        
  	var options3 = {
  		'title': 'Percepcion del SM',
  		'width': 200,
  		'height': 200
  	};

  	var chart3 = new google.visualization.Gauge(document.getElementById('Percepcion-Externa'));
  	chart3.draw(data3, options3);


  }

  function drawChartPercepcionManager(){
  	var data4 = new google.visualization.arrayToDataTable([
	                                                    ['Label', 'Value'],
	                                                    ['Satisfacción SM', parseFloat(<?php echo $percepcionSM; ?>)] ]);
  	var formatter = new google.visualization.NumberFormat(
            {suffix: '%'});
    formatter.format(data4, 1);
  	var options4 = {
  		'title': 'Percepcion del SM',
  		'width': 200,
  		'height': 200
  	};

  	var chart4 = new google.visualization.Gauge(document.getElementById('Percepcion-Interna'));
  	chart4.draw(data4, options4);


  }
</script>
*/
?>
