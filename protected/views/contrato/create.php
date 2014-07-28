<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	"Contratos: $cliente->nombre "=>array('index', 'id'=>$cliente->id),
	'Crear',
);

$this->menu=array(
	array('label'=>"Contratos: $cliente->nombre", 'url'=>array('index','id'=>$cliente->id)),
);
?>

<h2>Crear Contrato</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'cliente'=>$cliente)); ?>