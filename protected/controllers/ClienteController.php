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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'estado', 'misclientes','seguimiento','updatesm'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view', 'create','delete'),
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
		$competidores = array_keys(CHtml::listData($model->competidores, 'nombre' , 'id'));
		$this->render('view',array(
			'model'=>$model,
			'competidores'=>$competidores,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionEstado($id = null)
	{
		$model=new Cliente;
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
	
		$clientes = $usuario->getClientes();
		$nombres = CHtml::listData($clientes, 'id', 'nombre');
		
		if($id){
			$cliente = Cliente::model()->findByPk($id);
		}else{
			$cliente = Cliente::model()->findByAttributes(array("usuario_id"=>$usuario->id));
		}
		if(!$cliente){
			$this->redirect(array('misclientes'));
		}
		
		$seguimiento = new SeguimientoController($this->id);
		$seguimientoitil = $seguimiento->getUltimoItil($cliente->id);
		$seguimientosla = $seguimiento->getUltimoSla($cliente->id);
		$seguimientopercepcion = $seguimiento->getUltimoPercepcion($cliente->id);	
		
		

		
		if(!$fechapercepcion = Dashboard::getFechaUltima($usuario->id))
			$fechapercepcion = "No hay data";
		
		if(!$fechaitil = Dashboard::getFechaUltimaMensual($usuario->id))
			$fechaitil = "No hay data";
		
		$resumen_array = array();
		if($seguimientopercepciondata = $seguimientopercepcion->getData()){
			$fechapercepcion = $seguimientopercepciondata[0]["fecha"];
			$seguimientopercepcionGeneral = SeguimientoPercepcionGeneral::model()->find("cliente_id = $cliente->id AND fecha = $fechapercepcion ");
			$per_general_cliente = $seguimientopercepcionGeneral->per_cliente;
			$per_general_sm = $seguimientopercepcionGeneral->per_sm;
		
			$resumen_array = array(
					array("id"=>1, "nombre"=>"Percepción Cliente", "valor"=>$per_general_cliente), 
					array("id"=>2, "nombre"=>"Percepcion SM", "valor"=>$per_general_sm),
					array("id"=>3, "nombre"=>"Cumplimiento SLA", "valor"=>round(Dashboard::getCumplimientoSlaClienteID($cliente->id, $fechaitil), 2)."%"),
					array("id"=>4, "nombre"=>"Issues Activos", "valor"=>Issue::model()->countByAttributes(array("cliente_id"=>$cliente->id, "solucionado"=>1)))
			);
			
		}
		
		
		
		
		$resumen = new CArrayDataProvider($resumen_array, array(
				'id'=>'id',
				'pagination'=>array(
						'pageSize'=>100,
				),
		));
		
		$issues = new CActiveDataProvider('Issue', array(
				'criteria'=>array(
						'condition'=>"cliente_id=$cliente->id",
				),
				'pagination'=>array(
						'pageSize'=>100,
				),
		));
		//$cumplimientosla = Dashboard::getCumplimientoSla($userid)
		
		$this->render('estado',array(
				'model'=>$model,
				'nombres'=>$nombres,
				'clientes'=>$clientes,
				'cliente'=>$cliente,
				'seguimientoitil'=>$seguimientoitil,
				'seguimientosla' =>$seguimientosla,
				'seguimientopercepcion' => $seguimientopercepcion,
				'issues'=>$issues,
				'resumen'=>$resumen,
				'fechapercepcion' => $fechapercepcion,
				'fechaitil'=> $fechaitil,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Cliente;
		$competidores = CHtml::listData(Competidor::model()->findAll(), 'id', 'nombre');
		
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
			if($model->save()){
				if(isset($_POST['competidores'])){
					$model->competidor =$_POST['competidores'];
					foreach ($model->competidor as $competidor){
						$clientecompetidor = new ClienteCompetidor();
						$clientecompetidor->cliente_id = $model->id;
						$clientecompetidor->competidor_id = $competidor;
						$clientecompetidor->save();
					}
				}
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'usuarios'=>$selectusuario,
			'competidores'=>$competidores,
		));
	}
	
	public function actionUpdateSm($id)
	{
		$model=$this->loadModel($id);
		$competidores = CHtml::listData(Competidor::model()->findAll(), 'id', 'nombre');
		$selected_keys = array_keys(CHtml::listData($model->competidores, 'id' , 'id'));
		$usuario_id = $model->usuario_id;
		
		if(isset($_POST['Cliente']))
		{
			$model->attributes=$_POST['Cliente'];
			if(!$model->usuario_id){
				$model->usuario_id = $usuario_id;
			}
			if($model->save()){
				ClienteCompetidor::model()->deleteAll("cliente_id = $model->id");
				if(isset($_POST['competidores'])){
					$model->competidor=$_POST['competidores'];
					foreach ($model->competidor as $competidor){
						$clientecompetidor = new ClienteCompetidor();
						$clientecompetidor->cliente_id = $model->id;
						$clientecompetidor->competidor_id = $competidor;
						$clientecompetidor->save();
					}
				}
				$this->redirect(array('cliente/misclientes'));
			}
		}
		
		$this->render('updatesm',array(
				'model'=>$model,
				'competidores'=>$competidores,
				'selected_keys' => $selected_keys,
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
		

		$competidores = CHtml::listData(Competidor::model()->findAll(), 'id', 'nombre');
	
		$selected_keys = array_keys(CHtml::listData($model->competidores, 'id' , 'id'));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cliente']))
		{
			$model->attributes=$_POST['Cliente'];
			if($model->save())
				ClienteCompetidor::model()->deleteAll("cliente_id = $model->id");
				if(isset($_POST['competidores'])){
					$model->competidor=$_POST['competidores'];
					foreach ($model->competidor as $competidor){
						$clientecompetidor = new ClienteCompetidor();
						$clientecompetidor->cliente_id = $model->id;
						$clientecompetidor->competidor_id = $competidor;
						$clientecompetidor->save();
					}
				}
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
			'usuarios'=>$selectusuario,
			'competidores'=>$competidores,
			'selected_keys' => $selected_keys,
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
		$usuario =  Usuario::model()->findByPk(Yii::app()->user->id);
		
		$clientes = $usuario->getClientes();//
		//$clientes = Cliente::model()->findAll("usuario_id=". Yii::app()->user->id);
		$arraycliente = array();
		foreach ($clientes as $cliente){
			$arraycliente[]= array('id'=>$cliente->id, 'cliente'=>$cliente->nombre);
		}
		$dataProvider = new CArrayDataProvider($arraycliente , array(
				'id'=>'id',
				'pagination'=>array(
						'pageSize'=>500,
				),
		));
		
		$this->render('misclientes',array(
				'dataProvider'=>$dataProvider,
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
