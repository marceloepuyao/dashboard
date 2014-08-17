<?php


$this->breadcrumbs=array(
	'Estado Cliente',
);
?>
Cliente: 
<select id="clients" onchange="changeClient()">
	<?php foreach ($clientes as $cl){?>
  <option value="<?php echo $cl['id'];?>" <?php echo $cl['id']==$cliente->id?"selected":"";?> ><?php echo $cl['nombre'];?></option>
  <?php }?>
</select>


<h2>Último Estado Cliente: <?php echo $cliente->nombre?> </h2>

<h5> Último seguimiento semanal: <?php echo $fechapercepcion;?> </h5>
<h5> Último seguimiento Mensual: <?php echo $fechaitil;?></h5>

<h4> Resumen: </h4>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'resumen-grid',
	 'summaryText' => '',
    'dataProvider'=>$resumen,
    'columns'=>array(
		array(
			'header'=>'',
			'value'=>'$data["nombre"]',
		),
		array(
			'header'=>'',
			'value'=>'$data["valor"]',
		),
	),
));?>



<h4> Percepción: </h4>
 
 <?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'servicio-grid',
	 'summaryText' => '',
    'dataProvider'=>$seguimientopercepcion,
    'columns'=>array(
		array(
			'name'=>'Líneas de Servicio',
			'value'=> '$data["nombre"]',
		),
		array(
			'name'=>'Percepción Cliente',
			'value'=>'isset($data["per_cliente"])?$data["per_cliente"]:0',
		),
		array(
		'name'=>'Percepción SM',
		'value'=>'isset($data["per_sm"])?$data["per_sm"]:0',
		),

	)
));?>

<h4>ITIL</h4>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'servicio-grid',
	'summaryText' => '',	
    'dataProvider'=>$seguimientoitil,
    'columns'=>array(
		array(
			'name'=>'KPI',
			'value'=> '$data["nombre"]',
		),
		array(
			'name'=>'Valor',
			'value'=>'isset($data["valor"])?$data["valor"]:0',
		),

	)
)); ?>


<h4>SLA</h4>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'servicio-grid',
	'summaryText' => '',
    'dataProvider'=>$seguimientosla,
    'columns'=>array(
		array(
			'name'=>'Contrato',
			'value'=> 'Contrato::model()->findByPk($data["contrato_id"])->titulo',
		),
		array(
			'name'=>'SLA',
			'value'=> '$data["nombre"]',
		),
		array(
			'name'=>'Objetivo(%)',
			'value'=> '$data["objetivo"]',
		),
		array(
			'name'=>'Valor',
			'value'=>'isset($data["valor"])?$data["valor"]:0',
		),
	)
));?>

<h4>Issues</h4>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'issue-grid',
	'dataProvider'=>$issues,
	'columns'=>array(
		'descripcion',
		'fecha',
		array(
			'name'=> 'lineaservicios',
			'value'=> 'implode(", ", array_keys(CHtml::listData($data->lineaServicios, "nombre" , "id")));'
		),
		array(
			'name'=>'criticidad',
			'filter'=>array('1'=>"Baja",'2'=>'Media','3'=>'Alta'),
			'value'=>'$data->criticidad==1?"Baja":($data->criticidad==2?"Media":"Alta") ',
		),
		array(
			'name'=>'solucionado',
			'filter'=>array('1'=>"Pendiente",'2'=>'Terminado'),
			'value'=>'$data->solucionado==1?"Pendiente":"Terminado" ',
		),
	),
)); ?>

 
<script type="text/javascript">
function changeClient(){
	var client = $('#clients').val();
	window.location.replace('estado?id='+ client);
}

</script>
 
 
 