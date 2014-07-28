<?php
/* @var $this LineaServicioController */
/* @var $model LineaServicio */

$this->breadcrumbs=array(
	'Administrar Líneas de Servicios',
);

$this->menu=array(
	array('label'=>'Crear Línea de Servicio', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#linea-servicio-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Administar Líneas de Servicios</h2>



<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'linea-servicio-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}{update}',
		),
	),
)); ?>
