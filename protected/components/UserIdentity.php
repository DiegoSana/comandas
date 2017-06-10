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
                if($this->username=='comensal' && $pedido = Pedidos::model()->findByAttributes(array('hash'=>$this->password,'pedidos_estados_id'=>Pedidos::ACTIVO)))
                {
                    $this->_id = $this->password;
                    $this->setState('es_comensal', true);
                    $this->setState('mesa', $pedido->mesas->nro_mesa);
                    $this->setState('aplicaciones', array($pedido->mesas->aplicacion));
                    $this->setState('aplicacion', $pedido->mesas->aplicacion);
                    $this->errorCode=self::ERROR_NONE;
                }
                else
                {
                    $user = Usuarios::model()->with(array('roles','aplicaciones'))->findByAttributes(array('usuario'=>$this->username,'pass'=>sha1($this->username.$this->password),'estado'=>1));
                    if(!$user)
                            $this->errorCode=self::ERROR_USERNAME_INVALID;
                    else
                    {
                        $this->_id = $user->id;
                        $this->setState('aplicaciones', $user->aplicaciones);
                        $this->setState('aplicacion', $user->aplicaciones[0]);
                        $this->setState('empresa_id', $user->empresa_id);
                        $this->setState('usuario', $user);
                        $this->errorCode=self::ERROR_NONE;
                    }
                }
		return !$this->errorCode;
	}
    
        public function getId(){
            return $this->_id;
        }
}
