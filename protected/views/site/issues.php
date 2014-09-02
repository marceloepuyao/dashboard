<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
		"Issues"=> array("issuescliente"),
		"Issues: $cliente->nombre",
);

?>

<h2>Issues: <?php echo $cliente->nombre;?></h2>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'issue-grid',
	'dataProvider'=>$issues,
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

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'url' => array('issuescliente'),
    'label'=>'Volver',
    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
)); ?>
