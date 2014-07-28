<?php
/* @var $this ClienteController */
/* @var $model Cliente */

$this->breadcrumbs=array(
	'Administrar Clientes'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Clientes', 'url'=>array('index')),
);
?>

<h2>Crear Cliente</h2>

<?php $this->renderPartial('_form', array('model'=>$model, 'usuarios'=>$usuarios)); ?>