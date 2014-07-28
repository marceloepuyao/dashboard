<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'usuario-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="required">*</span>Campo requerido.</p>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldRow($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
	<?php echo $form->textFieldRow($model,'apellido',array('size'=>45,'maxlength'=>45)); ?>
	<?php echo $form->textFieldRow($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	
	<?php echo $form->passwordFieldRow($model, $model->isNewRecord ? 'password':'newpassword', array('class'=>'span3', 'size'=>45,'maxlength'=>45)); ?>
	
	<?php echo $form->passwordFieldRow($model, 'confirmpassword', array('class'=>'span3', 'size'=>45,'maxlength'=>45)); ?>
	
	<?php echo $form->dropDownListRow($model, 'perfil_id', array(1=>'Admin', 2=>'SSM', 3=>'SM') ); ?>
	

	</br>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Crear' : 'Guardar')); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Cancel',
		'url'=> array('index'),
	    'type'=>'action', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'small', // null, 'large', 'small' or 'mini'
	)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->