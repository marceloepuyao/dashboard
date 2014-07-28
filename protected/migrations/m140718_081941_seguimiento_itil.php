<?php

class m140718_081941_seguimiento_itil extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('seguimiento_itil', array(
				'id' => 'pk',
				'cliente_id' => 'INT  NOT NULL',
				'felicitaciones' => 'INT(10)  DEFAULT 0',
				'reclamos' => 'INT(10)  DEFAULT 0',
				'problemas' => 'INT(10)  DEFAULT 0',
				'cambios' => 'INT(10)  DEFAULT 0',
				'estado_cmdb' => 'INT(10)  DEFAULT 0',
				'incidentes' => 'INT(10)  DEFAULT 0',
				'requerimientos' => 'INT(10)  DEFAULT 0',
				'backlog' => 'INT(10)  DEFAULT 0',
				'indisponibilidad' => 'INT(10)  DEFAULT 0',
				'sip' =>'INT(10)  DEFAULT 0',
				'reuniones' => 'INT(10)  DEFAULT 0',
				'minutas' => 'INT(10)  DEFAULT 0',
				'reunion_servicio' => 'INT(10)  DEFAULT 0',
				'informe' => 'INT(10)  DEFAULT 0',
				'facturado' => 'INT(10)  DEFAULT 0',
				'facturacion_extra' => 'INT(10)  DEFAULT 0',
				'multas' => 'INT(10)  DEFAULT 0',
				'fecha' => 'int(11) DEFAULT NULL',
				'comentario' => 'text',
				'tipo_seguimiento' => 'int(10)  DEFAULT 1',
				'per_client' => 'int(11) NOT NULL',
				'per_sm' => 'int(11) NOT NULL',
		));
		
		$this->addForeignKey('FK01_seguimiento_itil_cliente', 'seguimiento_itil', 'cliente_id', 'cliente', 'id', 'RESTRICT');

		$this->insert("seguimiento_itil", array(
				'cliente_id' => '1',
				'fecha' => '201428',
				'comentario' => '',
				'tipo_seguimiento' => 'int(10) unsigned DEFAULT 1',
				'per_client' => '0',
				'per_sm' => '0',
		));
	}
	public function safeDown()
	{
		$this->delete('seguimiento_itil');
		$this->dropTable('seguimiento_itil');
	}
}