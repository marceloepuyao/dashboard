<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Issues: '.$cliente->nombre=>array('index', 'id'=>$model->cliente_id),
	$model->id,
);

$this->menu=array(
	array('label'=>'Administrar Issues', 'url'=>array('index')),
	array('label'=>'Crear Issue', 'url'=>array('create')),
	array('label'=>'Actualizar Issue', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Issue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h2>Ver Issue</h2>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'lineaservicios',
			'value'=> implode(", ", array_keys(CHtml::listData($model->lineaServicios, "nombre" , "id"))),
		),
		array(
			'name'=>'cliente_id',
			'value'=> $cliente->nombre,
		),
		'descripcion',
		'fecha',
		'solucionado',
		'criticidad',
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('issue/index', 'id'=>$cliente->id),
    'label'=>'Volver',
    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>
