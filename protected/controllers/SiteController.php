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
						'actions'=>array('Index','sla', 'cumplimientoslaajax'),
						'users'=>array('@'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('Index','sla', 'cumplimientoslaporclienteajax'),
						'users'=>array('@'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('Index','sla', 'issuesactivosporcliente'),
						'users'=>array('@'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('generarsemanal','borrarsemanal','generarmensual','borrarmensual','admin'),
						'expression'=>'Yii::app()->user->isAdmin()',
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
		$percepcionSM = Dashboard::getPercepcionSM($usuario->id);
		$percepcionCliente = Dashboard::getPercepcionCliente($usuario->id);
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
		$fechas = Dashboard::getFechas($usuario->id);
		$this->render('sla', array(
			'fechas'=>$fechas,
		));
	}
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