<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Seguimiento: '.$cliente->nombre,
);

?>

<h2>Seguimiento <?php echo $cliente->nombre;?></h2>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        	'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
	),
    )); ?>
    
    
</br>
<p>Fecha Actual: <?php echo date('YW');?></p>
<?php 
if($seguimientoSemanal){
	$this->widget('bootstrap.widgets.TbButton', array(
		'url'=>array('seguimiento/updatesemanal', 'id'=>$cliente->id),
		'label'=>'Editar Seguimiento Semanal: '.$seguimientoSemanal['fecha'],
		'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		'size'=>'small', // null, 'large', 'small' or 'mini'
	));
}
?>
</br>
<?php 
if($seguimientoMensual){
	$this->widget('bootstrap.widgets.TbButton', array(
			'url'=>array('seguimiento/updatemensual', 'id'=>$cliente->id),
			'label'=>'Editar Seguimiento Mensual: '.$seguimientoMensual['fecha'].' - '.($seguimientoMensual['fecha'] + 4),
			'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
	));
}
?>
</br>
</br>
</br>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('cliente/misclientes'),
    'label'=>'Volver',
    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>
