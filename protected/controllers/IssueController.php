<?php

class IssueController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'misissues'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'expression'=>'Yii::app()->user->isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$cliente = $model->cliente;
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'cliente'=>$cliente,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new Issue;
		
		$cliente = Cliente::model()->findByPk($id);
		$lineaserviciosmodel = LineaServicio::model()->findAll();
		$lineaservicios = array();
		foreach ($lineaserviciosmodel as $ls){
			$lineaservicios[$ls->id]=$ls->nombre;		
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Issue']))
		{
			$model->attributes=$_POST['Issue'];
			$model->cliente_id = $cliente->id;
			if($model->save())
				$this->redirect(array('index','id'=>$cliente->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'cliente'=>$cliente,
			'lineaservicios'=>$lineaservicios
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$cliente = $model->cliente;
		$lineaserviciosmodel = LineaServicio::model()->findAll();
		$lineaservicios = array();
		foreach ($lineaserviciosmodel as $ls){
			$lineaservicios[$ls->id]=$ls->nombre;		
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Issue']))
		{
			$model->attributes=$_POST['Issue'];
			$model->cliente_id = $cliente->id;
			if($model->save())
				$this->redirect(array('index','id'=>$cliente->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'cliente'=>$cliente,
			'lineaservicios'=>$lineaservicios,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{	
		$dataProvider=new CActiveDataProvider('Issue', array(
				'criteria'=>array(
						'condition'=>"cliente_id=$id",
				),
				'countCriteria'=>array(
						//'condition'=>'status=1',
						// 'order' and 'with' clauses have no meaning for the count query
				),
				'pagination'=>array(
						'pageSize'=>20,
				),
		));
		
		$cliente = Cliente::model()->findByPk($id);

		$this->render('index',array(
			'model'=>$dataProvider,
			'cliente'=>$cliente,
		));
	}
	
	public function actionMisIssues()
	{
		
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$clientes = $usuario->clientes;
		$issues = "(";
		foreach ($clientes as $cliente){
			$issues .= $cliente->id.",";
		}
		$issues .= "0)";
		//die(var_dump($issues));
			
		
		$dataProvider=new CActiveDataProvider('Issue', array(
				'criteria'=>array(
						'condition'=>"cliente_id IN $issues",
				),
				'countCriteria'=>array(
						//'condition'=>'status=1',
						// 'order' and 'with' clauses have no meaning for the count query
				),
				'pagination'=>array(
						'pageSize'=>20,
				),
		));
	
		$this->render('misissues',array(
				'model'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Issue the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Issue::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Issue $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='issue-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
