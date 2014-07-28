<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	'Update',
);

$this->menu=array(
	array('label'=>'Administrar Usuarios', 'url'=>array('index')),
	array('label'=>'Crear Usuario', 'url'=>array('create')),
	array('label'=>'Ver Usuario', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h2>Actualizar Usuario: <?php echo $model->nombre." ".$model->apellido; ?></h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>