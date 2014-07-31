<?php

class m140731_213028_inttofloat extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->alterColumn('sla', 'objetivo', 'FLOAT(7,4) DEFAULT 0');
	}

	public function safeDown()
	{
		
	}
	
}