<?php

class m140723_224920_addperfil extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->insert("perfil", array(
				'nombre' => 'SSM',
		));
		
		$this->insert("perfil", array(
				'nombre' => 'SM',
		));
	}

	public function safeDown()
	{
	}
	
}