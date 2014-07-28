<?php

class ClienteController extends Controller
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
				'actions'=>array('create','update', 'estado','admin','delete', 'misclientes','seguimiento'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionEstado($id = null)
	{
		$model=new Cliente;
		$clientes = Cliente::model()->findAll();
		$nombres = array();
		foreach ($clientes as $cl){
			$nombres[] = $cl->nombre;
			$cliente = $cl;
		}
		if($id){
			$cliente = Cliente::model()->findAllByPk($id);
		}
		$this->render('estado',array(
				'model'=>$model,
				'nombres'=>$nombres,
				'clientes'=>$clientes,
				'cliente'=>$cliente,
				'seguimientoitil'=>$cliente->seguimientoitil,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Cliente;
		
		$usuarios = Usuario::model()->findAll();
		$selectusuario = array();
		foreach ($usuarios as $usuario){
			$selectusuario[$usuario->id] = $usuario->nombre." ".$usuario->apellido;	
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cliente']))
		{
			$model->attributes=$_POST['Cliente'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
			'usuarios'=>$selectusuario,
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
		$usuarios = Usuario::model()->findAll();
		$selectusuario = array();
		foreach ($usuarios as $usuario){
			$selectusuario[$usuario->id] = $usuario->nombre." ".$usuario->apellido;
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cliente']))
		{
			$model->attributes=$_POST['Cliente'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
			'usuarios'=>$selectusuario,
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
	
	public function actionSeguimiento($id)
	{
		$cliente = $this->loadModel($id);
		
		$contratos = $cliente->contratos;
		$ct = "(";
		foreach ($contratos as $contrato){
			$ct .= $contrato->id.",";
		}
		$ct .= "0)";
		
		$dataProvider=new CActiveDataProvider('Sla', array(
				'criteria'=>array(
						'condition'=>"contrato_id IN $ct",
				),
				'countCriteria'=>array(
						//'condition'=>'status=1',
						// 'order' and 'with' clauses have no meaning for the count query
				),
				'pagination'=>array(
						'pageSize'=>20,
				),
		));
		
		$itil = SeguimientoItil::model()->find("cliente_id=$cliente->id");
	
		$this->render('seguimiento',array(
				'sla'=>$dataProvider,
				'itil'=>$itil,

		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Cliente('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cliente']))
			$model->attributes=$_GET['Cliente'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionMisClientes()
	{
		$clientes = Cliente::model()->findAll("usuario_id=". Yii::app()->user->id);
		$dataProvider=new CActiveDataProvider('Cliente');
		$this->render('misclientes',array(
				'clientes'=>$clientes,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cliente the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cliente::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cliente $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cliente-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
