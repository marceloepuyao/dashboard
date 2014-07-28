<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	$model->nombre." ".$model->apellido,
);

$this->menu=array(
	array('label'=>'Administrar Usuarios', 'url'=>array('index')),
	array('label'=>'Crear Usuario', 'url'=>array('create')),
	array('label'=>'Actualizar Usuario', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Usuario', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h2>Usuario: <?php echo $model->nombre." ".$model->apellido; ?></h2>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
		'apellido',
		'email',
		array(
				'name'=>'perfil_id',
				'filter'=>array('1'=>"Admin",'2'=>'SSM','3'=>'SM'),
				'value'=>($model->perfil_id=="1")?("Admin"):(($model->perfil_id=="2")?("SSM"):("SM")),
		),
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('usuario/index'),
    'label'=>'Volver',
    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>

