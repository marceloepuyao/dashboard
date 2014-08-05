<?php

class m140805_032011_dosdecimales extends CDbMigration
{
// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->alterColumn('sla', 'objetivo', 'FLOAT(7,2) DEFAULT 0');
	}

	public function safeDown()
	{
		
	}
}