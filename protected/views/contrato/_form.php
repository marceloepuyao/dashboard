<?php
/* @var $this ContratoController */
/* @var $model Contrato */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contrato-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="required">*</span> Campo requerido.</p>
	
	<?php echo $form->textFieldRow($model,'titulo',array('size'=>60,'maxlength'=>100)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'facturacion'); ?>
	
	
	<?php echo $form->labelEx($model,'inicio'); ?>
	<?php echo $form->dateField($model,'inicio'); ?>
	<?php echo $form->error($model,'inicio'); ?>
	</br>
	
	<?php echo $form->labelEx($model,'fin'); ?>
	<?php echo $form->dateField($model,'fin'); ?>
	<?php echo $form->error($model,'fin'); ?>
	
	<?php echo $form->textFieldRow($model,'codigo_moebius',array('size'=>20,'maxlength'=>20)); ?>
	
	 <?php //echo $form->checkBoxListRow($model, 'lineaservicios', $lineaservicios, $selected_keys); ?>
	  <?php echo $form->labelEx($model, 'lineaservicios'); ?></p>
	  <?php echo CHtml::checkBoxList('lineaservicios', $selected_keys, $lineaservicios, array('separator'=>' ','template'=>'<span class="myItem" style="display:table;">{input} {label} </span>')); ?>
		
		
	</br>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Crear' : 'Guardar')); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Cancelar',
		 'url'=> array("contrato/index", 'id'=>$cliente->id),	
	    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'small', // null, 'large', 'small' or 'mini'
	)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->