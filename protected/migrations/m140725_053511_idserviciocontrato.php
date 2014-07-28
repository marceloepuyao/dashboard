<?php

class m140725_053511_idserviciocontrato extends CDbMigration
{
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->delete('linea_servicio_contrato');
		$this->dropTable('linea_servicio_contrato');
		
		$this->createTable('linea_servicio_contrato', array(
			'id'=>'pk',
			'contrato_id' => 'int NOT NULL',
			'linea_servicio_id' => 'int NOT NULL' )
		);
		$this->addForeignKey('FK01_linea_servicio_contrato_contrato', 'linea_servicio_contrato', 'contrato_id', 'contrato', 'id', 'RESTRICT');
		$this->addForeignKey('FK02_linea_servicio_contrato_linea_servicio', 'linea_servicio_contrato', 'linea_servicio_id', 'linea_servicio', 'id', 'RESTRICT');
		
		$this->insert('linea_servicio_contrato', array(
			'contrato_id' => 1,
			'linea_servicio_id' => 1 )
		);
	}

	public function safeDown()
	{
		$this->delete('linea_servicio_contrato');
		$this->dropTable('linea_servicio_contrato');
	}
	
}