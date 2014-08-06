<?php

class ContratoController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','index','view'),
				'users'=>array('@'),
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
		$lineaservicios = array_keys(CHtml::listData($model->lineaServicios, 'nombre' , 'id'));		
		$slas=new CActiveDataProvider('Sla', array(
				'criteria'=>array(
						'condition'=>"contrato_id=$id",
				),
				'pagination'=>array(
						'pageSize'=>100,
				),
		));
		
		$cliente = $model->cliente;
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'cliente'=>$cliente,
			'lineaservicios' => $lineaservicios,
			'slas'=>$slas,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new Contrato;
		$lineaservicios = CHtml::listData(LineaServicio::model()->findAll(), 'id', 'nombre');
		
		$cliente = Cliente::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Contrato']))
		{
			$model->attributes=$_POST['Contrato'];
			
			$model->cliente_id = $cliente->id;
			if($model->save()){
				if(isset($_POST['lineaservicios'])){
					$model->lineaservicios=$_POST['lineaservicios'];
					foreach ($model->lineaservicios as $servicio){
						$serviciocontrato = new LineaServicioContrato();
						$serviciocontrato->contrato_id = $model->id;
						$serviciocontrato->linea_servicio_id = $servicio;
						$serviciocontrato->save();
					}
				}
				
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'cliente'=>$cliente,
			'lineaservicios'=>$lineaservicios,
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
		$model->lineaServicios;
		
		$lineaservicios = CHtml::listData(LineaServicio::model()->findAll(), 'id', 'nombre');
		
		$selected_keys = array_keys(CHtml::listData($model->lineaServicios, 'id' , 'id'));

		$cliente = $model->cliente;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Contrato']))
		{
			$model->attributes=$_POST['Contrato'];
			if($model->save()){
				LineaServicioContrato::model()->deleteAll("contrato_id = $model->id");
				if(isset($_POST['lineaservicios'])){
					$model->lineaservicios=$_POST['lineaservicios'];
					foreach ($model->lineaservicios as $servicio){
						$serviciocontrato = new LineaServicioContrato();
						$serviciocontrato->contrato_id = $model->id;
						$serviciocontrato->linea_servicio_id = $servicio;
						$serviciocontrato->save();
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'cliente'=>$cliente,
			'lineaservicios'=>$lineaservicios,
			'selected_keys'=>$selected_keys,
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
		$dataProvider=new CActiveDataProvider('Contrato', array(
				'criteria'=>array(
						'condition'=>"cliente_id=$id",
				),
				'countCriteria'=>array(
						'condition'=>"cliente_id=$id",
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


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Contrato the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Contrato::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Contrato $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contrato-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
