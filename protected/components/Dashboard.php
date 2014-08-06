<?php
class Dashboard {

	/**
	 * Método de generación de dropdown de estudios
	 *
	 * @return Array array con la estructura del dropdown.
	 */

	//FUNCIONES DEL DASHBOARD EN /SITE/INDEX.PHP - INICIO

	public static function getCumplimientoSla($userid, $fecha = null){
		
		if(!$fecha)$fecha=date('YW');
		
		$seguimientos_sla = Yii::app()->db->createCommand(" SELECT ss.id, ss.sla_id, ss.valor, ss.fecha
												FROM seguimiento_sla ss, sla s, contrato c, cliente cl  
												WHERE 	c.cliente_id = cl.id AND 
														cl.usuario_id = $userid AND 
														s.contrato_id = c.id AND
														ss.sla_id = s.id AND
														ss.fecha = $fecha
														GROUP BY s.id;")->queryAll();
		$valor = array();
		foreach ($seguimientos_sla as $s_sla){
			$valor[] = $s_sla['valor'];
		}
		return count($valor)!=0?array_sum($valor)/count($valor):0;
		
	}

	public static function getClientesSinIssuesActivos($userid, $fecha = null){

		if(!$fecha)$fecha=date('YW');
		
		$clientes = Cliente::model()->findAllByAttributes(array("usuario_id"=>$userid));
		$totalClientes =  Cliente::model()->countByAttributes(array("usuario_id"=>$userid));

		$clientesConIssues = 0;
		foreach ($clientes as $cliente){
		$issuesActivos =  Issue::model()->countByAttributes(array("cliente_id"=>$cliente->id, 'solucionado'=> 1 ));
			if($issuesActivos>0)
				$clientesConIssues++;
		}
		
		if ($totalClientes!=0){
			$porcentajeSinIssues = 100*($totalClientes-$clientesConIssues)/$totalClientes;
		}
		else $porcentajeSinIssues = 0;
		return $porcentajeSinIssues;

	}

	public static function getPercepcionSM($userid, $fecha = null){

		if(!$fecha)$fecha=date('YW');

		$seguimientoPercepciones = Yii::app()->db->createCommand("SELECT sp.id, sp.linea_servicio_contrato_id, sp.per_cliente, sp.per_sm, sp.fecha, sp.tipo_seguimiento
																  FROM cliente cl, contrato c, linea_servicio_contrato lsc, seguimiento_percepcion sp
																  WHERE $userid = cl.usuario_id
																  AND cl.id = c.cliente_id
																  AND c.id = lsc.contrato_id
																  AND lsc.id = sp.linea_servicio_contrato_id
																  GROUP BY lsc.id;")->queryAll();
		$totalPercepciones = 0;
		$percepcionManager = 0;
		foreach($seguimientoPercepciones as $seguimientoPercepcion){
			$totalPercepciones++;
			if ($seguimientoPercepcion['per_sm']>=4){
				$percepcionManager ++;
			}
		}
		if ($totalPercepciones!=0){
			$totalPerManager = $percepcionManager/$totalPercepciones*100;
		}else{
			return 0;
		}
		
		return $totalPerManager;
	}

	public static function getPercepcionCliente($userid, $fecha = null){

		if(!$fecha)$fecha=date('YW');

		$seguimientoPercepciones = Yii::app()->db->createCommand("SELECT sp.id, sp.linea_servicio_contrato_id, sp.per_cliente, sp.per_sm, sp.fecha, sp.tipo_seguimiento
																  FROM cliente cl, contrato c, linea_servicio_contrato lsc, seguimiento_percepcion sp
																  WHERE $userid = cl.usuario_id
																  AND cl.id = c.cliente_id
																  AND c.id = lsc.contrato_id
																  AND lsc.id = sp.linea_servicio_contrato_id
																  GROUP BY lsc.id;")->queryAll();
		$totalPercepciones = 0;
		$percepcionCliente = 0;
		foreach($seguimientoPercepciones as $seguimientoPercepcion){
			$totalPercepciones++;
			if ($seguimientoPercepcion['per_cliente']>=4){
				$percepcionCliente ++;
			}
		}
		if ($totalPercepciones!=0){
			$totalPerCliente = $percepcionCliente/$totalPercepciones*100;
		}else{
			return 0;
		}
		
		return $totalPerCliente;
	}

	//FUNCIONES DEL DASHBOARD EN /SITE/INDEX.PHP - FIN

	//FUNCIONES DEL DASHBOARD DE CADA PÁGINA - INICIO

	public static function getCumplimientoSlaPorCliente($userid, $fecha = null){
		
		if(!$fecha)$fecha=date('YW');
		
		$seguimientos_sla = Yii::app()->db->createCommand(" SELECT ss.id, ss.sla_id, ss.valor, ss.fecha, cl.nombre
												FROM seguimiento_sla ss, sla s, contrato c, cliente cl  
												WHERE 	c.cliente_id = cl.id AND 
														cl.usuario_id = $userid AND 
														s.contrato_id = c.id AND
														ss.sla_id = s.id AND
														ss.fecha = $fecha
														GROUP BY cl.id;")->queryAll();
		$clientes = array();
		foreach ($seguimientos_sla as $s_sla){
			//die(print_r($seguimientos_sla));
			if (!isset($clientes[$s_sla['nombre']]['total'])) $clientes[$s_sla['nombre']]['total'] = 0;
			if (!isset($clientes[$s_sla['nombre']]['cumplido'])) $clientes[$s_sla['nombre']]['cumplido'] = 0;
			$clientes[$s_sla['nombre']]['total']++;
			$clientes[$s_sla['nombre']]['cumplido'] += $s_sla['valor'];
		}
		$clientesValor = array();
		foreach ($clientes as $k=>$c){
			$valor = $c['cumplido']/($c['total']);
			$clientesValor[] = array($k,$valor);
		}
		return $clientesValor;
	}

	
	public static function getFechas($userid){
		
		return array("201432","201431", "201430","201429", "201428");
		
	}
	
}