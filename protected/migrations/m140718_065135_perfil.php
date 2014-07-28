<?php

class m140718_065135_perfil extends CDbMigration
{
// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('perfil', array(
				'id' => 'pk',
				'nombre' => 'VARCHAR(20) NOT NULL',
		));
		
		$this->insert("perfil", array(
				'nombre' => 'admin',
		));
	}

	public function safeDown()
	{
		$this->delete('perfil');
		$this->dropTable('perfil');
		
	}
}