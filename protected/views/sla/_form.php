<?php
/* @var $this SlaController */
/* @var $model Sla */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'sla-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="required">*</span>Campo requerido.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->textFieldRow($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
	<?php echo $form->textFieldRow($model,'objetivo'); ?>
	<?php echo $form->textAreaRow($model,'descripcion',array('size'=>60,'maxlength'=>200)); ?>
		

	</br>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Crear' : 'Guardar')); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Cancelar',
		 'url'=> array("contrato/view", 'id'=>$contrato->id),	
	    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'small', // null, 'large', 'small' or 'mini'
	)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->