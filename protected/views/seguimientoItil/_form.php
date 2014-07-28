<?php
/* @var $this SeguimientoItilController */
/* @var $model SeguimientoItil */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'seguimiento-itil-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldRow($model,'cliente_id'); ?>
		
		<?php echo $form->textFieldRow($model,'felicitaciones'); ?>
		
		<?php echo $form->textFieldRow($model,'reclamos'); ?>
		
		<?php echo $form->textFieldRow($model,'problemas'); ?>
		
		<?php echo $form->textFieldRow($model,'cambios'); ?>
		
		<?php echo $form->textFieldRow($model,'estado_cmdb'); ?>
		
		<?php echo $form->textFieldRow($model,'incidentes'); ?>
		
		<?php echo $form->textFieldRow($model,'requerimientos'); ?>
		
		<?php echo $form->textFieldRow($model,'backlog'); ?>
		
		<?php echo $form->textFieldRow($model,'indisponibilidad'); ?>
		
		<?php echo $form->textFieldRow($model,'sip'); ?>
		
		<?php echo $form->textFieldRow($model,'reuniones'); ?>
		
		<?php echo $form->textFieldRow($model,'minutas'); ?>
		
		<?php echo $form->textFieldRow($model,'reunion_servicio'); ?>
		
		<?php echo $form->textFieldRow($model,'informe'); ?>
		
		<?php echo $form->textFieldRow($model,'facturado'); ?>
		
		<?php echo $form->textFieldRow($model,'facturacion_extra'); ?>
		
		<?php echo $form->textFieldRow($model,'multas'); ?>
		
		<?php echo $form->textFieldRow($model,'fecha'); ?>
		
		<?php echo $form->textAreaRow($model,'comentario',array('rows'=>6, 'cols'=>50)); ?>
		
		<?php echo $form->textFieldRow($model,'tipo_seguimiento'); ?>
		
		<?php echo $form->textFieldRow($model,'per_client'); ?>
		
		<?php echo $form->textFieldRow($model,'per_sm'); ?>
		
	</br>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Crear' : 'Guardar')); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Cancelar',
		 'url'=> array("cliente/index"),	
	    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'small', // null, 'large', 'small' or 'mini'
	)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->