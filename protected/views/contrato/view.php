<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Contratos: '.$cliente->nombre=>array('index', 'id'=>$cliente->id),
	$model->id,
);

$this->menu=array(
	array('label'=>'Contratos: '.$cliente->nombre, 'url'=>array('index', array('id'=>$model->cliente_id))),
	array('label'=>'Crear Contrato', 'url'=>array('create', array('id'=>$model->cliente_id))),
	array('label'=>'Actualizar Contrato', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Contrato', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h2>Contrato: <?php echo $model->titulo; ?></h2>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'cliente_id',
			'value'=> $cliente->nombre,
		),
		'facturacion',
		'inicio',
		'fin',
		'codigo_moebius',
		'titulo',
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('contrato/index', 'id'=>$cliente->id),
    'label'=>'Volver',
    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>
