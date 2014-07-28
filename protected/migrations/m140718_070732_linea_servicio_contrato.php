<?php

class m140718_070732_linea_servicio_contrato extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('linea_servicio_contrato', array(
			'contrato_id' => 'int NOT NULL',
			'linea_servicio_id' => 'int NOT NULL' )
		);
		$this->addPrimaryKey('PRIMARY', 'linea_servicio_contrato', 'contrato_id,linea_servicio_id');
		$this->addForeignKey('FK01_linea_servicio_contrato_contrato', 'linea_servicio_contrato', 'contrato_id', 'contrato', 'id', 'RESTRICT');
		$this->addForeignKey('FK02_linea_servicio_contrato_linea_servicio', 'linea_servicio_contrato', 'linea_servicio_id', 'linea_servicio', 'id', 'RESTRICT');
		
		$this->insert('linea_servicio_contrato', array(
			'contrato_id' => 1,
			'linea_servicio_id' => 1 )
		);
	}

	/**
	 * Baja transaccionalmente la tabla y todo lo relacionado con ella
	 */
	public function safeDown()
	{
		$this->delete('linea_servicio_contrato');
		$this->dropTable('linea_servicio_contrato');
	}
}