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
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('cliente/misclientes'),
    'label'=>'Volver',
    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>
