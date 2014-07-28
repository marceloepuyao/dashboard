<?php 
class WebUser extends CWebUser
{
    /**
     * Overrides a Yii method that is used for roles in controllers (accessRules).
     *
     * @param string $operation Name of the operation required (here, a role).
     * @param mixed $params (opt) Parameters for this operation, usually the object to access.
     * @return bool Permission granted?
     */
	protected $_model;
 
    function isAdmin(){
        $user = $this->loadUser();
        if ($user)
           return $user->perfil_id==1;
        return false;
    }
    
    function isSSM(){
    	$user = $this->loadUser();
        if ($user) 
            return $user->perfil_id==2;
    	return false;
    }

    function isSM(){
    	$user = $this->loadUser();
    	if ($user) 
            return $user->provider_id==3;
    	return false;
    }
 
    // Load user model.
    protected function loadUser()
    {
        if ( $this->_model === null ) {
                $this->_model = Usuario::model()->findByPk( $this->id );
        }
        return $this->_model;
    }
}