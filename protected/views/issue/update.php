<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Issues  : '.$cliente->nombre=>array('index'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Issues : '.$cliente->nombre, 'url'=>array('index')),
	array('label'=>'Crear Issue', 'url'=>array('create')),
	array('label'=>'Ver Issue', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h2>Actualizar Issue</h2>

<?php $this->renderPartial('_form', array('model'=>$model, 'cliente'=>$cliente, 'lineaservicios'=>$lineaservicios)); ?>