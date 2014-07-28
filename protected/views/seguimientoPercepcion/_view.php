<?php
/* @var $this SeguimientoPercepcionController */
/* @var $data SeguimientoPercepcion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('linea_servicio_contrato_id')); ?>:</b>
	<?php echo CHtml::encode($data->linea_servicio_contrato_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('per_cliente')); ?>:</b>
	<?php echo CHtml::encode($data->per_cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('per_sm')); ?>:</b>
	<?php echo CHtml::encode($data->per_sm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_seguimiento')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_seguimiento); ?>
	<br />


</div>