<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
        public $aplicacion_url=null;
        public $aplicacion;


        /**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
        public function init() {            
            
            if(isset($_GET['pid']))
            {
                if(Yii::app()->user->id)
                    Yii::app()->session->destroy();
                $model=new LoginForm;
                $model->username='comensal';
                $model->password=$_GET['pid'];
                $model->login();
            }
            if(Yii::app()->user->id)
            {
                if(isset(Yii::app()->user->es_comensal) && Yii::app()->user->es_comensal)
                {
                    if(Pedidos::model()->findByAttributes(array('hash'=>Yii::app()->user->id), 'pedidos_estados_id != '.Pedidos::ACTIVO))
                        Yii::app()->session->destroy();
                    if(!Yii::app()->authManager->getAuthItem('comensal'))
                        Yii::app()->authManager->createAuthItem('comensal',2);
                    if(!Yii::app()->authManager->isAssigned('comensal',Yii::app()->user->id))
                        Yii::app()->authManager->assign('comensal',Yii::app()->user->id);
                }
                else
                {
                    Yii::app()->authManager->clearAll();
                    $user = Yii::app()->user->usuario;
                    foreach ($user->roles as $rolUsu)
                    {
                        Yii::app()->authManager->createAuthItem($rolUsu->rol,2);
                        foreach (Roles::model()->findAllByAttributes(array(), 'orden > '.$rolUsu->orden) as $child)
                        {
                            if(!Yii::app()->authManager->getAuthItem($child->rol))
                                Yii::app()->authManager->createAuthItem($child->rol,2);
                            Yii::app()->authManager->addItemChild($rolUsu->rol, $child->rol);
                        }
                        Yii::app()->authManager->assign($rolUsu->rol,Yii::app()->user->id);
                    }
                }
                if(!isset(Yii::app()->user->aplicacion) && Yii::app()->user->checkAccess('superadmin',array(Yii::app()->user->id))) {
                    $apps = Aplicacion::model()->findAll();
                    Yii::app()->user->setState('aplicaciones',$apps);
                    Yii::app()->user->setState('aplicacion',$apps[0]);
                }
            }

            parent::init();
        }
                    
        protected function checkAplicacion($idapp)
        {
            foreach(Yii::app()->user->usuario->aplicaciones as $apps)		
                    if($idapp == $apps->id)
                            return true;
            throw new CHttpException(500,'Acceso denegado');
        }
}
