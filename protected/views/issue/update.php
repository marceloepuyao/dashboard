<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Issues  : '.$cliente->nombre=>array('index', 'id'=>$model->cliente_id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Issues : '.$cliente->nombre, 'url'=>array('index')),
	array('label'=>'Crear Issue', 'url'=>array('create', 'id'=>$model->cliente_id)),
	array('label'=>'Ver Issue', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h2>Actualizar Issue</h2>

<?php $this->renderPartial('_form', array('model'=>$model, 'cliente'=>$cliente, 'lineaservicios'=>$lineaservicios,'selected_keys' => $selected_keys)); ?>