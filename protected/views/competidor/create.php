<?php
/* @var $this CompetidorController */
/* @var $model Competidor */

$this->breadcrumbs=array(
	'Administrar Competidores'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Competidores', 'url'=>array('index')),
);
?>

<h2>Crear Competidor</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>