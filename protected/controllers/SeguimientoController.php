<?php

class SeguimientoController extends Controller
{
	public function actionCreate($id)
	{
		$cliente = Cliente::model()->findByPk($id);
		$fecha = date('YW');
		$contratos = $cliente->contratos;
		
		$serviciosRawData = Yii::app()->db->createCommand("select ls.* from linea_servicio ls, linea_servicio_contrato lsc, contrato c where c.cliente_id = $cliente->id AND lsc.contrato_id = c.id AND ls.id = lsc.linea_servicio_id GROUP BY ls.id;")->queryAll();
		
		$lineaservicios=new CArrayDataProvider($serviciosRawData, array(
		    'id'=>'id',
		    'pagination'=>array(
		        'pageSize'=>100,
		    ),
		));
		$itil = new SeguimientoItil();
		$itil->attributeLabels();
		$arrayitil = array();
		$i = 1;
		foreach ($itil->attributeLabels() as $j=>$ia){
			$arrayitil[] = array('id'=>(string)($i++),'nombre'=> $ia, 'column'=>$j);
		}
		//die(var_dump($arrayitil[(1-1)]['column']));
		
		$seguimientoItil =new CArrayDataProvider($arrayitil, array(
				'id'=>'id',
				'pagination'=>array(
						'pageSize'=>100,
				),
		));
	
		$slasRawData = Yii::app()->db->createCommand("select s.id, s.nombre, s.objetivo, s.descripcion, s.contrato_id from sla s, contrato c  where c.cliente_id = $cliente->id AND s.contrato_id = c.id group by s.id;")->queryAll();
		
		$sla=new CArrayDataProvider($slasRawData, array(
				'id'=>'id',
				'pagination'=>array(
						'pageSize'=>100,
				),
		));
		
		if(isset($_POST['per_cliente'])){
			$per_cliente = $_POST['per_cliente'];
			$per_sm = $_POST['per_sm'];
			$seg_itil = $_POST['itil'];
			$seg_sla = $_POST['sla'];
			//foreach ($per_cliente as $i=>$pc){
				$serviciocontrato = Yii::app()->db->createCommand("select lsc.id, lsc.linea_servicio_id, lsc.contrato_id from linea_servicio_contrato lsc, contrato c Where c.cliente_id = $cliente->id AND lsc.contrato_id = c.id group by lsc.id; ")->queryAll(); 
				foreach ($serviciocontrato as $sc){
					$seguimientoPercepcion = new SeguimientoPercepcion();
					$seguimientoPercepcion->linea_servicio_contrato_id = $sc['id'];
					$seguimientoPercepcion->per_cliente = $per_cliente[$sc['linea_servicio_id']];
					$seguimientoPercepcion->per_sm = $per_sm[$sc['linea_servicio_id']];
					$seguimientoPercepcion->fecha = $fecha;
					$seguimientoPercepcion->tipo_seguimiento = 0;
					$seguimientoPercepcion->save();
				}
			//}
			
				foreach ($seg_sla as $h=>$ss){
					$seguimientoSla = new SeguimientoSla();
					$seguimientoSla->sla_id = $h;
					$seguimientoSla->valor = $ss;
					$seguimientoSla->fecha = $fecha;
					$seguimientoSla->tipo_seguimiento = 0;
					$seguimientoSla->save();
				}
				
				$seguimientoI = new SeguimientoItil();
				$seguimientoI->cliente_id = $cliente->id;
				$seguimientoI->fecha = $fecha;
				foreach ($seg_itil as $g=>$si){
					$seguimientoI->{$arrayitil[($g-1)]['column']}= $si;
					
				}
				$seguimientoI->save();
				$this->redirect(array('seguimiento/index','id'=>$cliente->id));
				
		}
	
		$this->render('create', array(
				'cliente'=>$cliente, 
				'fecha'=>$fecha,
				'lineaservicios'=> $lineaservicios,
				'seguimientoItil'=> $seguimientoItil,
				'sla'=>$sla,
		));
	}

	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionHistorico($id)
	{
		$cliente = Cliente::model()->findByPk($id);
		$this->render('historico',array(
				'cliente'=>$cliente, 
		));
		
	}

	public function actionIndex($id)
	{
		$cliente = Cliente::model()->findByPk($id);
		$fecha = date('YW');
		$seguimiento = false;
		if($seguimientoitil = SeguimientoItil::model()->findAll("cliente_id = $cliente->id AND fecha = $fecha")){
			$seguimiento = true;
			Yii::app()->user->setFlash('success', '<strong>Seguimiento semanal ha sido generado</strong> Puedes editarlo durante la semana.');
		}else{
			Yii::app()->user->setFlash('warning', '<strong>Seguimiento semanal no ha sido generado</strong> Puedes generarlo tu!.');
		}
		
		
		$this->render('index', array('cliente'=>$cliente,'seguimiento'=>$seguimiento));
	}

	public function actionUpdate($id)
	{
		$cliente = Cliente::model()->findByPk($id);
		$this->render('update',array(
				'cliente'=>$cliente,
		));
	}

	public function actionView()
	{
		$this->render('view');
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
}