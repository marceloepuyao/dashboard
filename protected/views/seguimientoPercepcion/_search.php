<?php
/* @var $this SeguimientoPercepcionController */
/* @var $model SeguimientoPercepcion */
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
		<?php echo $form->label($model,'linea_servicio_contrato_id'); ?>
		<?php echo $form->textField($model,'linea_servicio_contrato_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'per_cliente'); ?>
		<?php echo $form->textField($model,'per_cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'per_sm'); ?>
		<?php echo $form->textField($model,'per_sm'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_seguimiento'); ?>
		<?php echo $form->textField($model,'tipo_seguimiento'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->