<?php
/* @var $this SeguimientoPercepcionController */
/* @var $model SeguimientoPercepcion */

$this->breadcrumbs=array(
	'Seguimiento Percepcions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SeguimientoPercepcion', 'url'=>array('index')),
	array('label'=>'Create SeguimientoPercepcion', 'url'=>array('create')),
	array('label'=>'View SeguimientoPercepcion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SeguimientoPercepcion', 'url'=>array('admin')),
);
?>

<h1>Update SeguimientoPercepcion <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>