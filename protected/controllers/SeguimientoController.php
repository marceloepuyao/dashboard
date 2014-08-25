<?php

class SeguimientoController extends Controller
{
	public function accessRules()
	{
		return array(
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('Index','updatemensual', 'updatesemanal'),
						'users'=>array('@'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('generarsemanal','borrarsemanal','generarmensual','borrarmensual','admin','regenerarmensual','regenerarsemanal'),
						'expression'=>'Yii::app()->user->isAdmin()',
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	private static function generarSemanalGeneralCliente($clienteid, $fecha){
		$seguimientoPercepcionGeneral = new SeguimientoPercepcionGeneral();
		$seguimientoPercepcionGeneral->cliente_id = $clienteid;
		$seguimientoPercepcionGeneral->per_cliente = 0;
		$seguimientoPercepcionGeneral->per_sm = 0;
		$seguimientoPercepcionGeneral->fecha = $fecha;
		$seguimientoPercepcionGeneral->save();
	}
	
	private static function generarSemanalCliente($lineaserviciocontratoid, $fecha){
		$seguimientoPercepcion = new SeguimientoPercepcion();
		$seguimientoPercepcion->linea_servicio_contrato_id = $lineaserviciocontratoid;
		$seguimientoPercepcion->per_cliente = 0;
		$seguimientoPercepcion->per_sm = 0;
		$seguimientoPercepcion->fecha = $fecha;
		$seguimientoPercepcion->tipo_seguimiento = 0;
		$seguimientoPercepcion->save();
	}
	
	private static function generarItilCliente($clienteid, $fecha){
		$seguimientoItil = new SeguimientoItil();
		$seguimientoItil->attributes = array('cliente_id' => $clienteid, 'fecha'=>$fecha);
		$seguimientoItil->save();
		
	}
	private static function generarSlaCliente($slaid, $fecha){
		$seguimientoSla = new SeguimientoSla();
		$seguimientoSla->sla_id = $slaid;
		$seguimientoSla->valor = 0;
		$seguimientoSla->fecha = $fecha;
		$seguimientoSla->tipo_seguimiento = 0;
		$seguimientoSla->save();
		
	}
	
	public function actionGenerarSemanal()
	{
		$fecha = date('YW');
		$clientes = Cliente::model()->findAll();
		foreach ($clientes as $cliente){
			$this->generarSemanalGeneralCliente($cliente->id, $fecha);
			
			$serviciosRawData = Yii::app()->db->createCommand("select ls.nombre as nombre, lsc.id as linea_servicio_contrato_id from linea_servicio ls, linea_servicio_contrato lsc, contrato c where c.cliente_id = $cliente->id AND lsc.contrato_id = c.id AND ls.id = lsc.linea_servicio_id GROUP BY ls.id;")->queryAll();
			foreach ($serviciosRawData as $sc){
				$this->generarSemanalCliente($sc['linea_servicio_contrato_id'], $fecha);
			}
		}
		$this->redirect(array('seguimiento/admin'));
	}
	public function actionReGenerarSemanal()
	{
		$fecha = date('YW');
		$clientes = Cliente::model()->findAll();
		foreach ($clientes as $cliente){
			if(!$lineaservicios = $this->getUltimoPercepcion($cliente->id, $fecha)->getData()){
				$serviciosRawData = Yii::app()->db->createCommand("select ls.nombre as nombre, lsc.id as linea_servicio_contrato_id from linea_servicio ls, linea_servicio_contrato lsc, contrato c where c.cliente_id = $cliente->id AND lsc.contrato_id = c.id AND ls.id = lsc.linea_servicio_id GROUP BY ls.id;")->queryAll();
				foreach ($serviciosRawData as $sc){
					$this->generarSemanalCliente($sc['linea_servicio_contrato_id'], $fecha);
				}
			}
			
			if(!$percepcionGeneral =  $this->getUltimoPercepcionGeneral($cliente->id, $fecha)->getData()){
				$this->generarSemanalGeneralCliente($cliente->id, $fecha);
			}
		}
		$this->redirect(array('seguimiento/admin'));
		
	}

	public function actionBorrarSemanal($fecha)
	{
		SeguimientoPercepcion::model()->deleteAll("fecha = $fecha");
		SeguimientoPercepcionGeneral::model()->find("fecha = $fecha");
		$this->redirect(array('admin'));

	}
	
	
	
	public function actionGenerarMensual()
	{
		$fecha = date('YW');
		$clientes = Cliente::model()->findAll();
		foreach ($clientes as $cliente){
			$this->generarItilCliente($cliente->id, $fecha);
			
			$slasRawData = Yii::app()->db->createCommand("select s.id, s.nombre, s.objetivo, s.descripcion, s.contrato_id from sla s, contrato c  where c.cliente_id = $cliente->id AND s.contrato_id = c.id group by s.id;")->queryAll();
			foreach ($slasRawData as $sla){
				$this->generarSlaCliente($sla['id'], $fecha);	
			}
		}
		$this->redirect(array('seguimiento/admin'));
	}
	public function actionReGenerarMensual()
	{
		$fecha = date('YW');
		$clientes = Cliente::model()->findAll();
		foreach ($clientes as $cliente){
			if(!$sla=$this->getUltimoSla($cliente->id)->getData()){
				$slasRawData = Yii::app()->db->createCommand("select s.id, s.nombre, s.objetivo, s.descripcion, s.contrato_id from sla s, contrato c  where c.cliente_id = $cliente->id AND s.contrato_id = c.id group by s.id;")->queryAll();
				foreach ($slasRawData as $sla){
					$this->generarSlaCliente($sla['id'], $fecha);
				}
			}
			if(!$itil=$this->getUltimoItil($cliente->id)->getData()){
				$this->generarItilCliente($cliente->id, $fecha);
			}
			
		}
		$this->redirect(array('seguimiento/admin'));
	
	}
	
	public function actionBorrarMensual($fecha)
	{
		SeguimientoSla::model()->deleteAll("fecha = $fecha");
		SeguimientoItil::model()->deleteAll("fecha = $fecha");
		
		$this->redirect(array('admin'));
	}

	public function actionIndex($id)
	{
		$cliente = Cliente::model()->findByPk($id);
		$fecha = date('YW');

		$seguimientoSemanal = Yii::app()->db->createCommand("SELECT sp.fecha
															FROM seguimiento_percepcion sp, linea_servicio ls, linea_servicio_contrato lsc, contrato c 
															WHERE lsc.id = sp.linea_servicio_contrato_id AND 
																c.cliente_id = $cliente->id AND
																lsc.contrato_id = c.id AND
																ls.id = lsc.linea_servicio_id 
																GROUP BY sp.fecha DESC limit 1;")->queryRow();
		
		$seguimientoMensual = Yii::app()->db->createCommand("SELECT fecha FROM seguimiento_itil WHERE cliente_id = $cliente->id GROUP BY fecha DESC limit 1")->queryRow();
		
		
		
		
		if(!$seguimientoSemanal && !$seguimientoMensual){
			Yii::app()->user->setFlash('warning', '<strong>Seguimiento Semanal y Mensual no han sido generados</strong>  Por favor consulte al administrador');
		}else if(!$seguimientoSemanal){
			Yii::app()->user->setFlash('warning', '<strong>Seguimiento Semanal no ha sido generado</strong> Por favor consulte al administrador');
		}else if(!$seguimientoMensual){
			Yii::app()->user->setFlash('warning', '<strong>Seguimiento Mensual no ha sido generado</strong>  Por favor consulte al administrador');
		}

		$this->render('index', array('cliente'=>$cliente,'seguimientoSemanal'=>$seguimientoSemanal, 'seguimientoMensual'=>$seguimientoMensual));
	}

	public function actionUpdateSemanal($id)
	{
		$cliente = Cliente::model()->findByPk($id);
		

		$lineaservicios = $this->getUltimoPercepcion($cliente->id);
		
		$data = $lineaservicios->getData();
		$fecha= $data[0]["fecha"];
		
		$percepcionGeneral =  $this->getUltimoPercepcionGeneral($cliente->id);   
		
		if(isset($_POST['per_cliente'])){
			$per_cliente = $_POST['per_cliente'];
			$per_sm = $_POST['per_sm'];
			$per_general = $_POST['per_general'];

			
			foreach ($lineaservicios->rawData as $sc){
				$seguimientoPercepcion = SeguimientoPercepcion::model()->findByPk($sc['seguimiento_id']);
				$seguimientoPercepcion->linea_servicio_contrato_id = $sc['linea_servicio_contrato_id'];
				$seguimientoPercepcion->per_cliente = $per_cliente[$sc['linea_servicio_contrato_id']];
				$seguimientoPercepcion->per_sm = $per_sm[$sc['linea_servicio_contrato_id']];
				$seguimientoPercepcion->save();
			}
			$datapercepcionGeneral = $percepcionGeneral->getData();
			$seguimientoPercepcionGeneral = SeguimientoPercepcionGeneral::model()->findByPk($datapercepcionGeneral[0]['id']);
			$seguimientoPercepcionGeneral->per_sm = $per_general["per_sm"];
			$seguimientoPercepcionGeneral->per_cliente = $per_general["per_cliente"];
			$seguimientoPercepcionGeneral->save();
			
			$this->redirect(array('seguimiento/index','id'=>$cliente->id));
		}
	
		$this->render('updatesemanal',array(
				'cliente'=>$cliente, 
				'fecha'=>$fecha,
				'lineaservicios'=> $lineaservicios,
				'percepcionGeneral' => $percepcionGeneral,
		));
	}
	public function actionUpdateMensual($id)
	{
		$cliente = Cliente::model()->findByPk($id);
		
				
		$sla=$this->getUltimoSla($cliente->id);
		$itil = $this->getUltimoItil($cliente->id);
		$itilRawData = $this->getItilRawData($cliente->id);
		$fecha = $itilRawData["fecha"];
		
		if(isset($_POST['sla'])){
			$seg_sla = $_POST['sla'];
			foreach ($seg_sla as $h=>$ss){
				$seguimientoSla = SeguimientoSla::model()->findByPk($h);
				$seguimientoSla->valor = $ss;
				$seguimientoSla->save();
			}
			
		}
		if(isset($_POST['itil'])){
			$seg_itil = $_POST['itil'];
				
			$seguimientoI = SeguimientoItil::model()->findByPk($itilRawData['id']);
			foreach ($seg_itil as $g=>$si){
				$seguimientoI->{$itil->rawData[($g)]['column']}= $si;
			}
			$seguimientoI->save();
			$this->redirect(array('seguimiento/index','id'=>$cliente->id));
		}
		
			
		$this->render('updatemensual',array(
				'cliente'=>$cliente,
				'fecha'=>$fecha,
				'itil'=> $itil,
				'sla'=>$sla,
		));
		
	}
	
	public function actionAdmin()
	{
		$ssemanal = Yii::app()->db->createCommand("SELECT * FROM seguimiento_percepcion GROUP BY fecha;")->queryAll();
		$ssemanalData = new CArrayDataProvider($ssemanal, array(
				'id'=>'id',
				'pagination'=>array(
						'pageSize'=>10,
				),
		));
		
		$smensual = Yii::app()->db->createCommand("SELECT * FROM seguimiento_itil GROUP BY fecha;")->queryAll();
		$smensualData = new CArrayDataProvider($smensual, array(
				'id'=>'id',
				'pagination'=>array(
						'pageSize'=>10,
				),
		));
		$this->render('admin',array('ssemanalData'=> $ssemanalData, 'smensualData'=>$smensualData));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	public function getUltimoSla($clienteId, $fecha = null){
		$fechasql = "";
		if($fecha){
			$fechasql = "ss.fecha = $fecha AND";
		}
		$slasRawData = Yii::app()->db->createCommand("  SELECT s.id, s.nombre, s.objetivo, s.descripcion, s.contrato_id, ss.valor, ss.fecha, ss.id as seguimiento_sla_id
				FROM sla s, contrato c , seguimiento_sla ss
				JOIN ( SELECT MAX(ssla.fecha) AS max_fecha
				FROM seguimiento_sla ssla
				) m
				ON m.max_fecha = ss.fecha
				WHERE c.cliente_id = $clienteId AND
				s.contrato_id = c.id AND
				$fechasql
				ss.sla_id = s.id
				group by s.id")->queryAll();
		
				$sla=new CArrayDataProvider($slasRawData, array(
						'id'=>'id',
						'pagination'=>array(
								'pageSize'=>100,
						),
				));
				
				return $sla;
	}
	public function getUltimoItil($clienteId, $fecha = null){
		
		$itilRawData = $this->getItilRawData($clienteId, $fecha);
		if(!$itilRawData){
			$itil=new CArrayDataProvider(array(), array(
					'id'=>'id',
					'pagination'=>array(
							'pageSize'=>100,
					),
			));
			return $itil;
			
		}

		$labels = SeguimientoItil::model()->attributeLabels();
		$n = 0;
		foreach ($itilRawData as $i=>$dataitil){
			if(isset($labels[$i]))
				$vertical[] = array("id"=> (string)$n++, "nombre"=>$labels[$i], "valor"=>$dataitil, 'column'=>$i);
		}
		$itil=new CArrayDataProvider($vertical, array(
				'id'=>'id',
				'pagination'=>array(
						'pageSize'=>100,
				),
		));		
		return $itil;
	}
	public function getItilRawData($clienteId, $fecha = null){
		
		$fechasql = "";
		if($fecha){
			$fechasql = "AND fecha = $fecha";
		}
		
		return $itilRawData = Yii::app()->db->createCommand("  SELECT *
				FROM seguimiento_itil
				JOIN ( SELECT MAX(fecha) AS max_fecha
				FROM seguimiento_itil
				WHERE cliente_id = $clienteId
				) m
				ON m.max_fecha = fecha
				WHERE cliente_id = $clienteId  $fechasql")->queryRow();
	}
	
	public function getUltimoPercepcion($clienteId, $fecha = null){
		
		$fechasql = "";
		if($fecha){
			$fechasql = "sp.fecha = $fecha AND";
		}
		
		$serviciosRawData = Yii::app()->db->createCommand(" SELECT ls.id, ls.nombre, sp.per_cliente as per_cliente, sp.per_sm as per_sm , lsc.id as linea_servicio_contrato_id, sp.id as seguimiento_id, sp.fecha
															FROM  linea_servicio ls, linea_servicio_contrato lsc, contrato c, seguimiento_percepcion sp
															INNER JOIN (  SELECT MAX(ssp.fecha) AS max_fecha
																	FROM seguimiento_percepcion ssp, linea_servicio lss, linea_servicio_contrato lscc, contrato cc
																	WHERE lscc.id = ssp.linea_servicio_contrato_id AND 
																	cc.cliente_id = $clienteId AND 
																	lscc.contrato_id = cc.id AND 
																	lss.id = lscc.linea_servicio_id
															) m
															ON m.max_fecha = sp.fecha 
															WHERE lsc.id = sp.linea_servicio_contrato_id AND 
																$fechasql
																c.cliente_id = $clienteId AND 
																lsc.contrato_id = c.id AND 
																ls.id = lsc.linea_servicio_id
																GROUP BY ls.id;")->queryAll();
		//die(var_dump($serviciosRawData));
		$lineaservicios=new CArrayDataProvider($serviciosRawData, array(
				'id'=>'id',
				'pagination'=>array(
						'pageSize'=>100,
				),
		));
		return $lineaservicios;
	}
	public function getUltimoPercepcionGeneral($clienteId, $fecha = null){
		
		$fechasql = "ORDER BY fecha DESC Limit 1";
		if($fecha){
			$fechasql = "AND fecha = $fecha";
		}
		
		$percepcionGeneralRawData = Yii::app()->db->createCommand("
				SELECT id, cliente_id, per_sm, per_cliente, fecha  
				FROM seguimiento_percepcion_general 
				WHERE cliente_id = $clienteId $fechasql")->queryAll();
		
		$percepcionGeneral=new CArrayDataProvider($percepcionGeneralRawData, array(
				'id'=>'id',
				'pagination'=>array(
						'pageSize'=>100,
				),
		));

		return $percepcionGeneral;
		
	}
	
}