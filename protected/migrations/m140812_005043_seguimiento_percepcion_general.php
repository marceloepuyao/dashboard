<?php

class m140812_005043_seguimiento_percepcion_general extends CDbMigration
{
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		
		$this->dropColumn('seguimiento_itil', 'per_sm');
		$this->dropColumn('seguimiento_itil', 'per_client');

		$this->createTable('seguimiento_percepcion_general', array(
				'id'=>'pk',
				'cliente_id' => 'int NOT NULL',
				'per_cliente' => 'int NOT NULL DEFAULT 0',
				'per_sm' => 'int NOT NULL DEFAULT 0',
				'fecha' => 'int NOT NULL DEFAULT 0')
		);
		$this->addForeignKey('FK01_seguimiento_percepcion_general_cliente', 'seguimiento_percepcion_general', 'cliente_id', 'cliente', 'id', 'RESTRICT');
		
	}

	public function safeDown()
	{
	}
	
}