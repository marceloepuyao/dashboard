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
						'actions'=>array('Index','sla','issues','percepcionHistoricoClienteServiciosTotalAjax','percepcionHistoricoClienteServiciosAjax', 'cumplimientoslaajax','cumplimientoDetalleClienteAjax', 'persm', 'PercepcionSMAjax','PercepcionSMporClienteAjax' ,'percl', 'PercepcionClienteAjax','PercepcionClientePorClienteAjax','issuesCliente', 'issuesactivosporcliente', 'IssuesActivosPorServicio'),
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
		$clientes = CHtml::listData($usuario->getClientes(), "id", "nombre");
		
		$cumplimientoSlaPorCliente = Dashboard::getCumplimientoSlaPorCliente($usuario->id);		
		$cumplimientoSlaHistorico = Dashboard::getCumplimientoSlaHistorico($usuario->id);
		//por defecto el primer cliente
		$keys_clientes = array_keys($clientes);
		$cumplimientoDetallePorCliente = Dashboard::getCumplimientoDetallePorCliente($keys_clientes[0]);
		$cumplimientoHistoricoDetallePorCliente = Dashboard::getCumplimientoHistoricoDetallePorCliente($keys_clientes[0]); //41)
		$data2 = array();
		foreach ($cumplimientoHistoricoDetallePorCliente as $k => $v){
			array_push($data2, array("name"=> $k, "data"=>$v));
		}
		if(!$data2){
			$data2 = array(array("name"=> "no data", "data"=> array(0)));
		}
		//die(var_dump($data2));
		
		$cumplimientoSlaHistoricoPorCliente = Dashboard::getCumplimientoSlaHistoricoPorCliente($usuario->id);
		$data = array();
		foreach ($cumplimientoSlaHistoricoPorCliente as $k => $v){
			array_push($data, array("name"=> $k, "data"=>$v));
		}	
		if(!$data){
			$data = array(array("name"=> "no data", "data"=> array(0)));
		}	
		$fechas = Dashboard::getFechasMensual($usuario->id);
		$fechasarray=array();
		foreach ($fechas as $fecha){
			array_push($fechasarray, $fecha["fecha"]);
		}
		
		function objetivo($n)
		{
			return $n["objetivo"];
		}
		$objetivo = array_map("objetivo", $cumplimientoDetallePorCliente);
		
		function valor($n)
		{
			return $n["valor"];
		}
		$valor = array_map("valor", $cumplimientoDetallePorCliente);
		
		$this->render('sla', array(
			'fechas'=>$fechasarray,
			'clientes'=>$clientes,
			'cumplimientoSlaPorCliente'=> $cumplimientoSlaPorCliente,
			'cumplimientoDetallePorCliente'=> $cumplimientoDetallePorCliente,
			'cumplimientoDetalleObjetivo' => $objetivo,
			'cumplimientoDetalleValor' => $valor,
			'cumplimientoSlaHistoricoPorCliente'=>json_encode($data),
			'cumplimientoSlaHistorico'=>$cumplimientoSlaHistorico,
			'cumplimientoSlaDetalleHistorico'=> json_encode($data2),
		));
	}


	public function actionPersm()
	{
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$persmgeneralhistorica = Dashboard::getPercepcionGeneralHistoricaSM($usuario->id);
		$percepcionGeneralHistoricaUsuario = Dashboard::getPercepcionGeneralHistoricaUsuarioSM($usuario->id);
		$satisfaccionsm = Dashboard::getSatisfaccionGeneralSM($usuario->id);
		$percepcionsmservicio = Dashboard::getPercepcionSMporServicio($usuario->id);
		$percepcionHistoricoSerivciosTotalClientes = Dashboard::getPercepcionHistoricoServiciosTotalClientes($usuario->id, 'externo');


		$data4 = array();
		foreach ($percepcionHistoricoSerivciosTotalClientes as $k => $v){
			array_push($data4, array("name"=> $k, "data"=>array_values($v)));
		}
		if(!$data4){
			$data4 = array(array("name"=> "no data", "data"=> array(0)));
		}
		

		$clientes = CHtml::listData($usuario->getClientes(), "id", "nombre");
		$arrayKeys = array_keys($clientes);
		
		$cumplimientoDetallePorCliente = Dashboard::getPercepcionSmHistoricaPorServicio($arrayKeys[0], "sm");
		$data3 = array();
		foreach ($cumplimientoDetallePorCliente as $k => $v){
			array_push($data3, array("name"=> $k, "data"=>array_values($v)));
		}
		if(!$data3){
			$data3 = array(array("name"=> "no data", "data"=> array(0)));
		}
		
		$data = array();
		foreach ($persmgeneralhistorica as $k => $v){
			array_push($data, array("name"=> $k, "data"=>$v));
		}
		$data2 = array();
		foreach ($percepcionGeneralHistoricaUsuario as $k => $v){
			array_push($data2, array("name"=> $k, "data"=>$v));
		}
		$fechas = Dashboard::getFechas($usuario->id);
		$fechasarray=array();
		foreach ($fechas as $fecha){
			array_push($fechasarray, $fecha["fecha"]);
		}
		$this->render('persm', array(
			'fechas'=>$fechasarray,
			'clientes'=>$clientes,
			'persmgeneralhistorica'=>json_encode($data),
			'pergeneralhistoricausuario'=>json_encode($data2),
				
			'cumplimientoDetallePorCliente'=>json_encode($data3),
			'satisfaccionsm'=> $satisfaccionsm,
			'percepcionsmservicio'=> $percepcionsmservicio,
			'percepcionhistoricoserviciostotal'=>json_encode($data4),
		));
	}

	public function actionPercl()
	{
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$clientes = CHtml::listData($usuario->getClientes(), "id", "nombre");
		$arrayKeys = array_keys($clientes);
		
		$perclgeneralhistorica = Dashboard::getPercepcionGeneralHistoricaCliente($usuario->id);
		$percepcionGeneralHistoricaUsuario = Dashboard::getPercepcionGeneralHistoricaUsuario($usuario->id);
		$satisfaccioncliente = Dashboard::getSatisfaccionGeneralCliente($usuario->id);
		$percepcionclienteservicio = Dashboard::getPercepcionClienteporServicio($usuario->id);
		//$percepcionHistoricoClienteServicios = Dashboard::getCumplimientoDetallePorCliente($clienteid);
		$percepcionHistoricoSerivciosTotalClientesExterna = Dashboard::getPercepcionHistoricoServiciosTotalClientes($usuario->id, 'externo');
		$data4 = array();
		foreach ($percepcionHistoricoSerivciosTotalClientesExterna as $k => $v){
			array_push($data4, array("name"=> $k, "data"=>array_values($v)));
		}
		if(!$data4){
			$data4 = array(array("name"=> "no data", "data"=> array(0)));
		}

		$cumplimientoDetallePorCliente = Dashboard::getPercepcionSmHistoricaPorServicio($arrayKeys[0], "cl");
		$data3 = array();
		foreach ($cumplimientoDetallePorCliente as $k => $v){
			array_push($data3, array("name"=> $k, "data"=>array_values($v)));
		}
		if(!$data3){
			$data3 = array(array("name"=> "no data", "data"=> array(0)));
		}
	
		
		
		$data = array();
		foreach ($perclgeneralhistorica as $k => $v){
			array_push($data, array("name"=> $k, "data"=>$v));
		}
		if(!$data){
			$data = array(array("name"=> "no data", "data"=> array(0)));
		}
		//die(print_r($data));
		$data2 = array();
		foreach ($percepcionGeneralHistoricaUsuario as $k => $v){
			array_push($data2, array("name"=> $k, "data"=>$v));
		}
		if(!$data2){
			$data2 = array(array("name"=> "no data", "data"=> array(0)));
		}

		$fechas = Dashboard::getFechas($usuario->id);
		$fechasarray=array();
		foreach ($fechas as $fecha){
			array_push($fechasarray, $fecha["fecha"]);
		}
		//die(var_dump($data3));
		$this->render('percl', array(
			'fechas'=>$fechasarray,
			'clientes'=>$clientes,
			'perclgeneralhistorica'=>json_encode($data),
			'pergeneralhistoricausuario'=>json_encode($data2),
			'cumplimientoDetallePorCliente'=>$data3,
			'satisfaccioncliente'=> $satisfaccioncliente,
			'percepcionclienteservicio' => $percepcionclienteservicio,
			'percepcionhistoricatotalclientesexterna' => json_encode($data4),
		));
	}
	
	
	public function actionIssuesCliente(){
		if(Yii::app()->user->isGuest){
			$this->redirect($this->createUrl('login'));
		}
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		
		$fechas = Dashboard::getFechas($usuario->id);
		$fechasarray=array();
		foreach ($fechas as $fecha){
			array_push($fechasarray, $fecha["fecha"]);
		}
		
		//$porcentajeClientesSinIssues = Dashboard::getClientesSinIssuesActivos($usuario->id);
		$issuesClientesDetalle = Dashboard::getClientesConIssuesActivosPorCliente($usuario->id);
		$issuesServiciosDetalle = Dashboard::getIssuesActivosPorServicio($usuario->id);
		$issuesTotalesPorServicio = Dashboard::getIssuesTotalesPorServicio($usuario->id);
		
		$issuesHistoricosPorCliente = Dashboard::getIssuesActivosHistoricosPorCliente($usuario->id);
		$data = array();
		foreach ($issuesHistoricosPorCliente as $k => $v){
			array_push($data, array("name"=> $k, "data"=>$v));
		}
		//die(var_dump(json_encode($fechasarray)));
		
		$clientesSinIssuesHistorico = Dashboard::getClientesSinIssuesHistorico($usuario->id);
	
		//$a = Dashboard::getIssuesHistoricosPorClienteSegunServicio($usuario->id, 'Preventa');
		//no sé cómo iterar dentro del render, por lo que las queries por servicio se harán directamente en el php issuecliente.php
		$this->render('issuescliente',array(
				'fechas'=> $fechasarray,
				//'porcentajeClientesSinIssues'=>$porcentajeClientesSinIssues,
				'issuesClientesDetalle'=>$issuesClientesDetalle,
				'issuesServiciosDetalle'=>$issuesServiciosDetalle,
				'issuesTotalesPorServicio'=>$issuesTotalesPorServicio,
				'clientesSinIssuesHistorico'=> $clientesSinIssuesHistorico,
				'issuesHistoricosPorCliente'=> json_encode($data),
		));
	
	}
	public function actionIssues($cliente){
		
		$cliente = Cliente::model()->find("nombre = '$cliente'");
		
		//$issues = Issue::model()->findAll("cliente_id = $cliente->id AND solucionado = 1");
		
		//$query = count($issues)>0?"cliente_id IN (".implode(",",$issues).") AND solucionado = 1":"1 = 3 ";
		$query = "cliente_id = $cliente->id AND solucionado = 1";
		$issues=new CActiveDataProvider('Issue', array(
				'criteria'=>array(
						'condition'=>$query,
				),
				'pagination'=>array(
						'pageSize'=>20,
				),
		));
		
		$this->render('issues',array(
			"cliente"=> $cliente,
			"issues" => $issues,
		));
		
	}
	
	public function actionCumplimientoDetalleHistoricoClienteAjax($clienteid){
		
		$cumplimientoHistoricoDetallePorCliente = Dashboard::getCumplimientoHistoricoDetallePorCliente($clienteid);
		$data = array();
		foreach ($cumplimientoHistoricoDetallePorCliente as $k => $v){
			array_push($data, array("name"=> $k, "data"=>$v));
		}
		if(!$data){
			$data = array(array("name"=> "no data", "data"=> array(0)));
		}
		
		$this->renderPartial('_ajax', array(
				'data'=>json_encode($data),
		));
		
	}
	
	
	public function actionCumplimientoDetalleClienteAjax($fecha, $clienteid){

		$cumplimientoDetallePorCliente = Dashboard::getCumplimientoDetallePorCliente($clienteid);
		
		function objetivo($n)
		{
			return $n["objetivo"];
		}
		$objetivo = array_map("objetivo", $cumplimientoDetallePorCliente);
		
		function valor($n)
		{
			return $n["valor"];
		}
		$valor = array_map("valor", $cumplimientoDetallePorCliente);
		
		$data = array("categories"=>array_keys($cumplimientoDetallePorCliente), "objetivo"=>array_values($objetivo), "valor" => array_values($valor));
		$this->renderPartial('_ajax', array(
				'data'=>json_encode($data),
		));
	}

	public function actionPercepcionHistoricoClienteServiciosAjax($clienteid, $type){

		$cumplimientoDetallePorCliente = Dashboard::getPercepcionSmHistoricaPorServicio($clienteid, $type);
		$data = array();
		foreach ($cumplimientoDetallePorCliente as $k => $v){
			array_push($data, array("name"=> $k, "data"=>array_values($v)));
		}		
		if(!$data){
			$data = array(array("name"=> "no data", "data"=> array(0)));
		}
		
		
		$this->renderPartial('_ajax', array(
				'data'=>json_encode($data),
		));
	}

	public function actionPercepcionHistoricoClienteServiciosTotalAjax($clienteid, $type){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);
		$cumplimientoDetallePorCliente = Dashboard::getPercepcionSmHistoricaPorServicio($clienteid, $type);
		
		$percepcionFecha = array();
		foreach ($cumplimientoDetallePorCliente as $cdcs){
			foreach ($cdcs as $i=>$cdc){	
				if(isset($percepcionFecha[$i])){
					array_push($percepcionFecha[$i], $cdc);
				}else{
					$percepcionFecha[$i] = array($cdc);
				}
			}
		}
		$historico = array();
		foreach($percepcionFecha as $i=>$pf){
			$satisfaccionFecha = 0;
			foreach ($pf as $p){
				if($p>=4){
					$satisfaccionFecha++;
				}elseif($p<=2){
					$satisfaccionFecha--;
				}
			}
			$historico[$i] = $satisfaccionFecha>0?round(100*$satisfaccionFecha/count($pf), 2):0;
		}
		//die(var_dump($historico));
		
		$data = array(array("name"=>"Histórico", "data"=> array_values($historico)));
		$this->renderPartial('_ajax', array(
				'data'=>json_encode($data),
		));
	}


	/*

	
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