<?php
/* @var $this SeguimientoController */

$this->breadcrumbs=array(
	'Mis Clientes' =>array('cliente/misclientes'),
	'Seguimiento: '.$cliente->nombre=>array('seguimiento/index', 'id'=>$cliente->id),
	'Actualizar Seguimiento Mensual: ' . $fecha
);

?>
<h2>Seguimiento Mensual #<?php echo $fecha.' - #'.($fecha+3) . ' Cliente: ' . $cliente->nombre; ?></h2>


<?php $this->renderPartial('_formmensual', array('fecha'=>$fecha, 
						'cliente'=>$cliente, 
						'itil'=> $itil,
						'sla'=>$sla,)); ?>

