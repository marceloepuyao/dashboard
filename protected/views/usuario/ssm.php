<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Administrar SSM',
);

?>

<h2>Administrar SSM</h2>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'servicio-grid',
	'summaryText' => '',
    'dataProvider'=>$usuariosSsm,
    'columns'=>array(
    	array(
    		'name'=>'nombre',
    		'value'=>'$data->nombre." ".$data->apellido',
    	),
		array
		(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'buttons'=>array
			(
				'view' => array
				(
						//'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
						'url'=>'Yii::app()->createUrl("usuario/sm", array("id"=>$data->id))',
				),
			),
		),
	)
));?>
