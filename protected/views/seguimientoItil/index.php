<?php
/* @var $this SeguimientoItilController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Seguimiento Itils',
);

$this->menu=array(
	array('label'=>'Create SeguimientoItil', 'url'=>array('create')),
	array('label'=>'Manage SeguimientoItil', 'url'=>array('admin')),
);
?>

<h1>Seguimiento Itils</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
