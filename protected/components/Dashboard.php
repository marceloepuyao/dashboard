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
		
		$seguimientos_sla = Yii::app()->db->createCommand(" SELECT ss.id, ss.sla_id, ss.valor, ss.fecha, cl.id as clid
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
																  AND sp.fecha = $fecha
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
																  AND sp.fecha = $fecha
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

	public static function getClientesSinIssuesActivosPorCliente($userid){
		
		
		$issuesActivosClientes = Yii::app()->db->createCommand(" SELECT cl.nombre, i.solucionado
																FROM issue i, cliente cl  
																WHERE 	i.cliente_id = cl.id AND 
																cl.usuario_id = $userid 
																;")->queryAll();
		//SE BUSCAN LOS ISSUES ACTIVOS POR CLIENTE !!!!
		$issuesActivosPorCliente = array();
		foreach ($issuesActivosClientes as $issues){
			if (!isset($issuesActivosPorCliente[$issues['nombre']]['total'])) $issuesActivosPorCliente[$issues['nombre']]['total'] = 0;
			if (!isset($issuesActivosPorCliente[$issues['nombre']]['solucionado'])) $issuesActivosPorCliente[$issues['nombre']]['solucionado'] = 0;
			$issuesActivosPorCliente[$issues['nombre']]['total']++;
			if ($issues['solucionado'] == 2) $issuesActivosPorCliente[$issues['nombre']]['solucionado']++;
		}
		$issuesClientesPorcentaje = array();
		foreach ($issuesActivosPorCliente as $k=>$i){
			$valor = round(100*$i['solucionado']/($i['total']));
			$issuesClientesPorcentaje[] = array($k, $valor);
		}
		return $issuesClientesPorcentaje;
	}

	public static function getClientesSinIssuesActivosPorServicio($userid){
		
		
		$issuesActivosClientes = Yii::app()->db->createCommand(" SELECT i.solucionado, ls.nombre
																FROM issue i, cliente cl, issue_linea_servicio ils, linea_servicio ls
																WHERE 	i.cliente_id = cl.id AND 
																cl.usuario_id = $userid AND
																ils.issue_id = i.id AND
																ils.linea_servicio_id = ls.id
																;")->queryAll();
		//SE BUSCAN LOS ISSUES ACTIVOS POR CLIENTE !!!!
		$issuesActivosPorServicio = array();
		foreach ($issuesActivosPorServicio as $issues){
			if (!isset($issuesActivosPorServicio[$issues['nombre']]['total'])) $issuesActivosPorServicio[$issues['nombre']]['total'] = 0;
			if (!isset($issuesActivosPorServicio[$issues['nombre']]['solucionado'])) $issuesActivosPorServicio[$issues['nombre']]['solucionado'] = 0;
			$issuesActivosPorServicio[$issues['nombre']]['total']++;
			if ($issues['solucionado'] == 2) $issuesActivosPorServicio[$issues['nombre']]['solucionado']++;
		}
		$issuesClientesPorcentaje = array();
		foreach ($issuesActivosPorServicio as $k=>$i){
			$valor = round(100*$i['solucionado']/($i['total']));
			$issuesClientesPorcentaje[] = array($k, $valor);
		}
		return $issuesClientesPorcentaje;
	}

	public static function getPercepcionSMporCliente($userid, $fecha = null){

		if(!$fecha)$fecha=date('YW');

		$seguimientoPercepcionesCliente = Yii::app()->db->createCommand("SELECT sp.per_sm, sp.fecha, cl.nombre, sp.id
																  FROM cliente cl, contrato c, linea_servicio_contrato lsc, seguimiento_percepcion sp
																  WHERE $userid = cl.usuario_id
																  AND cl.id = c.cliente_id
																  AND c.id = lsc.contrato_id
																  AND lsc.id = sp.linea_servicio_contrato_id
																  AND $fecha = sp.fecha
																  GROUP BY sp.id;")->queryAll();
		$percepcionesSM = array();
		foreach ($seguimientoPercepcionesCliente as $percepciones){
			if (!isset($percepcionesSM[$percepciones['nombre']]['total'])) $percepcionesSM[$percepciones['nombre']]['total'] = 0;
			if (!isset($percepcionesSM[$percepciones['nombre']]['per_sm'])) $percepcionesSM[$percepciones['nombre']]['per_sm'] = 0;
			$percepcionesSM[$percepciones['nombre']]['total']++;
			if ($percepciones['per_sm'] >= 4) $percepcionesSM[$percepciones['nombre']]['per_sm']++;
		}
		$percepcionesSMClientesPorcentaje = array();
		foreach ($percepcionesSM as $k=>$psm){
			$valor = round(100*$psm['per_sm']/($psm['total']));
			$percepcionesSMClientesPorcentaje[] = array($k, $valor);
		}
		return $percepcionesSMClientesPorcentaje;
	}

	public static function getPercepcionClientePorCliente($userid, $fecha = null){

		if(!$fecha)$fecha=date('YW');

		$seguimientoPercepciones = Yii::app()->db->createCommand("SELECT sp.id, sp.per_cliente, sp.fecha, cl.nombre
																  FROM cliente cl, contrato c, linea_servicio_contrato lsc, seguimiento_percepcion sp
																  WHERE $userid = cl.usuario_id
																  AND cl.id = c.cliente_id
																  AND c.id = lsc.contrato_id
																  AND lsc.id = sp.linea_servicio_contrato_id
																  AND sp.fecha = $fecha
																  GROUP BY sp.id;")->queryAll();
		$percepcionesClientes = array();
		foreach ($seguimientoPercepciones as $percepciones){
			if (!isset($percepcionesClientes[$percepciones['nombre']]['total'])) $percepcionesClientes[$percepciones['nombre']]['total'] = 0;
			if (!isset($percepcionesClientes[$percepciones['nombre']]['per_cliente'])) $percepcionesClientes[$percepciones['nombre']]['per_cliente'] = 0;
			$percepcionesClientes[$percepciones['nombre']]['total']++;
			if ($percepciones['per_cliente'] >= 4) $percepcionesClientes[$percepciones['nombre']]['per_cliente']++;
		}
		$percepcionesClientePorClientesPorcentaje = array();
		foreach ($percepcionesClientes as $k=>$psm){
			$valor = round(100*$psm['per_cliente']/($psm['total']));
			$percepcionesClientePorClientesPorcentaje[] = array($k, $valor);
		}
		return $percepcionesClientePorClientesPorcentaje;
	}


	public static function getFechas($userid){
		$seguimientoSemanal = Yii::app()->db->createCommand("SELECT sp.fecha
				FROM seguimiento_percepcion sp, linea_servicio ls, linea_servicio_contrato lsc, contrato c, cliente cl
				WHERE lsc.id = sp.linea_servicio_contrato_id AND
				c.cliente_id = cl.id AND
				cl.usuario_id = $userid AND
				lsc.contrato_id = c.id AND
				ls.id = lsc.linea_servicio_id
				GROUP BY sp.fecha DESC limit 1;")->queryRow();
		return $seguimientoSemanal;
	}	
}