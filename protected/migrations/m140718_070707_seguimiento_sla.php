<?php

class m140718_070707_seguimiento_sla extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('seguimiento_sla', array(
				'id' => 'pk',
				'sla_id' => 'INT NOT NULL',
				'valor' => 'INT(11) NOT NULL',
				'fecha' => 'INT(11) NOT NULL',
				'tipo_seguimiento' => 'INT(11) NOT NULL',
		));
		
		$this->addForeignKey('FK01_seguimiento_sla_sla', 'seguimiento_sla', 'sla_id', 'sla', 'id', 'RESTRICT');
		$this->insert("seguimiento_sla", array(
				'sla_id' => 1,
				'valor' => 100,
				'fecha' => 201428,
				'tipo_seguimiento' => 0,
		));
	}
	public function safeDown()
	{
		$this->delete('seguimiento_sla');
		$this->dropTable('seguimiento_sla');
	}
}