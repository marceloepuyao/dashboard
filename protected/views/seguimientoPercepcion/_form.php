<?php
/* @var $this SeguimientoPercepcionController */
/* @var $model SeguimientoPercepcion */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'seguimiento-percepcion-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'linea_servicio_contrato_id'); ?>
		<?php echo $form->textField($model,'linea_servicio_contrato_id'); ?>
		<?php echo $form->error($model,'linea_servicio_contrato_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'per_cliente'); ?>
		<?php echo $form->textField($model,'per_cliente'); ?>
		<?php echo $form->error($model,'per_cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'per_sm'); ?>
		<?php echo $form->textField($model,'per_sm'); ?>
		<?php echo $form->error($model,'per_sm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo_seguimiento'); ?>
		<?php echo $form->textField($model,'tipo_seguimiento'); ?>
		<?php echo $form->error($model,'tipo_seguimiento'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->