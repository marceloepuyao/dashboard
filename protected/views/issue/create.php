<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Issues: '.$cliente->nombre=>array('index', 'id'=>$cliente->id),
	'Crear Issue',
);

$this->menu=array(
	array('label'=>'Administrar Issues', 'url'=>array('index', 'id'=>$cliente->id)),
);
?>

<h2>Crear Issue</h2>

<?php $this->renderPartial('_form', array('model'=>$model, 'cliente'=>$cliente,'lineaservicios'=>$lineaservicios)); ?>