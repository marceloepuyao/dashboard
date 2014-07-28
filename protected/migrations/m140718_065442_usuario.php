<?php

class m140718_065442_usuario extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('usuario', array(
				'id' => 'pk',
				'nombre' => 'VARCHAR(45) NOT NULL',
				'apellido' => 'VARCHAR(45) NOT NULL',
				'email' => 'VARCHAR(255) NOT NULL',
				'password' => 'VARCHAR(45) NOT NULL',
				'perfil_id' => 'int NOT NULL',
		));
		
		$this->addForeignKey('FK01_usuario_perfil', 'usuario', 'perfil_id', 'perfil', 'id', 'RESTRICT');

		$cryptpass = crypt("123");
		$this->insert("usuario", array(
				'nombre' => 'admin',
				'apellido' => 'admin',
				'email' => 'admin@admin.cl',
				'password' => $cryptpass,
				'perfil_id' => '1',
		));
		
	}

	public function safeDown()
	{
		$this->delete('usuario');
		$this->dropTable('usuario');
	}
}