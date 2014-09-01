<?php
class Dashboard {

	///////////////////////////////SLA//////////////////////////////////////////////////////////////////////////////////
	
	public static function getCumplimientoSlaClienteID($clienteid, $fecha){
		$cumplimientocliente = Yii::app()->db->createCommand("
				SELECT ss.id, ss.valor, s.objetivo, IF(ss.valor >= s.objetivo, 1, 0) as cumplido
				FROM seguimiento_sla ss, sla s, contrato c
				WHERE s.contrato_id = c.id AND
				c.cliente_id = $clienteid AND
				ss.sla_id = s.id AND
				ss.fecha = $fecha
				GROUP BY s.id
				")->queryAll();
		
		
					
		$valor = array();
		foreach ($cumplimientocliente as $c_cliente){
			$valor[] = (int)$c_cliente['cumplido'];
		}
		$tasacumplimientocliente = count($valor)!=0?(100*array_sum($valor)/count($valor)):0;
		return $tasacumplimientocliente;
	}
	
	/**
	 * Funcion que calcula % de clientes tienen al menos el 75% de sus SLA cumplidos
	 * @param integer $userid
	 * @param string $fecha
	 * @return number
	 */
	public static function getCumplimientoSla($userid, $fecha = null){
		
		if(!$fecha)$fecha=Dashboard::getFechaUltimaMensual($userid);
		
		$usuario = Usuario::model()->findByPk($userid);
		
		$clientes = $usuario->getClientes();
		$cumplimientoSla = array();
		foreach ($clientes as $cliente){
			
			$tasacumplimientocliente = Dashboard::getCumplimientoSlaClienteID($cliente->id, $fecha);
			if($tasacumplimientocliente >= 75){
				$cumplimientoSla[] = 1;
			}else{
				$cumplimientoSla[] = 0;
			}
			
		}
		return count($cumplimientoSla)!=0?(100*array_sum($cumplimientoSla)/count($cumplimientoSla)):0;
		
	}
	
	public static function getCumplimientoSlaHistorico($userid){
		$fechas = Dashboard::getFechasMensual($userid);

		$usuario = Usuario::model()->findByPk($userid);

		$clientes = $usuario->getClientes();
		$cumplimientoSla = array();
		$historico;
		foreach ($fechas as $fecha){
			$cumplimientoPorFecha = array();
			foreach ($clientes as $cliente){
				$tasacumplimientocliente = Dashboard::getCumplimientoSlaClienteID($cliente->id, $fecha["fecha"]);
				$clienteid = $cliente->id;
				$fechaActual = $fecha["fecha"];
				$cumplimientocliente = Yii::app()->db->createCommand("
				SELECT ss.id, ss.valor, s.objetivo, IF(ss.valor >= s.objetivo, 1, 0) as cumplido
				FROM seguimiento_sla ss, sla s, contrato c
				WHERE s.contrato_id = c.id AND
				c.cliente_id = $clienteid AND
				ss.sla_id = s.id AND
				ss.fecha = $fechaActual
				GROUP BY s.id
				")->queryAll();
				$empty = array();
				if ($cumplimientocliente != $empty){ 
				//si el Sla no tiene seguimiento en la fecha señalada por no existir antes, entonces no afecta al cumplimiento histórico
					if($tasacumplimientocliente >= 70){
						$cumplimientoPorFecha[] = 1;
					}else{
						$cumplimientoPorFecha[] = 0;
					}
				}
			}
			$historico[] = count($cumplimientoPorFecha)!=0?(100*(array_sum($cumplimientoPorFecha)/(count($cumplimientoPorFecha)))):0;
		}
		$cumplimientoSla['historico'] = $historico;
		return $cumplimientoSla;
	}

	/** Lista por CLiente con info sobre quien tiene al menos el 75% de sus SLA cumplidos
	 * Cumpl
	 * @param unknown $userid
	 * @param string $fecha
	 * @return multitype:number
	 */
	public static function getCumplimientoSlaPorCliente($userid, $fecha = null){
	
		if(!$fecha)$fecha=Dashboard::getFechaUltimaMensual($userid);
	
		$usuario = Usuario::model()->findByPk($userid);
	
		$clientes = $usuario->getClientes();
		$cumplimientoSla = array();
		foreach ($clientes as $cliente){
				
			$tasacumplimientocliente = Dashboard::getCumplimientoSlaClienteID($cliente->id, $fecha);
			$cumplimientoSla[$cliente->nombre] = round($tasacumplimientocliente, 2);
		}
		return $cumplimientoSla;
	}
	public static function getCumplimientoDetallePorCliente($clienteid, $fecha = null){
		
		$cliente = Cliente::model()->findByPk($clienteid);
		if(!$fecha)$fecha=Dashboard::getFechaUltimaMensual($cliente->usuario_id);
		$contratos = $cliente->contratos;
		$cumplimientoSla = array();
		foreach ($contratos as $contrato){
			$cumplimientoContrato= Yii::app()->db->createCommand("
					SELECT s.id, s.nombre, s.objetivo, ss.valor, IF(ss.valor >= s.objetivo, 1, 0) as cumplido
					FROM seguimiento_sla ss, sla s, contrato c
					WHERE s.contrato_id = $contrato->id AND
					ss.sla_id = s.id AND
					ss.fecha = $fecha
					GROUP BY s.id
					")->queryAll();
			$valor = array();
			foreach ($cumplimientoContrato as $c_contrato){
				$cumplimientoSla[$c_contrato['nombre']] = array("objetivo"=>(int)$c_contrato['objetivo'], "valor"=>(int)$c_contrato['valor']);
			}
		}
		return $cumplimientoSla;
				
	}
	/*
	public static function getCumplimientoSlaPorServicio($clienteid){
		
	}
	*/
	
	
	/**
	 * Lista de cumplimientos SLA histórico por cliente
	 * @param unknown $userid
	 * @return multitype:multitype:number
	 */
	public static function getCumplimientoSlaHistoricoPorCliente($userid){
		$fechas = Dashboard::getFechasMensual($userid);
	
		$usuario = Usuario::model()->findByPk($userid);
	
		$clientes = $usuario->getClientes();
		$cumplimientoSla = array();
		foreach ($clientes as $cliente){
			$cumplimiento = array();
			foreach ($fechas as $fecha){
				$tasacumplimientocliente = Dashboard::getCumplimientoSlaClienteID($cliente->id, $fecha["fecha"]);
				$cumplimiento[]= round($tasacumplimientocliente,2);
			}
			$cumplimientoSla[$cliente->nombre] = $cumplimiento;
		}
		return $cumplimientoSla;
	
	}
	
	///////////////////////////////ISSUES//////////////////////////////////////////////////////////////////////////////////

	
	public static function getClientesSinIssuesActivos($userid, $fecha = null){

		if(!$fecha)$fecha=date('YW');
		
		$usuario = Usuario::model()->findByPk($userid);
		$clientes = $usuario->getClientes();
		
		$clientesConIssues = 0;
		foreach ($clientes as $cliente){
			$issuesActivos = Issue::model()->countByAttributes(array("cliente_id"=>$cliente->id, 'solucionado'=> 1 ));
			if($issuesActivos>0)
				$clientesConIssues++;
		}
		
		return count($clientes)?(100*(count($clientes) - $clientesConIssues)/count($clientes)):0;

	}
	public static function getClientesConIssuesActivosPorCliente($userid){
		
		$usuario =Usuario::model()->findByPk($userid);
		$clientes = $usuario->getClientes();
		
		$issuesActivosPorCliente = array();
		foreach ($clientes as $cliente){
			$issuesactivos = Issue::model()->countByAttributes(array("cliente_id" => $cliente->id,"solucionado" => 1));
			$issuesActivosPorCliente[$cliente->nombre] = (int)$issuesactivos;
		}
		return $issuesActivosPorCliente;
	}
	public static function getIssuesActivosPorServicio($userid){
	
		$usuario = Usuario::model()->findByPk($userid);
		$clientessql = $usuario->getClientesSql();
		
		$lineasdeservicio = Yii::app()->db->createCommand(" 
				SELECT ls.nombre, SUM(IF(i.solucionado = 1, 1 , 0)) as solucionado
				FROM linea_servicio ls, issue_linea_servicio ils, cliente cl, issue i
				WHERE 	cl.id IN $clientessql AND
						cl.id = i.cliente_id AND
						ils.issue_id = i.id AND
						ils.linea_servicio_id = ls.id
						GROUP BY ls.id
				")->queryAll();
		
		$issuesporservicio = array();
		foreach ($lineasdeservicio as $ls){
			$issuesporservicio[$ls["nombre"]] = (int)$ls["solucionado"];
		}
		

		return $issuesporservicio;
	}
	
	public static function getIssuesTotalesPorServicio($userid){
		$usuario = Usuario::model()->findByPk($userid);
		$clientessql = $usuario->getClientesSql();
		$servicios = Yii::app()->db->createCommand('Select id, nombre from linea_servicio')->queryAll();
		$issuesTotales = array();
		foreach ($servicios as $servicio){
			$id = $servicio['id'];
			$conteoSegunServicio = Yii::app()->db->createCommand("

				SELECT COUNT(*) as Conteo
				FROM linea_servicio ls, issue_linea_servicio ils, issue i, cliente c
				WHERE 
				ils.issue_id = i.id AND
				ils.linea_servicio_id = ls.id AND
				ls.id = $id AND
				i.cliente_id = c.id AND
				c.id IN $clientessql
			")->queryAll();
			//die(print_r($conteoSegunServicio));
			if ($conteoSegunServicio[0]['Conteo'] != 0){
				$issuesTotales[$servicio['nombre']] = (int)$conteoSegunServicio[0]['Conteo'];
			}
		}
		return $issuesTotales;
	}

	public static function getIssuesHistoricosPorClienteSegunServicio($userid, $servicio){
		
		$usuario = Usuario::model()->findByPk($userid);
		$clientessql = $usuario->getClientesSql();
	
		$issuesHistoricosServicios = Yii::app()->db->createCommand("SELECT cl.nombre, i.descripcion, i.solucionado
				FROM cliente cl, issue i, issue_linea_servicio ils, linea_servicio ls
				WHERE 	i.cliente_id = cl.id AND
				cl.id IN $clientessql AND
				ils.issue_id = i.id AND
				ils.linea_servicio_id = ls.id AND
				ls.nombre = '$servicio'
				ORDER BY i.descripcion
				")->queryAll();
				//la idea es que se realice un foreach con los nombres de cada servicio y se realice esta query para cada uno
				$issuesHistoricos = array();
				$clientes = array();
		$issues = array();
		//die(print_r($issuesHistoricosServicios));
	
		foreach ($issuesHistoricosServicios as $ihs){
		if (!in_array($ihs['nombre'], $clientes)) $clientes[] = $ihs['nombre'];
		}
		//die(print_r($issuesHistoricosServicios));
		//se obtienen todos los clientes que irán al gráfico de cada servicio
	
		$issuesHistoricos[0] = array('Issue');
		foreach ($clientes as $c=>$v){
		array_push($issuesHistoricos[0], $v);
		}
		//die(print_r($issuesHistoricos[0]));
		foreach($issuesHistoricosServicios as $ihs){
	
		}
		//die(print_r($issuesHistoricosServicios));
		}
	
	///////////////////////////////PERCEPCIÓN SM//////////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Promedio de Percepción general del SM, de todos los clientes de un usuario
	 * @param unknown $userid
	 * @param string $fecha
	 * @return number
	 */
	public static function getPercepcionGeneralSMporUsuario($userid, $fecha = null){
		if(!$fecha)$fecha=Dashboard::getFechaUltima($userid);
		
		$usuario = Usuario::model()->findByPk($userid);
		$clientessql = $usuario->getClientesSql();

		$seguimientoPercepciones = Yii::app()->db->createCommand("
				SELECT spg.* 
				FROM seguimiento_percepcion_general spg, cliente c
				WHERE 	c.id IN $clientessql AND
						c.id = spg.cliente_id	AND
				spg.fecha = $fecha	
				")->queryAll();
		
		if(!$seguimientoPercepciones)
			return 0;
		
		$percepcionManager = 0;
		foreach($seguimientoPercepciones as $seguimientoPercepcion){
			if ($seguimientoPercepcion['per_sm']>=4){
				$percepcionManager ++;
			}elseif ($seguimientoPercepcion['per_sm']<=2){
				$percepcionManager --;
			}
		}
		
		if($percepcionManager < 0)
			$percepcionManager = 0;
		
		return 100*$percepcionManager/count($seguimientoPercepciones);
		
	}

	public static function getPercepcionGeneralHistoricaUsuarioSM($userid){
		$usuario = Usuario::model()->findByPk($userid);
		$fechas = Dashboard::getFechas($userid);
		$clientessql = $usuario->getClientesSql();
		$percepcionClientePorFecha = array();
		$navegador = 0;
		foreach ($fechas as $fecha){
			$fechaActual = $fecha['fecha'];
			$seguimientoPercepciones = Yii::app()->db->createCommand("
				SELECT spg.*
				FROM seguimiento_percepcion_general spg, cliente c
				WHERE 	c.id IN $clientessql AND
				c.id = spg.cliente_id AND
				spg.fecha = $fechaActual
			")->queryAll();
			if(!$seguimientoPercepciones){
				$percepcionClientePorFecha[$navegador] = 0;
			}
			else{
				if (!isset($percepcionClientePorFecha[$navegador])) $percepcionClientePorFecha[$navegador] = 0;
				foreach ($seguimientoPercepciones as $seguimientoPercepcion){
					if ($seguimientoPercepcion['per_sm']>=4){
						$percepcionClientePorFecha[$navegador] ++;
					}elseif ($seguimientoPercepcion['per_sm']<=2){
						$percepcionClientePorFecha[$navegador] --;
					}
				}
			}
			if ($percepcionClientePorFecha[$navegador]<0) $percepcionClientePorFecha[$navegador] = 0;
			$percepcionClientePorFecha[$navegador] = round(100*$percepcionClientePorFecha[$navegador]/count($seguimientoPercepciones),2);
			$navegador ++;
		}
		$percepcionGeneralHistoricaUsuario = array();
		$percepcionGeneralHistoricaUsuario['historico'] = $percepcionClientePorFecha;
		return $percepcionGeneralHistoricaUsuario;
	}


	/**
	 * Percepción general histórica de todos los clientes de un usuario
	 * @param unknown $userid
	 * @return multitype:multitype:number
	 */
	public static function getPercepcionGeneralHistoricaSM($userid){
	
		$usuario = Usuario::model()->findByPk($userid);
		$fechas = Dashboard::getFechas($userid);
		$clientes = $usuario->getClientes();
		$per_general_sm = array();
		foreach ($clientes as $cliente){
			$per_sm = array();
			foreach ($fechas as $fecha){
				$per_sm[] = Dashboard::getPercepcionGeneralSMPorCliente($cliente->id, $fecha["fecha"]);
			}
			$per_general_sm[$cliente->nombre] = $per_sm;
		}
		
		return $per_general_sm;
	}
	public static function getPercepcionGeneralSMPorCliente($clienteid, $fecha){
	
		if($percepciongeneral = SeguimientoPercepcionGeneral::model()->find("cliente_id = $clienteid AND fecha = $fecha")){
			return (int)$percepciongeneral->per_sm;
		}else{
			return 0;
		}
	}
	
	public static function getSatisfaccionGeneralSM($userid, $fecha = null){
		
		if(!$fecha)
			$fecha = Dashboard::getFechaUltima($userid);
		
		$usuario = Usuario::model()->findByPk($userid);
		$clientes = $usuario->getClientes();
		$per_general_sm = array();
		foreach ($clientes as $cliente){
			$per_general_sm[$cliente->nombre] = Dashboard::getPercepcionGeneralSMPorCliente($cliente->id, $fecha);
		}
		
		return $per_general_sm;
	}
	
	
	public static function getPercepcionSMporServicio($userid, $fecha = null){
	
		if(!$fecha)$fecha=Dashboard::getFechaUltima($userid);
		
		$usuario = Usuario::model()->findByPk($userid);
		$clientessql = $usuario->getClientesSql();
		
		$seguimientoPercepcion= Yii::app()->db->createCommand("
				SELECT ls.nombre, sp.per_sm, sp.fecha
				FROM seguimiento_percepcion sp, linea_servicio_contrato lsc, contrato c, linea_servicio ls, cliente cl
				WHERE cl.id IN $clientessql AND
					c.cliente_id = cl.id AND
					c.id = lsc.contrato_id AND
					ls.id = lsc.linea_servicio_id AND
					lsc.id = sp.linea_servicio_contrato_id AND
					sp.fecha = $fecha
				GROUP BY sp.id")->queryAll();
		
		$lineaservicios = array(); 
		foreach($seguimientoPercepcion as $sp){
			$lineaservicios[$sp["nombre"]] = (int)$sp["per_sm"];	
		}
		return $lineaservicios;
		
		
		/*
	
		$seguimientoPercepcionesCliente = Yii::app()->db->createCommand("SELECT sp.per_sm, sp.fecha, cl.nombre, sp.id
				FROM cliente cl, contrato c, linea_servicio_contrato lsc, seguimiento_percepcion sp
				WHERE cl.id IN $clientessql
				AND cl.id = c.cliente_id
				AND c.id = lsc.contrato_id
				AND lsc.id = sp.linea_servicio_contrato_id
				AND $fecha = sp.fecha
				GROUP BY sp.id;")->queryAll();
		$percepcionesSM = array();
		foreach ($seguimientoPercepcionesCliente as $percepciones){
		if (!isset($percepcionesSM[$percepciones['nombre']]['total'])) $percepcionesSM[$percepciones['nombre']]['total'] = 0;
		f (!isset($percepcionesSM[$percepciones['nombre']]['per_sm'])) $percepcionesSM[$percepciones['nombre']]['per_sm'] = 0;
			$percepcionesSM[$percepciones['nombre']]['total']++;
				if ($percepciones['per_sm'] >= 4) $percepcionesSM[$percepciones['nombre']]['per_sm']++;
		}
						$percepcionesSMClientesPorcentaje = array();
						foreach ($percepcionesSM as $k=>$psm){
						$valor = round(100*$psm['per_sm']/($psm['total']));
						$percepcionesSMClientesPorcentaje[] = array($k, $valor);
						}
						return $percepcionesSMClientesPorcentaje;
						*/
	}
	public static function getPercepcionSMporClienteParaServicios($clienteid){
		$usuario = Usuario::model()->findByPk(Yii::app()->user->id);

		$fechas = Dashboard::getFechas($usuario->id);

		$percepcionFecha = array();
		foreach ($fechas as $fecha){
			$f = $fecha['fecha'];
			$empty = array();
			$percepcion= Yii::app()->db->createCommand("
				SELECT ls.nombre, sp.per_sm
				FROM seguimiento_percepcion sp, linea_servicio_contrato lsc, contrato c, linea_servicio ls, cliente cl
				WHERE cl.id = $clienteid AND
					c.cliente_id = cl.id AND
					c.id = lsc.contrato_id AND
					ls.id = lsc.linea_servicio_id AND
					lsc.id = sp.linea_servicio_contrato_id AND
					sp.fecha = $f
				GROUP BY sp.id")->queryAll();
			if ($percepcion != $empty){
				$percepcionFecha['fechas'][] = $f;
			}
			foreach($percepcion as $p){
				$percepcionFecha[$p['nombre']][] = (int)$p['per_sm']; 
			}
			//die(print_r($percepcion));
		}
		//die(print_r($percepcionFecha['fechas']));
		return $percepcionFecha;
	}

	
	///////////////////////////////PERCEPCION CLIENTE//////////////////////////////////////////////////////////////////////////////////
	/**
	 * Promedio de Percepción general del Cliente, de todos los clientes de un usuario
	 * @param unknown $userid
	 * @param string $fecha
	 * @return number
	 */
	public static function getPercepcionGeneralClientePorUsuario($userid, $fecha = null){
		if(!$fecha)$fecha=Dashboard::getFechaUltima($userid);
		
		$usuario = Usuario::model()->findByPk($userid);
		$clientessql = $usuario->getClientesSql();
		
		$seguimientoPercepciones = Yii::app()->db->createCommand("
				SELECT spg.*
				FROM seguimiento_percepcion_general spg, cliente c
				WHERE 	c.id IN $clientessql AND
				c.id = spg.cliente_id AND
				spg.fecha = $fecha
				")->queryAll();
		
		if(!$seguimientoPercepciones)
			return 0;
	
		$percepcionCliente = 0;
		foreach($seguimientoPercepciones as $seguimientoPercepcion){
			if ($seguimientoPercepcion['per_cliente']>=4){
				$percepcionCliente ++;
			}elseif ($seguimientoPercepcion['per_cliente']<=2){
				$percepcionCliente --;
			}
		}
		if($percepcionCliente<0)
			$percepcionCliente = 0;
		
		
		
		return 100*$percepcionCliente/count($seguimientoPercepciones);
		
	}

	public static function getPercepcionGeneralHistoricaUsuario($userid){
		$usuario = Usuario::model()->findByPk($userid);
		$fechas = Dashboard::getFechas($userid);
		$clientessql = $usuario->getClientesSql();
		$percepcionClientePorFecha = array();
		$navegador = 0;
		foreach ($fechas as $fecha){
			$fechaActual = $fecha['fecha'];
			$seguimientoPercepciones = Yii::app()->db->createCommand("
				SELECT spg.*
				FROM seguimiento_percepcion_general spg, cliente c
				WHERE 	c.id IN $clientessql AND
				c.id = spg.cliente_id AND
				spg.fecha = $fechaActual
			")->queryAll();
			if(!$seguimientoPercepciones){
				$percepcionClientePorFecha[$navegador] = 0;
			}
			else{
				if (!isset($percepcionClientePorFecha[$navegador])) $percepcionClientePorFecha[$navegador] = 0;
				foreach ($seguimientoPercepciones as $seguimientoPercepcion){
					if ($seguimientoPercepcion['per_cliente']>=4){
						$percepcionClientePorFecha[$navegador] ++;
					}elseif ($seguimientoPercepcion['per_cliente']<=2){
						$percepcionClientePorFecha[$navegador] --;
					}
				}
			}
			if ($percepcionClientePorFecha[$navegador]<0) $percepcionClientePorFecha[$navegador] = 0;
			$percepcionClientePorFecha[$navegador] = round(100*$percepcionClientePorFecha[$navegador]/count($seguimientoPercepciones),2);
			$navegador ++;
		}
		$percepcionGeneralHistoricaUsuario = array();
		$percepcionGeneralHistoricaUsuario['historico'] = $percepcionClientePorFecha;
		return $percepcionGeneralHistoricaUsuario;
	}

	public static function getPercepcionGeneralHistoricaCliente($userid){
	
		$usuario = Usuario::model()->findByPk($userid);
		$fechas = Dashboard::getFechas($userid);
		$clientes = $usuario->getClientes();
		$per_general_cliente = array();
		foreach ($clientes as $cliente){
			$per_cliente = array();
			foreach ($fechas as $fecha){
				$per_cliente[] = Dashboard::getPercepcionGeneralClientePorCliente($cliente->id, $fecha["fecha"]);
			}
			$per_general_cliente[$cliente->nombre] = $per_cliente;
		}
		
		return $per_general_cliente;
		
		
	}
	
	public static function getPercepcionGeneralClientePorCliente($clienteid, $fecha){
		
		if($percepciongeneral = SeguimientoPercepcionGeneral::model()->find("cliente_id = $clienteid AND fecha = $fecha")){
			return (int)$percepciongeneral->per_cliente;
		}else{
			return 0;
		}
	}
	public static function getSatisfaccionGeneralCliente($userid, $fecha = null){
	
		if(!$fecha)
			$fecha = Dashboard::getFechaUltima($userid);
	
		$usuario = Usuario::model()->findByPk($userid);
		$clientes = $usuario->getClientes();
		$per_general_cliente = array();
		foreach ($clientes as $cliente){
			$per_general_cliente[$cliente->nombre] = Dashboard::getPercepcionGeneralClientePorCliente($cliente->id, $fecha);
		}
	
		return $per_general_cliente;
	}
/*
	public static function getPercepcionCliente($userid, $fecha = null){

		if(!$fecha)$fecha=Dashboard::getFechaUltima($userid);
		
		$usuario = Usuario::model()->findByPk($userid);
		$clientessql = $usuario->getClientesSql();

		$seguimientoPercepciones = Yii::app()->db->createCommand("SELECT sp.id, sp.linea_servicio_contrato_id, sp.per_cliente, sp.per_sm, sp.fecha, sp.tipo_seguimiento
																  FROM cliente cl, contrato c, linea_servicio_contrato lsc, seguimiento_percepcion sp
																  WHERE cl.id IN $clientessql
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
	}*/
	
	public static function getPercepcionClienteporServicio($userid, $fecha = null){
	
		if(!$fecha)$fecha=Dashboard::getFechaUltima($userid);
	
		$usuario = Usuario::model()->findByPk($userid);
		$clientessql = $usuario->getClientesSql();
	
		$seguimientoPercepcion= Yii::app()->db->createCommand("
				SELECT ls.nombre, sp.per_cliente, sp.fecha
				FROM seguimiento_percepcion sp, linea_servicio_contrato lsc, contrato c, linea_servicio ls, cliente cl
				WHERE cl.id IN $clientessql AND
				c.cliente_id = cl.id AND
				c.id = lsc.contrato_id AND
				ls.id = lsc.linea_servicio_id AND
				lsc.id = sp.linea_servicio_contrato_id AND
				sp.fecha = $fecha
				GROUP BY sp.id")->queryAll();
	
				$lineaservicios = array();
				foreach($seguimientoPercepcion as $sp){
				$lineaservicios[$sp["nombre"]] = (int)$sp["per_cliente"];
				}
				return $lineaservicios;
	}

	
	

	public static function getPercepcionClientePorCliente($userid, $fecha = null){

		/*
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
		return $percepcionesClientePorClientesPorcentaje;*/
	}
	
	////////////////////////////FECHAS /////////////////////////////////////////////////////////////////////////////


	public static function getFechas($userid){
		$usuario = Usuario::model()->findByPk($userid);
		$clientessql = $usuario->getClientesSql();
		$seguimientoSemanal = Yii::app()->db->createCommand("SELECT sp.fecha
				FROM seguimiento_percepcion sp, linea_servicio ls, linea_servicio_contrato lsc, contrato c, cliente cl
				WHERE lsc.id = sp.linea_servicio_contrato_id AND
				c.cliente_id IN $clientessql AND
				lsc.contrato_id = c.id AND
				ls.id = lsc.linea_servicio_id
				GROUP BY sp.fecha;")->queryAll();
		return $seguimientoSemanal;
	}	
	
	public static function getFechasMensual($userid){
		$usuario = Usuario::model()->findByPk($userid);
		$clientessql = $usuario->getClientesSql();
		$fechamensual = Yii::app()->db->createCommand("SELECT sp.fecha
				FROM seguimiento_itil sp, cliente cl
				WHERE 
				sp.cliente_id IN $clientessql
				GROUP BY sp.fecha;")->queryAll();
		return $fechamensual;
	}
	public static function getFechaUltima($userid){
		$fechas = Dashboard::getFechas($userid);
		$ultima = end($fechas);
		return (int)$ultima["fecha"];
	}
	public static function getFechaUltimaMensual($userid){
		if($fechas = Dashboard::getFechasMensual($userid)){
			$ultima = end($fechas);
			return (int)$ultima["fecha"];
		}else{
			return 0;
		}
	}
	
}