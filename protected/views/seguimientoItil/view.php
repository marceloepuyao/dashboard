<?php
/* @var $this SeguimientoItilController */
/* @var $model SeguimientoItil */

$this->breadcrumbs=array(
	'Seguimiento Itils'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SeguimientoItil', 'url'=>array('index')),
	array('label'=>'Create SeguimientoItil', 'url'=>array('create')),
	array('label'=>'Update SeguimientoItil', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SeguimientoItil', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SeguimientoItil', 'url'=>array('admin')),
);
?>

<h1>View SeguimientoItil #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cliente_id',
		'felicitaciones',
		'reclamos',
		'problemas',
		'cambios',
		'estado_cmdb',
		'incidentes',
		'requerimientos',
		'backlog',
		'indisponibilidad',
		'sip',
		'reuniones',
		'minutas',
		'reunion_servicio',
		'informe',
		'facturado',
		'facturacion_extra',
		'multas',
		'fecha',
		'comentario',
		'tipo_seguimiento',
		'per_client',
		'per_sm',
	),
)); ?>
