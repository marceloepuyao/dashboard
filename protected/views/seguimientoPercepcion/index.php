<?php
/* @var $this SeguimientoPercepcionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Seguimiento Percepcions',
);

$this->menu=array(
	array('label'=>'Create SeguimientoPercepcion', 'url'=>array('create')),
	array('label'=>'Manage SeguimientoPercepcion', 'url'=>array('admin')),
);
?>

<h1>Seguimiento Percepcions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
