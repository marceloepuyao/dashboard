<?php
/* @var $this SeguimientoPercepcionController */
/* @var $model SeguimientoPercepcion */

$this->breadcrumbs=array(
	'Seguimiento Percepcions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SeguimientoPercepcion', 'url'=>array('index')),
	array('label'=>'Manage SeguimientoPercepcion', 'url'=>array('admin')),
);
?>

<h1>Create SeguimientoPercepcion</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>