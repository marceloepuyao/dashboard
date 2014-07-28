<?php
/* @var $this SeguimientoItilController */
/* @var $model SeguimientoItil */

$this->breadcrumbs=array(
	'Seguimiento Itils'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SeguimientoItil', 'url'=>array('index')),
	array('label'=>'Manage SeguimientoItil', 'url'=>array('admin')),
);
?>

<h1>Create SeguimientoItil</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>