<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Administrar SSM'=>array('usuario/ssm'),
	$ssm->nombre." ".$ssm->apellido,
);

?>

<h2><?php echo $ssm->nombre." ".$ssm->apellido;?></h2>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'sm-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'servicio-grid',
	'summaryText' => '',
    'dataProvider'=>$sms,
    'columns'=>array(
    	array(
			'name'=>'',
			'type'=>'raw',
			'value'=>'CHtml::checkBox("sm[$data[id]]", $data["selected"])',

		),
		array(
    		'name'=>'Nombre',
    		'value'=>'$data["nombre"]." ".$data["apellido"]',
    	),
	)
));?>
<?php echo CHtml::hiddenField('sm[0]', 0);?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Guardar')); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Cancelar',
		 'url'=> array("usuario/ssm"),	
	    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'small', // null, 'large', 'small' or 'mini'
	)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
