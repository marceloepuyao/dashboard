<?php
/* @var $this SeguimientoItilController */
/* @var $model SeguimientoItil */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cliente_id'); ?>
		<?php echo $form->textField($model,'cliente_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'felicitaciones'); ?>
		<?php echo $form->textField($model,'felicitaciones'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reclamos'); ?>
		<?php echo $form->textField($model,'reclamos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'problemas'); ?>
		<?php echo $form->textField($model,'problemas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cambios'); ?>
		<?php echo $form->textField($model,'cambios'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado_cmdb'); ?>
		<?php echo $form->textField($model,'estado_cmdb'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'incidentes'); ?>
		<?php echo $form->textField($model,'incidentes'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requerimientos'); ?>
		<?php echo $form->textField($model,'requerimientos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog'); ?>
		<?php echo $form->textField($model,'backlog'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'indisponibilidad'); ?>
		<?php echo $form->textField($model,'indisponibilidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sip'); ?>
		<?php echo $form->textField($model,'sip'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reuniones'); ?>
		<?php echo $form->textField($model,'reuniones'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'minutas'); ?>
		<?php echo $form->textField($model,'minutas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reunion_servicio'); ?>
		<?php echo $form->textField($model,'reunion_servicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'informe'); ?>
		<?php echo $form->textField($model,'informe'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'facturado'); ?>
		<?php echo $form->textField($model,'facturado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'facturacion_extra'); ?>
		<?php echo $form->textField($model,'facturacion_extra'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'multas'); ?>
		<?php echo $form->textField($model,'multas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comentario'); ?>
		<?php echo $form->textArea($model,'comentario',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_seguimiento'); ?>
		<?php echo $form->textField($model,'tipo_seguimiento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'per_client'); ?>
		<?php echo $form->textField($model,'per_client'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'per_sm'); ?>
		<?php echo $form->textField($model,'per_sm'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->