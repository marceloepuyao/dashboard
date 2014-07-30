<?php

class m140730_045527_relacion_contrato_sla extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addForeignKey('FK01_sla_contrato', 'sla', 'contrato_id', 'contrato', 'id', 'RESTRICT');
	}

	public function safeDown()
	{
		
	}
	
}