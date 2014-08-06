<?php
/* @var $this SlaController */
/* @var $model Sla */

$this->breadcrumbs=array(
		'Mis Clientes'=> array('cliente/misclientes'),
		'Contratos: '.$cliente->nombre=>array('contrato/index', 'id'=>$cliente->id),
		$contrato->titulo => array('contrato/view', 'id'=>$model->contrato_id),
		'Crear Sla'
);

$this->menu=array(
		array('label'=>'Contratos: '.$cliente->nombre, 'url'=>array('index', 'id'=>$cliente->id)),
		array('label'=>$contrato->titulo, 'url'=>array('contrato/view', 'id'=>$model->contrato_id)),
);

?>

<h1>Crear Sla</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'contrato'=>$contrato)); ?>