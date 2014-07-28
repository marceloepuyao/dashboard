<?php

class m140718_070003_competidores extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('competidores', array(
				'id' => 'pk',
				'cliente_id' => 'INT NOT NULL',
				'nombre' => 'VARCHAR(45) DEFAULT NULL',
				'criticidad' => 'INT(10) NOT NULL',
		));
		$this->addForeignKey('FK01_competidores_cliente', 'competidores', 'cliente_id', 'cliente', 'id', 'RESTRICT');
	}

	public function safeDown()
	{
		$this->delete('competidores');
		$this->dropTable('competidores');
	}
}