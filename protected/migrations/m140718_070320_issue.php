<?php

class m140718_070320_issue extends CDbMigration
{
	public function safeUp()
	{	
		$this->createTable('issue', array(
				'id' => 'pk',
				'linea_servicio_id' => 'INT NOT NULL ',
				'cliente_id' => 'INT NOT NULL',
				'descripcion' => 'text',
				'fecha' => 'date DEFAULT NULL',
				'solucionado' => 'int(10) DEFAULT 0',
				'criticidad' => 'int(10) DEFAULT NULL',
		));
		$this->addForeignKey('FK01_issue_cliente', 'issue', 'cliente_id', 'cliente', 'id', 'RESTRICT');
		
		$this->insert("issue", array(
				'linea_servicio_id' => 2,
				'cliente_id' => 1,
				'descripcion' => 'Nuevo jaksdjlaskdj akssjd asd',
				'fecha' => '2014-06-27',
				'solucionado' => '2',
				'criticidad' => '1',
		));
		
	}

	public function safeDown()
	{
		$this->delete('issue');
		$this->dropTable('issue');
	}
}