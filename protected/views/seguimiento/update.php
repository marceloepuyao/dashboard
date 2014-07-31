<?php
/* @var $this SeguimientoController */

$this->breadcrumbs=array(
	'Seguimiento'=>array('seguimiento/index', 'id'=>$cliente->id),
	'Actualizar Seguimiento',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>



<?php echo  CHtml::image(Yii::app()->request->baseUrl.'/images/under_construction.jpg'); ?>