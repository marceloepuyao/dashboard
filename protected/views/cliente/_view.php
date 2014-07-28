<?php
/* @var $this ClienteController */
/* @var $data Cliente */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('industria')); ?>:</b>
	<?php echo CHtml::encode($data->industria); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empleados')); ?>:</b>
	<?php echo CHtml::encode($data->empleados); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facturacion')); ?>:</b>
	<?php echo CHtml::encode($data->facturacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('categoria')); ?>:</b>
	<?php echo CHtml::encode($data->categoria); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('rut')); ?>:</b>
	<?php echo CHtml::encode($data->rut); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hq')); ?>:</b>
	<?php echo CHtml::encode($data->hq); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jp')); ?>:</b>
	<?php echo CHtml::encode($data->jp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kam')); ?>:</b>
	<?php echo CHtml::encode($data->kam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arquitecto')); ?>:</b>
	<?php echo CHtml::encode($data->arquitecto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('competidor')); ?>:</b>
	<?php echo CHtml::encode($data->competidor); ?>
	<br />

	*/ ?>

</div>