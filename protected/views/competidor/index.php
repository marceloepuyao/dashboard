<?php
/* @var $this CompetidorController */
/* @var $model Competidor */

$this->breadcrumbs=array(
	'Administrar Competidores',
);

$this->menu=array(
	array('label'=>'Crear Competidor', 'url'=>array('create')),
);

?>

<h2>Administrar Competidores</h2>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'competidor-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
)); ?>
