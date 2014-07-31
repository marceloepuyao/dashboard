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
    
    
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url'=>array('seguimiento/historico', 'id'=>$cliente->id),
    'label'=>'Seguimiento Histórico',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>
</br>
</br>
<?php 
if(!$seguimiento){
	$this->widget('bootstrap.widgets.TbButton', array(
		'url'=>array('seguimiento/create', 'id'=>$cliente->id),
		'label'=>'Generar Seguimiento',
		'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		'size'=>'small', // null, 'large', 'small' or 'mini'
	)); 
	
}else{
	$this->widget('bootstrap.widgets.TbButton', array(
		'url'=>array('seguimiento/update', 'id'=>$cliente->id),
		'label'=>'Editar Último Seguimiento',
		'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		'size'=>'small', // null, 'large', 'small' or 'mini'
	));
}
?>

</br>
</br>
</br>
</br>
