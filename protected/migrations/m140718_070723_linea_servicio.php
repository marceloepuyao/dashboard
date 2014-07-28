<?php

class m140718_070723_linea_servicio extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('linea_servicio', array(
				'id' => 'pk',
				'nombre' => 'VARCHAR(45) NOT NULL',
		));
		
		//$this->addForeignKey('FK02_issue_linea_servicio', 'issue', 'linea_servicio_id', 'linea_servicio', 'id', 'SET NULL');
		
		$this->insert("linea_servicio", array(
				'nombre' => 'Preventa',
		));
		
		
	}

	public function safeDown()
	{
		$this->delete('linea_servicio');
		$this->dropTable('linea_servicio');
	}
	
}