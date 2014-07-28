<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';

?>




 <div id="image_div" style="width: 50%; height: 430px;float:left;">
 	<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/grafico1.jpg', 'DORE');?>
 </div>
 
	
 
 <div id="asdasdiv" style="width: 50%; height: 430px;float:right;">
    <p><h2>Ingreso al sistema</h2></p>
    <p>Por favor complete el siguiente formulario con sus credenciales:</p>

	<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'htmlOptions'=>array('class'=>'well'),
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>
	
		<p class="note"><span class="required">*</span> Campo requerido.</p>
	
			<?php echo $form->textFieldRow($model,'username'); ?>
			<?php echo $form->error($model,'username'); ?>
	
			<?php echo $form->passwordFieldRow($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>
	
			<?php echo $form->checkBoxRow($model,'rememberMe'); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
	
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Ingresar'));//echo CHtml::submitButton('Ingresar'); ?>
	
	<?php $this->endWidget(); ?>
	</div><!-- form -->
      
 </div>


