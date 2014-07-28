<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Usuarios', 'url'=>array('index')),
);
?>

<h2>Crear Usuario</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>