<?php

class m140901_005525_fecha_termino_issue extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn("issue", "fecha_solucionado", "DATETIME");
	}

	public function safeDown()
	{
		$this->dropColumn("issue", "fecha_solucionado");
	}

}