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
    'dataProvider'=>$lineaservicios,
    'columns'=>array(
		array(
			'name'=>'Líneas de Servicio',
			'value'=> '$data["nombre"]',
		),
		array(
			'name'=>'Percepción Cliente',
			'type'=>'raw',
			'value'=>'CHtml::textField("per_cliente[$data[id]]",0,array("style"=>"width:50px;"))',
		),
		array(
		'name'=>'Percepción SM',
		'type'=>'raw',
		'value'=>'CHtml::textField("per_sm[$data[id]]",0,array("style"=>"width:50px;"))',
		),

	)
));?>

<h3>Seguimiento Itil</h3>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'servicio-grid',
    'dataProvider'=>$seguimientoItil,
    'columns'=>array(
		array(
			'name'=>'KPI',
			'value'=> '$data["nombre"]',
		),
		array(
			'name'=>'Valor',
			'type'=>'raw',
			'value'=>'CHtml::textField("itil[$data[id]]",0,array("style"=>"width:50px;"))',
		),

	)
));?>

<h3>SLA</h3>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'servicio-grid',
    'dataProvider'=>$sla,
    'columns'=>array(
		array(
			'name'=>'Contrato',
			'value'=> 'Contrato::model()->findByPk($data["contrato_id"])->titulo',
		),
		array(
			'name'=>'SLA',
			'value'=> '$data["nombre"]',
		),
		array(
			'name'=>'Objetivo(%)',
			'value'=> '$data["objetivo"]',
		),
		array(
			'name'=>'Valor',
			'type'=>'raw',
			'value'=>'CHtml::textField("sla[$data[id]]",0,array("style"=>"width:50px;"))',
		),
	)
));?>

	
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>true ? 'Crear' : 'Guardar')); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Cancelar',
		 'url'=> array("seguimiento/index", 'id'=>$cliente->id),	
	    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'small', // null, 'large', 'small' or 'mini'
	)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->