<?php
/* @var $this ClienteController */
/* @var $model Cliente */

$this->breadcrumbs=array(
	'Administrar Clientes'=>array('index'),
	$model->nombre=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Administrar Clientes', 'url'=>array('index')),
	array('label'=>'Nuevo Cliente', 'url'=>array('create')),
	array('label'=>'Ver Cliente', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Cliente', 'url'=>array('admin')),
);
?>

<h2>Ficha de cliente: <?php echo $model->nombre; ?></h2>

<?php $this->renderPartial('_form', array('model'=>$model, 'usuarios'=>$usuarios,)); ?>