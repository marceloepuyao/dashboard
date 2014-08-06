<?php
/* @var $this SeguimientoController */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Seguimiento: '.$cliente->nombre=>array('seguimiento/index', 'id'=>$cliente->id),
	'Nuevo seguimiento',
);
?>
<h2>Seguimiento Semanal #<?php echo $fecha . ' Cliente: ' . $cliente->nombre; ?></h2>


<?php $this->renderPartial('_form', array('fecha'=>$fecha, 'cliente'=>$cliente, 'lineaservicios'=> $lineaservicios, 'seguimientoItil'=>$seguimientoItil,'sla'=>$sla,)); ?>

