<?php
/* @var $this SeguimientoItilController */
/* @var $data SeguimientoItil */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente_id')); ?>:</b>
	<?php echo CHtml::encode($data->cliente_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('felicitaciones')); ?>:</b>
	<?php echo CHtml::encode($data->felicitaciones); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reclamos')); ?>:</b>
	<?php echo CHtml::encode($data->reclamos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('problemas')); ?>:</b>
	<?php echo CHtml::encode($data->problemas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cambios')); ?>:</b>
	<?php echo CHtml::encode($data->cambios); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado_cmdb')); ?>:</b>
	<?php echo CHtml::encode($data->estado_cmdb); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('incidentes')); ?>:</b>
	<?php echo CHtml::encode($data->incidentes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requerimientos')); ?>:</b>
	<?php echo CHtml::encode($data->requerimientos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog')); ?>:</b>
	<?php echo CHtml::encode($data->backlog); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('indisponibilidad')); ?>:</b>
	<?php echo CHtml::encode($data->indisponibilidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sip')); ?>:</b>
	<?php echo CHtml::encode($data->sip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reuniones')); ?>:</b>
	<?php echo CHtml::encode($data->reuniones); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('minutas')); ?>:</b>
	<?php echo CHtml::encode($data->minutas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reunion_servicio')); ?>:</b>
	<?php echo CHtml::encode($data->reunion_servicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('informe')); ?>:</b>
	<?php echo CHtml::encode($data->informe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facturado')); ?>:</b>
	<?php echo CHtml::encode($data->facturado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facturacion_extra')); ?>:</b>
	<?php echo CHtml::encode($data->facturacion_extra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('multas')); ?>:</b>
	<?php echo CHtml::encode($data->multas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comentario')); ?>:</b>
	<?php echo CHtml::encode($data->comentario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_seguimiento')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_seguimiento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('per_client')); ?>:</b>
	<?php echo CHtml::encode($data->per_client); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('per_sm')); ?>:</b>
	<?php echo CHtml::encode($data->per_sm); ?>
	<br />

	*/ ?>

</div>