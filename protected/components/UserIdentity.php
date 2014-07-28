<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user= Usuario::model()->find("LOWER(email)=?", array(strtolower($this->username)));
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(crypt($this->password, $user->password)!==$user->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{

			$this->_id = $user->id;
			
			$this->setState('nombre', $user->nombre) ;
			$this->setState('apellido', $user->apellido) ;

			$this->setState('email', $user->email) ;
			$perfil = Perfil::model()->find("id=?", array($user->perfil_id));
			
			$this->setState('perfil', $perfil->nombre) ;
			
			$this->setState('admin', ($user->perfil_id==1) );

			//$this->setState('roles',$perfil->nombre);

			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	public function getId()
    {
        return $this->_id;
    }
	public function IsAdmin() {
	    $user = $this->loadUser(Yii::app()->user->id);
	    if ($user === null) {
	        return false;
	    }
	    return intval($user->user_level_id) == AccountModule::USER_LEVEL_ADMIN;
	}
	
}