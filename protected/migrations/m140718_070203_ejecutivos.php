<?php

class m140718_070203_ejecutivos extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('ejecutivos', array(
				'id' => 'pk',
				'cliente_id' => 'INT NOT NULL',
				'cargo' => 'VARCHAR(45) DEFAULT NULL',
				'nombre' => 'VARCHAR(45) DEFAULT NULL',
				'apellido' => 'VARCHAR(45) DEFAULT NULL',
				'email' => 'VARCHAR(255) DEFAULT NULL',
				'telefono' => 'VARCHAR(45) DEFAULT NULL',
				'celular' => 'VARCHAR(45) DEFAULT NULL',
		));
		$this->addForeignKey('FK01_ejecutivos_cliente', 'ejecutivos', 'cliente_id', 'cliente', 'id', 'RESTRICT');
	
	}

	public function safeDown()
	{
		$this->delete('ejecutivos');
		$this->dropTable('ejecutivos');
	}
}