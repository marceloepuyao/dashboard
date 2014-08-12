<?php
/* @var $this SeguimientoController */

$this->breadcrumbs=array(
	'Seguimiento'=>array('seguimiento/index', 'id'=>$cliente->id),
	'Actualizar Seguimiento Semanal: '.$fecha,
);
?>
<h2>Seguimiento Semanal #<?php echo $fecha . ' Cliente: ' . $cliente->nombre; ?></h2>


<?php $this->renderPartial('_formsemanal', array(
		'fecha'=>$fecha, 
		'cliente'=>$cliente, 
		'lineaservicios'=> $lineaservicios,
		'percepcionGeneral' => $percepcionGeneral,
)); ?>

