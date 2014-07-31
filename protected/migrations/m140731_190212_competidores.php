<?php

class m140731_190212_competidores extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->dropColumn('cliente', 'competidor');
		$this->createTable('competidor', array(
				'id' => 'pk',
				'nombre' => 'VARCHAR(45) NOT NULL',
		));
		
		$this->createTable('cliente_competidor', array(
				'cliente_id' => 'INT NOT NULL',
				'competidor_id' => 'INT NOT NULL',
		));
		
		$this->addPrimaryKey('PRIMARY', 'cliente_competidor', 'cliente_id,competidor_id');
		$this->addForeignKey('FK01_cliente_competidor_cliente', 'cliente_competidor', 'cliente_id', 'cliente', 'id', 'RESTRICT');
		$this->addForeignKey('FK02_cliente_competidor_competidor', 'cliente_competidor', 'competidor_id', 'competidor', 'id', 'RESTRICT');
		
	}

	public function safeDown()
	{
	}
	
}