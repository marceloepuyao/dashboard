<?php
/* @var $this IssueController */
/* @var $model Issue */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'issue-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="required">*</span>Campo requerido.</p>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textAreaRow($model,'descripcion',array('rows'=>6, 'cols'=>50)); ?>
		<?php //echo $form->dropDownListRow($model, 'linea_servicio_id', $lineaservicios); ?>

		<?php //echo $form->dropDownListRow($model, 'cliente_id', array('Something ...', '1', '2', '3', '4', '5')); ?>
		
		<?php //echo $form->textFieldRow($model,'fecha'); ?>
		
		<?php echo $form->dropDownListRow($model, 'criticidad', array(1=>'Baja', 2=>'Media', 3=>'Alta')); ?>
		
		<?php if(!$model->isNewRecord){?>
		<?php echo $form->dropDownListRow($model, 'solucionado', array(1=>'Pendiente', 2=>'Terminado')); ?>
		<?php }?>
		
		<?php echo $form->labelEx($model, 'lineaservicios'); ?></p>
	  	<?php echo CHtml::checkBoxList('lineaservicios', $selected_keys, $lineaservicios, array('separator'=>' ','template'=>'<span class="myItem" style="display:table;">{input} {label} </span>')); ?>
		
		
		</br>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Crear' : 'Guardar')); ?>
		
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Cancelar',
			 'url'=> array("issue/index", 'id'=>$cliente->id),	
		    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'small', // null, 'large', 'small' or 'mini'
		)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->