<?php
/* @var $this ClienteController */
/* @var $model Cliente */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'industria',array('size'=>60,'maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'empleados'); ?>

	<?php echo $form->textFieldRow($model,'facturacion'); ?>

	<?php echo $form->textFieldRow($model,'categoria'); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('size'=>60,'maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'rut',array('size'=>45,'maxlength'=>45)); ?>
	
	<?php echo $form->textFieldRow($model,'hq',array('size'=>60,'maxlength'=>255)); ?>
	<?php echo $form->textFieldRow($model,'jp',array('size'=>45,'maxlength'=>45)); ?>
	
	<?php echo $form->textFieldRow($model,'kam',array('size'=>45,'maxlength'=>45)); ?>
	
	<?php echo $form->textFieldRow($model,'arquitecto',array('size'=>45,'maxlength'=>45)); ?>
	
	<?php echo $form->textFieldRow($model,'competidor',array('size'=>60,'maxlength'=>255)); ?>

	</br>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=> 'Buscar')); ?>

<?php $this->endWidget(); ?>

</div><!-- search-form -->