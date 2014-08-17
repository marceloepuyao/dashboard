<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	public function accessRules()
	{
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('error','login', 'logout'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('Index','sla', 'cumplimientoslaajax','cumplimientoslaporclienteajax', 'persm', 'PercepcionSMAjax','PercepcionSMporClienteAjax' ,'percl', 'PercepcionClienteAjax','PercepcionClientePorClienteAjax','issuescliente', 'issuesactivosporcliente', 'IssuesActivosPorServicio'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if(Yii::app()->user->isGuest){
			$this->redirect($this->createUrl('login'));
		}
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$cumplimiento_sla = Dashboard::getCumplimientoSla($usuario->id);
		$porcentajeClientesSinIssues = Dashboard::getClientesSinIssuesActivos($usuario->id);
		$percepcionSM = Dashboard::getPercepcionGeneralSMporUsuario($usuario->id);
		$percepcionCliente = Dashboard::getPercepcionGeneralClientePorUsuario($usuario->id);
	
		
		$this->render('index',array(
					 	'cumplimiento_sla'=>$cumplimiento_sla,
					 	'porcentajeClientesSinIssues'=>$porcentajeClientesSinIssues,
					 	'percepcionSM'=>$percepcionSM,
					 	'percepcionCliente'=>$percepcionCliente,
		));
		
	}
	
	public function actionSla()
	{
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$clientes = CHtml::listData($usuario->clientes, "id", "nombre");
		
		$cumplimientoSlaPorCliente = Dashboard::getCumplimientoSlaPorCliente($usuario->id);		
		$cumplimientoSlaHistoricoPorCliente = Dashboard::getCumplimientoSlaHistoricoPorCliente($usuario->id);
		
		$data = array();
		foreach ($cumplimientoSlaHistoricoPorCliente as $k => $v){
			array_push($data, array("name"=> $k, "data"=>$v));
		}		
		
		$fechas = Dashboard::getFechasMensual($usuario->id);
		$fechasarray=array();
		foreach ($fechas as $fecha){
			array_push($fechasarray, $fecha["fecha"]);
		}
		//die(var_dump(json_encode($data)));
		$this->render('sla', array(
			'fechas'=>$fechasarray,
			'clientes'=>$clientes,
			'cumplimientoSlaPorCliente'=> $cumplimientoSlaPorCliente,
			'cumplimientoSlaHistoricoPorCliente'=>json_encode($data),
		));
	}

	public function actionPersm()
	{
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$persmgeneralhistorica = Dashboard::getPercepcionGeneralHistoricaSM($usuario->id);
		
		$satisfaccionsm = Dashboard::getSatisfaccionGeneralSM($usuario->id);
		
		//die(var_dump($satisfaccionsm));
		
		$data = array();
		foreach ($persmgeneralhistorica as $k => $v){
			array_push($data, array("name"=> $k, "data"=>$v));
		}
	
		
		$fechas = Dashboard::getFechas($usuario->id);
		$fechasarray=array();
		foreach ($fechas as $fecha){
			array_push($fechasarray, $fecha["fecha"]);
		}
		$this->render('persm', array(
			'fechas'=>$fechasarray,
			'persmgeneralhistorica'=>json_encode($data),
			'satisfaccionsm'=> $satisfaccionsm,
		));
	}

	public function actionPercl()
	{
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$perclgeneralhistorica = Dashboard::getPercepcionGeneralHistoricaCliente($usuario->id);
		
		$satisfaccioncliente = Dashboard::getSatisfaccionGeneralCliente($usuario->id);
		
		$data = array();
		foreach ($perclgeneralhistorica as $k => $v){
			array_push($data, array("name"=> $k, "data"=>$v));
		}
		$fechas = Dashboard::getFechas($usuario->id);
		$fechasarray=array();
		foreach ($fechas as $fecha){
			array_push($fechasarray, $fecha["fecha"]);
		}
		
		$this->render('percl', array(
			'fechas'=>$fechasarray,
			'perclgeneralhistorica'=>json_encode($data),
			'satisfaccioncliente'=> $satisfaccioncliente,
		));
	}
	
	
	public function actionIssuesCliente(){
		if(Yii::app()->user->isGuest){
			$this->redirect($this->createUrl('login'));
		}
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		
		//$porcentajeClientesSinIssues = Dashboard::getClientesSinIssuesActivos($usuario->id);
		$issuesClientesDetalle = Dashboard::getClientesConIssuesActivosPorCliente($usuario->id);
		$issuesServiciosDetalle = Dashboard::getIssuesActivosPorServicio($usuario->id);
	
		//$a = Dashboard::getIssuesHistoricosPorClienteSegunServicio($usuario->id, 'Preventa');
		//no sé cómo iterar dentro del render, por lo que las queries por servicio se harán directamente en el php issuecliente.php
		$this->render('issuescliente',array(
				//'porcentajeClientesSinIssues'=>$porcentajeClientesSinIssues,
				'issuesClientesDetalle'=>$issuesClientesDetalle,
				'issuesServiciosDetalle'=>$issuesServiciosDetalle,
		));
	
	}
	/*

	public function actionCumplimientoSlaAjax($fecha){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$cumplimiento_sla = Dashboard::getCumplimientoSla($usuario->id, $fecha);
		$this->renderPartial('_ajax', array(
				'data'=>$cumplimiento_sla,
		));
	}

	public function actionCumplimientoSlaPorClienteAjax($fecha){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$clientes = Dashboard::getCumplimientoSlaPorCliente($usuario->id,$fecha);
		$this->renderPartial('_ajax', array(
				'data'=>json_encode($clientes)
		));
	}

	public function actionClientesSinIssuesAjax($fecha){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$porcentajeClientesSinIssues = Dashboard::getClientesSinIssuesActivos($usuario->id, $fecha);
		$this->renderPartial('_ajax', array(
			'data'=>$porcentajeClientesSinIssues,
		));
	}

	public function actionClientesSinIssuesPorClienteAjax($fecha){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$issuesActivosPorCliente = Dashboard::getClientesSinIssuesActivosPorCliente($usuario->id, $fecha);
		$this->renderPartial('_ajax', array(
			'data'=>json_encode($issuesActivosPorCliente),
		));
	}

	public function actionIssuesActivosPorServicio(){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$issuesAbiertosPorServicio = Dashboard::getIssuesActivosPorServicio($usuario->id);
		$this->renderPartial('_ajax', array(
			'data'=>json_encode($issuesAbiertosPorServicio),
		));
	}


	public function actionPercepcionSMAjax($fecha){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$percepcion_sm = Dashboard::getPercepcionSM($usuario->id, $fecha);
		$this->renderPartial('_ajax', array(
				'data'=>$percepcion_sm,
		));
	}

	public function actionPercepcionSMporClienteAjax($fecha){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$percepcion_sm_clientes = Dashboard::getPercepcionSMporCliente($usuario->id,$fecha);
		$this->renderPartial('_ajax', array(
				'data'=>json_encode($percepcion_sm_clientes)
		));
	}

	public function actionPercepcionClienteAjax($fecha){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$percepcion_clientes = Dashboard::getPercepcionCliente($usuario->id, $fecha);
		$this->renderPartial('_ajax', array(
				'data'=>$percepcion_clientes,
		));
	}

	public function actionPercepcionClientePorClienteAjax($fecha){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$percepcion_clientes_clientes = Dashboard::getPercepcionClientePorCliente($usuario->id,$fecha);
		$this->renderPartial('_ajax', array(
				'data'=>json_encode($percepcion_clientes_clientes)
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(!Yii::app()->user->isGuest){
			
			$this->redirect(array("index"));
		}
		
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}