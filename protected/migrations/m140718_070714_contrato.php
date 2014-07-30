<?php

class m140718_070714_contrato extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('contrato', array(
				'id' => 'pk',
				'cliente_id' => 'INT NOT NULL',
				'facturacion' => 'INT(10)  Default Null',
				'inicio' => 'date DEFAULT NULL',
				'fin' => 'date DEFAULT NULL',
				'codigo_moebius' => 'VARCHAR(20) Default Null',
				'titulo' => 'VARCHAR(100) DEFAULT NULL',
		));
		$this->addForeignKey('FK01_contrato_cliente', 'contrato', 'cliente_id', 'cliente', 'id', 'RESTRICT');

		$this->insert("contrato", array(
				'cliente_id' => 1,
				'facturacion' => 400,
				'inicio' => '2010-01-01',
				'fin' => '2010-01-08',
				'codigo_moebius' => '1234',
				'titulo' => 'Hosting y Administración',
		));
		
	}

	public function safeDown()
	{
		$this->delete('contrato');
		$this->dropTable('contrato');
	}
}