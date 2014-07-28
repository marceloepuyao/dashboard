<?php
/* @var $this ClienteController */
/* @var $model Cliente */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'cliente-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="required">*</span> Campo requerido.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->textFieldRow($model,'nombre',array('size'=>60,'maxlength'=>255)); ?>
	
	<?php echo $form->dropDownListRow($model, 'usuario_id', $usuarios ); ?>
	
	<?php echo $form->textFieldRow($model,'industria',array('size'=>60,'maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'categoria'); ?>

	<?php echo $form->textFieldRow($model,'empleados'); ?>

	<?php echo $form->textFieldRow($model,'facturacion'); ?>

	<?php echo $form->textFieldRow($model,'rut',array('size'=>45,'maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'hq',array('size'=>60,'maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'jp',array('size'=>45,'maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'kam',array('size'=>45,'maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'arquitecto',array('size'=>45,'maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'competidor',array('size'=>60,'maxlength'=>255)); ?>
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