<?php
/* @var $this ClienteController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mis Clientes',
);

?>

<h2>Mis Clientes</h2>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'condensed',
    'dataProvider'=>$dataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'cliente', 'header'=>'Cliente'),
        array(
            'class'=>'CButtonColumn',
        	'header'=>'Ficha',
    		'template'=>'{ficha}',
			'buttons'=>array(
				'ficha' => array
		        (
		            'label'=>'Ficha',
		            'imageUrl'=>Yii::app()->request->baseUrl.'/images/ficha.png',
		            'url'=>'Yii::app()->createUrl("cliente/updatesm", array("id"=>$data["id"]))',
		        ),
			),
				
        ),
    		array(
    				'class'=>'CButtonColumn',
    				'header'=>'Contratos',
    				'template'=>'{contratos}',
    				'htmlOptions'=>array('style'=>'width: 50px'),
    				'buttons'=>array(
    						'contratos' => array
    						(
    								'label'=>'Contratos',
    								'imageUrl'=>Yii::app()->request->baseUrl.'/images/contratos.png',
    								'url'=>'Yii::app()->createUrl("contrato/index", array("id"=>$data["id"]))',
    						),	
    				),
    		),
    		array(
    				'class'=>'CButtonColumn',
    				'header'=>'Issues',
    				'template'=>'{issues}',
    				'htmlOptions'=>array('style'=>'width: 50px'),
    				'buttons'=>array(
    						'issues' => array
    						(
    								'label'=>'Issues',
    								'imageUrl'=>Yii::app()->request->baseUrl.'/images/issues.png',
    								'url'=>'Yii::app()->createUrl("issue/index", array("id"=>$data["id"]))',
    						),	
    				),
    		),
    		array(
    				'class'=>'CButtonColumn',
    				'header'=>'Seguimiento',
    				'template'=>'{seguimiento}',
    				'htmlOptions'=>array('style'=>'width: 50px'),
    				'buttons'=>array(
    						'seguimiento' => array
    						(
    								'label'=>'Seguimiento',
    								'imageUrl'=>Yii::app()->request->baseUrl.'/images/seguimiento.png',
    								'url'=>'Yii::app()->createUrl("seguimiento/index", array("id"=>$data["id"]))',
    						),
    				),
    		),
    ),
)); ?>


<table cellpadding='2' ><tr><td></td><td></td><td></td><td></td><td></td></tr>

<?php /*foreach ($clientes as $cliente){?>
	<tr><td><?php echo $cliente->nombre;?></td><td>
	
	<?php echo CHtml::link('Ficha',array('update', 'id'=>$cliente->id )); ?>
	<?php echo CHtml::link('Contratos',array('contrato/index', 'id'=>$cliente->id )); ?>
	<?php echo CHtml::link('Issues',array('issue/index', 'id'=>$cliente->id )); ?>
	<?php echo CHtml::link('Seguimiento',array('seguimiento/index', 'id'=>$cliente->id )); ?>

	<?php }*/?>
	
	</table>

	
