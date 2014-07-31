<?php
/* @var $this CompetidorController */
/* @var $model Competidor */

$this->breadcrumbs=array(
	'Administrar Competidores'=>array('index'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Administrar Competidores', 'url'=>array('index')),
	array('label'=>'Crear Competidor', 'url'=>array('create')),
);
?>

<h2>Actualizar: <?php echo $model->nombre; ?></h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>