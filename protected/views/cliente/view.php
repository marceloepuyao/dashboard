<?php
/* @var $this ClienteController */
/* @var $model Cliente */

$this->breadcrumbs=array(
	'Administrar Clientes'=>array('index'),
	$model->nombre,
);

$this->menu=array(
	array('label'=>'Administrar Clientes', 'url'=>array('index')),
	array('label'=>'Crear Cliente', 'url'=>array('create')),
	array('label'=>'Actualizar Cliente', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Cliente', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h2>Cliente: <?php echo $model->nombre; ?></h2>
<?php $usuario =  Usuario::model()->findByPk($model->usuario_id); ?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'usuario_id',
			'value'=> $usuario['nombre']." ".$usuario['apellido'],
		),
		'industria',
		'empleados',
		'facturacion',
		'categoria',
		'nombre',
		'rut',
		'hq',
		'jp',
		'kam',
		'arquitecto',
		'competidor',
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('cliente/index'),
    'label'=>'Volver',
    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>
