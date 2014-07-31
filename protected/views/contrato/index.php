<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Contratos: '.$cliente->nombre,
);

$this->menu=array(
	array('label'=>'Crear Contrato', 'url'=>array('create', 'id'=>$cliente->id)),
);

?>

<h2>Contratos: <?php echo $cliente->nombre;?></h2>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'contrato-grid',
	'dataProvider'=>$model,
	'columns'=>array(
		'titulo',
		'facturacion',
		'inicio',
		'fin',
		'codigo_moebius',
		array(
			'name'=> 'lineaservicios',
			'value'=> 'implode(", ", array_keys(CHtml::listData($data->lineaServicios, "nombre" , "id")));'
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}{delete}',
		),
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('cliente/misclientes'),
    'label'=>'Volver',
    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>
