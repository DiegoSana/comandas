<?php
require_once Yii::app()->modulePath.'/wsafip/components/afip/wsAfipFactory.php';

class DefaultController extends Controller
{

    
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('@'),
                                'roles'=>array('encargado'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
	public function actionIndex()
	{
            
            $config = array(
                'service'=>'wsmtxca',
                'cert'=>'keys/pedido.crt',
                'key'=>'keys/privada.key'
            );
            
            $ws = WsAfipFactory::getService($config);
            
            var_dump('<pre>',$ws->consultarCAEA('26509320938330'));
            //var_dump('<pre>',$ws->solicitarCAEA());
            
            die;
            $this->render('index');
	}
}