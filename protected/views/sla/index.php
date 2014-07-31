<?php
/* @var $this SlaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Slas',
);

$this->menu=array(
	array('label'=>'Create Sla', 'url'=>array('create')),
	array('label'=>'Manage Sla', 'url'=>array('admin')),
);
?>

<h1>Slas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
