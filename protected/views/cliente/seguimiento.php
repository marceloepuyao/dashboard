<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Mis Clientes'=> array('cliente/misclientes'),
	'Seguimiento',
);

?>

<h3>Seguimiento ITIL </h3>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$itil,
	'attributes'=>array(
		'felicitaciones',
		'reclamos',
		'problemas',
		'cambios',
		'estado_cmdb',
		'incidentes',
		'requerimientos',
		'backlog',
		'indisponibilidad',
		'sip',
		'reuniones',
		'minutas',
		'reunion_servicio',
		'informe',
		'facturado',
		'facturacion_extra',
		'multas',
		'fecha',
		'comentario',
		'tipo_seguimiento',
		'per_client',
		'per_sm',
	),
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('seguimientoitil/update/'.$itil->id),
    'label'=>'Editar Seguimiento',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>

<h3>SLA </h3>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'contrato-grid',
	'dataProvider'=>$sla,
	'columns'=>array(
		'nombre',
		'objetivo',
		'descripcion',
		'contrato_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
