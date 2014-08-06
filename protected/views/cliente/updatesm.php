<?php
/* @var $this ClienteController */
/* @var $model Cliente */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Actualizar: '.$model->nombre,
);

$this->menu=array(
	array('label'=>'Mis Clientes', 'url'=>array('cliente/misclientes')),
);
?>

<h2>Ficha de cliente: <?php echo $model->nombre; ?></h2>

<?php $this->renderPartial('_form', array(
		'model'=>$model, 
		'usuarios'=>false,
		'competidores'=>$competidores,
		'selected_keys'=>$selected_keys
)); ?>