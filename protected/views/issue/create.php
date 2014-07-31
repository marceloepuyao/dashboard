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
$selected_keys = array();
?>

<h2>Crear Issue</h2>

<?php $this->renderPartial('_form', array('model'=>$model, 'cliente'=>$cliente, 'lineaservicios'=>$lineaservicios,'selected_keys'=>$selected_keys)); ?>