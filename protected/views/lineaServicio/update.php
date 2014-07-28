<?php
/* @var $this LineaServicioController */
/* @var $model LineaServicio */

$this->breadcrumbs=array(
	'Linea Servicios'=>array('index'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Líneas de Servicio', 'url'=>array('index')),
	array('label'=>'Crear Línea de Servicio', 'url'=>array('create')),
);
?>

<h1>Actualizar: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>