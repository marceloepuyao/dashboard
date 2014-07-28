<?php
/* @var $this SeguimientoPercepcionController */
/* @var $model SeguimientoPercepcion */

$this->breadcrumbs=array(
	'Seguimiento Percepcions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SeguimientoPercepcion', 'url'=>array('index')),
	array('label'=>'Create SeguimientoPercepcion', 'url'=>array('create')),
	array('label'=>'Update SeguimientoPercepcion', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SeguimientoPercepcion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SeguimientoPercepcion', 'url'=>array('admin')),
);
?>

<h1>View SeguimientoPercepcion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'linea_servicio_contrato_id',
		'per_cliente',
		'per_sm',
		'fecha',
		'tipo_seguimiento',
	),
)); ?>
