<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
	'Mis Issues',
);

?>

<h2>Mis Issues</h2>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'issue-grid',
	'dataProvider'=>$model,
	'columns'=>array(
		'fecha',
		array(
			'name'=> 'cliente_id',
			'value'=> 'Cliente::model()->findByPk($data->cliente_id)->nombre',
		),
		array(
			'name'=> 'Líneas de Servicios',
			'value'=> 'implode(", ", array_keys(CHtml::listData($data->lineaServicios, "nombre" , "id")));'
		),
		'descripcion',
		array(
			'name'=>'criticidad',
			'value'=>'$data->criticidad==1?"Baja":($data->criticidad==2?"Media":3) ',
		),
		array(
			'name'=>'solucionado',
			'value'=>'$data->solucionado==1?"Pendiente":"Terminado" ',
		),
	),
)); ?>
