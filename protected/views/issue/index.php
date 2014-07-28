<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Issues: '.$cliente->nombre,
);

$this->menu=array(
	array('label'=>'Crear Issue', 'url'=>array('create', 'id'=>$cliente->id)),
);
?>

<h2>Issues: <?php echo $cliente->nombre;?></h2>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'issue-grid',
	'dataProvider'=>$model,
	'columns'=>array(
		array(
			'name'=>'linea_servicio_id',
			'value'=> 'LineaServicio::model()->findByPk($data->linea_servicio_id)["nombre"]',
		),
		'descripcion',
		'fecha',
		array(
			'name'=>'criticidad',
			'value'=>'$data->criticidad==1?"Baja":($data->criticidad==2?"Media":3) ',
		),
		array(
			'name'=>'solucionado',
			'value'=>'$data->solucionado==1?"Pendiente":"Terminado" ',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
