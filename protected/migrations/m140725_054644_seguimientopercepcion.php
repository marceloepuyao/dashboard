<?php

class m140725_054644_seguimientopercepcion extends CDbMigration
{
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('seguimiento_percepcion', array(
				'id'=>'pk',
				'linea_servicio_contrato_id' => 'int NOT NULL',
				'per_cliente' => 'int NOT NULL DEFAULT 0',
				'per_sm' => 'int NOT NULL DEFAULT 0',
				'fecha' => 'int NOT NULL DEFAULT 0',
				'tipo_seguimiento' => 'int NOT NULL DEFAULT 0' )
		);
		$this->addForeignKey('FK01_seguimiento_percepcion_linea_servicio_contrato', 'seguimiento_percepcion', 'linea_servicio_contrato_id', 'linea_servicio_contrato', 'id', 'RESTRICT');
	}

	public function safeDown()
	{
		$this->delete('seguimiento_percepcion');
		$this->dropTable('seguimiento_percepcion');
	}
	
}