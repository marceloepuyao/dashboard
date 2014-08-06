<?php

class m140730_044153_nueva_tabla extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->dropColumn('issue', 'linea_servicio_id');
		
		$this->createTable('issue_linea_servicio', array(
				'issue_id' => 'int NOT NULL',
				'linea_servicio_id' => 'int NOT NULL' )
		);
		$this->addPrimaryKey('PRIMARY', 'issue_linea_servicio', 'issue_id,linea_servicio_id');
		$this->addForeignKey('FK01_issue_linea_servicio_issue', 'issue_linea_servicio', 'issue_id', 'issue', 'id', 'RESTRICT');
		$this->addForeignKey('FK02_issue_linea_servicio_linea_servicio', 'issue_linea_servicio', 'linea_servicio_id', 'linea_servicio', 'id', 'RESTRICT');
	}

	public function safeDown()
	{
		$this->delete('issue_linea_servicio');
		$this->dropTable('issue_linea_servicio');
	}
	
}