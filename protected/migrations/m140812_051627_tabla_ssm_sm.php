<?php

class m140812_051627_tabla_ssm_sm extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('ssm_sm', array(
				'id' => 'pk',
				'sm_id' => 'int NOT NULL',
				'ssm_id' => 'int NOT NULL' )
		);
	}

	public function safeDown()
	{
		$this->dropTable("ssm_sm");
	}
	
}