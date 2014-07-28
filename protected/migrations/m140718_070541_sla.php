<?php

class m140718_070541_sla extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('sla', array(
				'id' => 'pk',
				'contrato_id' => 'INT NOT NULL',
				'nombre' => 'VARCHAR(45) DEFAULT NULL',
				'objetivo' => 'INT NOT NULL',
				'descripcion' => 'VARCHAR(200)',
		));
		
		$this->insert("sla", array(
				'contrato_id' => 1,
				'nombre' => 'Nuevo SLA - Aauco',
				'Objetivo' => 90,
				'descripcion' => '',
		));
	}
	public function safeDown()
	{
		$this->delete('sla');
		$this->dropTable('sla');
	}
}