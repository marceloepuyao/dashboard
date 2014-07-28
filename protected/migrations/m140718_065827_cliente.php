<?php

class m140718_065827_cliente extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('cliente', array(
				'id' => 'pk',
				'usuario_id' => 'INT NOT NULL',
				'industria' => 'VARCHAR(255) DEFAULT NULL',
				'empleados' => 'INT(10)  DEFAULT NULL',
				'facturacion' => 'INT(10) DEFAULT NULL',
				'categoria' => 'INT(10) DEFAULT NULL',
				'nombre' => 'VARCHAR(255) NULL',
				'rut' => 'VARCHAR(45) DEFAULT NULL',
				'hq' => 'VARCHAR(255) DEFAULT NULL',
				'jp' => 'VARCHAR(45) DEFAULT NULL',
				'kam' => 'VARCHAR(45) DEFAULT NULL',
				'arquitecto' => 'VARCHAR(45) DEFAULT NULL',
				'competidor' => 'VARCHAR(255) DEFAULT NULL',
		));
		
		$this->addForeignKey('FK01_cliente_usuario', 'cliente', 'usuario_id', 'usuario', 'id', 'RESTRICT');

		$this->insert("cliente", array(
				'usuario_id' => 1,
				'industria' => 'Gobierno',
				'empleados' => 0,
				'facturacion' => 0,
				'categoria' => 0,
				'nombre' => 'PISEE',
				'rut' => '123123132-3',
				'hq' => 'Teatinos',
				'jp' => '',
				'kam' => 'Patricio Martinez',
				'arquitecto' => '',
				'competidor' => 'no aplica',
		));
		
		
		
	}

	public function safeDown()
	{
		$this->delete('cliente');
		$this->dropTable('cliente');
	}
}