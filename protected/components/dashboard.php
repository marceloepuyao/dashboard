<?php
class Dashboard {

	/**
	 * Método de generación de dropdown de estudios
	 *
	 * @return Array array con la estructura del dropdown.
	 */
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

		$issuesClientes = Yii::app()->db->createCommand(" 	   SELECT i.id, i.cliente_id, i.descripcion, i.fecha, i.solucionado, i.criticidad
															   FROM cliente cl, issue i 
															   WHERE $userid = cl.usuario_id
															   AND cl.id = i.cliente_id
															   GROUP BY cl.id;")->queryAll();
		$totalClientes = 0;
		$clientesConIssues = 0;
		//print_r($issuesClientes);
		foreach ($issuesClientes as $issuesCliente){
			$totalClientes++;
			if ($issuesCliente['solucionado'] != 2){
				$clientesConIssues++;
				break;
			}
		}
		if ($totalClientes!=0){
			$porcentajeConIssues = $clientesConIssues/$totalClientes;
			$porcentajeSinIssues = 100*($totalClientes-$clientesConIssues)/$totalClientes;
		}
		else $porcentajeSinIssues = 0;
		return $porcentajeSinIssues;

	}
	
	public static function getFechas($userid){
		
		return array("201431", "201430","201429", "201428");
		
	}
	
}