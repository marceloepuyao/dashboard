<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'apellido',array('size'=>45,'maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'email',array('size'=>60,'maxlength'=>255)); ?>

	</br>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=> 'Buscar')); ?>


<?php $this->endWidget(); ?>

</div><!-- search-form -->