<?php
/* @var $this LineaServicioController */
/* @var $model LineaServicio */

$this->breadcrumbs=array(
	'Líneas de Servicios'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administar Líneas de Servicio', 'url'=>array('index')),

);
?>

<h1>Create LineaServicio</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>