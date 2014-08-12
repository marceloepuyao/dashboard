<?php
/* @var $this ClienteController */
/* @var $model Cliente */
$this->layout = '//layouts/column2';
$this->breadcrumbs=array(
	'Administrar Seguimientos',
);

$this->menu=array(
	array('label'=>'Generar Seguimiento Semanal (Percepción)', 'url'=>array('generarSemanal')),
	array('label'=>'Generar Seguimiento Mensual (ITIL y SLA)', 'url'=>array('generarMensual')),
);

?>

<h2>Administrar Seguimientos</h2>

<h4>Seguimiento Percepción</h4>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'contrato-grid',
	'dataProvider'=>$ssemanalData,
	'columns'=>array(
		array(
			'name'=>'Fecha',
			'value'=>'$data["fecha"]',
		),
		array(
		'class'=>'CButtonColumn',
		'template'=>'{update}{delete}',
		'buttons'=>array(
				'delete'=>array(
						'url'=>'$this->grid->controller->createUrl("/seguimiento/borrarsemanal", array("fecha"=>$data["fecha"]))',
				),
				'update'=>array(
					'url'=>'$this->grid->controller->createUrl("/seguimiento/regenerarsemanal", array("fecha"=>$data["fecha"]))',
				),
		),
),
	),
)); ?>

<h4>Seguimiento Itil y SLA</h4>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'contrato-grid',
	'dataProvider'=>$smensualData,
	'columns'=>array(
		array(
			'name'=>'Fecha Creación',
			'value'=>'$data["fecha"]',
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'buttons'=>array(
					'delete'=>array(
							'url'=>'$this->grid->controller->createUrl("/seguimiento/borrarmensual", array("fecha"=>$data["fecha"]))',
					),
					'update'=>array(
							'url'=>'$this->grid->controller->createUrl("/seguimiento/regenerarmensual", array("fecha"=>$data["fecha"]))',
					),
			),
		),
	),
)); ?>
