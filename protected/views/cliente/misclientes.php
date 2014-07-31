<?php
/* @var $this ClienteController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mis Clientes',
);

?>

<h2>Mis Clientes</h2>


<table cellpadding='2' ><tr><td></td><td></td><td></td><td></td><td></td></tr>

<?php foreach ($clientes as $cliente){?>
	<tr><td><?php echo $cliente->nombre;?></td><td>
	
	<?php echo CHtml::link('Ficha',array('update', 'id'=>$cliente->id )); ?>
	<?php echo CHtml::link('Contratos',array('contrato/index', 'id'=>$cliente->id )); ?>
	<?php echo CHtml::link('Issues',array('issue/index', 'id'=>$cliente->id )); ?>
	<?php echo CHtml::link('Seguimiento',array('seguimiento/index', 'id'=>$cliente->id )); ?>

	<?php }?>
	
	</table>

	
