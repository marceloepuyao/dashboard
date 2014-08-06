<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
	'type'=>'inverse',
	'collapse'=>true,
	'brand'=> $imghtml= CHtml::image(Yii::app()->request->baseUrl.'/images/logo-sonda-white.png', 'DORE') , 
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
               array('label'=>'Inicio', 'url'=>array('/site/index'), 'visible'=>!Yii::app()->user->isGuest),
            	array('label'=>'Estado Cliente', 'url'=>array('/cliente/estado'), 'visible'=>!Yii::app()->user->isGuest),
            	array('label'=>'Mis Clientes', 'url'=>array('/cliente/misclientes'), 'visible'=>!Yii::app()->user->isGuest),	
				array('label'=>'Mis Issues Abiertos', 'url'=>array('/issue/misissues'), 'visible'=>!Yii::app()->user->isGuest),
            	array('label'=>'Usuario', 'url'=>array('/usuario'), 'visible'=>(isset(Yii::app()->user->perfil)?(Yii::app()->user->perfil=="Admin"):false)),
            		
            ),
        ),
    		array(
    				'class'=>'bootstrap.widgets.TbMenu',
    				'htmlOptions'=>array('class'=>'pull-right'),
    				'items'=>array(
    						array('label'=>isset(Yii::app()->user->nombre)?"Bienvenido ".Yii::app()->user->nombre." ".Yii::app()->user->apellido:"", 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest, 'items'=>array(
    								array('label'=>'Usuarios', 'url'=>array('/usuario/index'),'visible'=>Yii::app()->user->isAdmin()),
									array('label'=>'Clientes', 'url'=>array('/cliente/index'),'visible'=>Yii::app()->user->isAdmin()),
    								array('label'=>'Competidores', 'url'=>array('/competidor/index'),'visible'=>Yii::app()->user->isAdmin()),
    								array('label'=>'Línea de Servicios', 'url'=>array('/lineaServicio/index'), 'visible'=>Yii::app()->user->isAdmin()),
    								array('label'=>'Seguimientos', 'url'=>array('/seguimiento/admin'), 'visible'=>Yii::app()->user->isAdmin()),
    								array('label'=>'SSM', 'url'=>array('/usuario/ssm'), 'visible'=>Yii::app()->user->isAdmin()),
									'---',
    								array('label'=>'Logout', 'url'=>array('/site/logout')),
    						)),
    						array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
    				)
    		),
    ),
)); ?>

<div class="container" id="page">
	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> SONDA - Gerencia Data Center & Cloud - Gestión de Servicios - Automatización y Procesos </br>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/d41d8cd98f00b204e9800998ecf8427e/es_ES1elhi-1988229788/6265/6/1.4.7/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=fbb8003c"></script>

</body>
</html>
