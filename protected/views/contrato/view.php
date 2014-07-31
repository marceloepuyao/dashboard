<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Contratos: '.$cliente->nombre=>array('index', 'id'=>$cliente->id),
	$model->titulo,
);

$this->menu=array(
	array('label'=>'Contratos: '.$cliente->nombre, 'url'=>array('index', 'id'=>$model->cliente_id)),
	array('label'=>'Nuevo Contrato', 'url'=>array('create', 'id'=>$model->cliente_id)),
	array('label'=>'Crear Sla', 'url'=>array('sla/create', 'id'=>$model->id)),
	array('label'=>'Actualizar Contrato', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Contrato', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h2>Contrato: <?php echo $model->titulo; ?></h2>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'cliente_id',
			'value'=> $cliente->nombre,
		),
		'facturacion',
		'inicio',
		'fin',
		'codigo_moebius',
		'titulo',
		array(
			'name'=>'Servicios Contratados',
			'value'=> $lineaservicios!=null?implode(" ,  ",$lineaservicios):"",
		),
	),
)); ?>

<h2>SLA</h2>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'contrato-grid',
	'dataProvider'=>$slas,
	'columns'=>array(
		'nombre',
		'objetivo',
		'descripcion',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
			'buttons'=>array(
					'update'=>array(
							'url'=>'$this->grid->controller->createUrl("/sla/update", array("id"=>$data->primaryKey))',
							'click'=>'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
					),
					'delete'=>array(
							'url'=>'$this->grid->controller->createUrl("/sla/delete", array("id"=>$data->primaryKey))',
					),
			),
		),
	),
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('sla/create', 'id'=>$model->id),
    'label'=>'Crear SLA',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('contrato/index', 'id'=>$cliente->id),
    'label'=>'Volver',
    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>

