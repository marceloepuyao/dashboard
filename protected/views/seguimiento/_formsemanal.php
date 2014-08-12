<?php
/* @var $this ClienteController */
/* @var $model Cliente */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'seguimiento-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<h3>Percepción</h3>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'servicio-grid',
	 'summaryText' => '',
    'dataProvider'=>$lineaservicios,
    'columns'=>array(
		array(
			'name'=>'Líneas de Servicio',
			'value'=> '$data["nombre"]',
		),
		array(
			'name'=>'Percepción Cliente',
			'type'=>'raw',
			'value'=>'CHtml::numberField("per_cliente[$data[linea_servicio_contrato_id]]",isset($data["per_cliente"])?$data["per_cliente"]:0,array("style"=>"width:50px;", "type"=>"number", "min"=>0, "max"=>5))',
		),
		array(
			'name'=>'Percepción SM',
			'type'=>'raw',
			'value'=>'CHtml::numberField("per_sm[$data[linea_servicio_contrato_id]]",isset($data["per_sm"])?$data["per_sm"]:0,array("style"=>"width:50px;", "type"=>"number", "min"=>0, "max"=>5))',
		),
	)
));?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'servicio-grid',
	 'summaryText' => '',
    'dataProvider'=>$percepcionGeneral,
    'columns'=>array(
		array(
			'name'=>'',
			'value'=> '"Percepción General"',
		),
		array(
			'name'=>'Percepción Cliente',
			'type'=>'raw',
			'value'=>'CHtml::numberField("per_general[per_cliente]",isset($data["per_cliente"])?$data["per_cliente"]:0,array("style"=>"width:50px;", "type"=>"number", "min"=>0, "max"=>5))',
		),
		array(
			'name'=>'Percepción SM',
			'type'=>'raw',
			'value'=>'CHtml::numberField("per_general[per_sm]",isset($data["per_sm"])?$data["per_sm"]:0,array("style"=>"width:50px;", "type"=>"number", "min"=>0, "max"=>5))',
		),
	)
));?>
	
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=> 'Guardar')); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Cancelar',
		 'url'=> array("seguimiento/index", 'id'=>$cliente->id),	
	    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'small', // null, 'large', 'small' or 'mini'
	)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->