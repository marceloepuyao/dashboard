<?php
/* @var $this SeguimientoItilController */
/* @var $model SeguimientoItil */

$this->breadcrumbs=array(
	'Seguimiento Itils'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SeguimientoItil', 'url'=>array('index')),
	array('label'=>'Create SeguimientoItil', 'url'=>array('create')),
	array('label'=>'View SeguimientoItil', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SeguimientoItil', 'url'=>array('admin')),
);
?>

<h1>Update SeguimientoItil <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>