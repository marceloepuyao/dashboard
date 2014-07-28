<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Contratos: '.$cliente->nombre=>array('index', 'id'=>$cliente->id),
	"Actualizar: ".$model->titulo,

);

$this->menu=array(
	array('label'=>'Contratos: '.$cliente->nombre, 'url'=>array('index', 'id'=>$cliente->id)),
	array('label'=>'Crear Contrato', 'url'=>array('create','id'=>$cliente->id)),
	array('label'=>'Ver Contrato', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h2>Actualizar: <?php echo $model->titulo; ?></h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>