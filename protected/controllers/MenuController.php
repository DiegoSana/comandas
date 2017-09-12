<?php

class MenuController extends Controller
{
        public $layout='//layouts/one_column';   
        public $categorias;


    public function init()
	{
                parent::init();
                
                $arr = explode('.', $_SERVER["HTTP_HOST"]);

                if(isset(Yii::app()->user->usuario)) {
                    if($arr[0] != DEFAULT_SUBDOMINIO) {
                        // Acá esta logueado y accediendo al menu por la url del establecimiento. Seteo la aplicacion
                        if(isset(Yii::app()->user->usuario) && isset(Yii::app()->user->aplicaciones) && count(Yii::app()->user->aplicaciones)==1) {
                            Yii::app()->user->setState('aplicacion',Yii::app()->user->aplicaciones[0]);
                        } else {
                            $app = Aplicacion::model()->findByPk(APP_ID);
                            Yii::app()->user->setState('aplicacion',$app);
                        }
                    } else {
                        // Acá esta logueado y tratando de acceder al menu por la url de comandas
                        $this->redirect('site/index');
                    }
                    
                } else {
                    if($arr[1] != DEFAULT_DOMINIO) {
                        // Acá NO esta logueado. Seteamos la app segun url
                        if($app = Aplicacion::model()->findByPk(APP_ID))
                            Yii::app()->user->setState('aplicacion',$app);
                    } else {
                        // Acá NO esta logueado y trata de acceder al menu por la url de comandas
                        $this->redirect(DEFAULT_URL.'/site/home');
                    }
                    
                }
                
                Yii::app()->setTheme('nativedroid');
                $productos = Productos::model()->with('categorias')->findAllByAttributes(
                        array('aplicacion_id'=>Yii::app()->user->aplicacion->id)
                        );
                foreach ($productos as $producto)
                    foreach ($producto->categorias as $categoria)
                        $categoriasIds[] = $categoria->id;
                $this->categorias = array();
                if(isset($categoriasIds))
                    $this->categorias = Categorias::model()->findAllByAttributes(array(),'id IN ('.  implode(',', $categoriasIds).')');                
	}

    public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
        
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','categoria','producto'),
				'users'=>array('*'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('agregarProducto','misPedidos'),
				'users'=>array('@'),
                                'roles'=>array('comensal','comensal1','camarero'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
	public function actionIndex()
	{
        Yii::app()->setTheme('nativeDroid2');
        $this->layout= '//layouts/main';
		$this->render('index',array('categorias'=>$this->categorias));
	}
        
        public function actionAgregarProducto()
        {
            //Chequear si la mesa es correcta
            if(isset($_POST['PedidosHasProductos']))
            {
                $cantidad = $_POST['cantidad'];
                if(!filter_var($cantidad, FILTER_VALIDATE_INT) || $cantidad>10 || $cantidad <1) {
                    echo json_encode(array('status'=>false, 'msg'=>'Debe seleccionar la cantidad'));
                    die;
                }
                $transaction = Yii::app()->db->beginTransaction();
                if(Yii::app()->user->checkAccess('camarero')) {
                    if(!($pedido = Pedidos::model()->findByAttributes(array('mesas_id'=>$_POST['Pedidos']['mesas_id'],'pedidos_estados_id'=>  PedidosEstados::ACTIVO)))) {
                        $pedido = new Pedidos ();                    
                        $pedido->mesas_id = intval($_POST['Pedidos']['mesas_id']);
                        $pedido->pedidos_estados_id = PedidosEstados::ACTIVO;
                        $pedido->hash = Yii::app()->user->id;
                        $pedido->aplicacion_id = Yii::app()->user->aplicacion->id;
                        $pedido->save();                        
                    }
                } elseif(Yii::app()->user->checkAccess('comensal')) {
                    $pedido = Pedidos::model()->findByAttributes(array('hash'=>Yii::app()->user->id));
                } elseif(Yii::app()->user->checkAccess('comensal1')) {
                    if(!($pedido = Pedidos::model()->findByAttributes(array('hash'=>Yii::app()->user->id,'pedidos_estados_id'=>  PedidosEstados::ACTIVO)))){
                        $pedido = new Pedidos ();                    
                        $pedido->mesas_id = Yii::app()->user->usuario->aplicaciones[0]->mesa_default_id;
                        $pedido->pedidos_estados_id = PedidosEstados::ACTIVO;
                        $pedido->hash = Yii::app()->user->id;
                        $pedido->aplicacion_id = Yii::app()->user->aplicacion->id;
                        $pedido->save();
                    }
                } else {
                    die('Accesso denegado');
                }
                   
                $transactionStatus = false;
                for($i=1; $i<=$cantidad; $i++) {
                    $pedidosHasProductos = new PedidosHasProductos();
                    $pedidosHasProductos->attributes = $_POST['PedidosHasProductos'];
                    $pedidosHasProductos->selected_option = (isset($_POST['PedidosHasProductos']["selected_option"])) ? $_POST['PedidosHasProductos']["selected_option"] : array() ;
                    $pedidosHasProductos->pedidos_id = $pedido->id;
                    $pedidosHasProductos->pedidos_has_productos_estados_id = 2;
                    $pedidosHasProductos->validate();
                    if($pedidosHasProductos->save())
                    {                                        
                        foreach ($pedidosHasProductos->selected_option as $op)
                        {
                            if($op)
                            {
                                $pedidosHasProductosNew = new PedidosHasProductos();
                                $pedidosHasProductosNew->pedidos_id = $pedido->id;
                                $pedidosHasProductosNew->pedidos_has_productos_id = $pedidosHasProductos->id;
                                $pedidosHasProductosNew->productos_id = $op;
                                $pedidosHasProductosNew->pedidos_has_productos_estados_id = 2;
                                if(!$pedidosHasProductosNew->save()){
                                    $transactionStatus = false;
                                    break;
                                }
                            }
                        }
                        $transactionStatus = true;
                    }
                    else
                    {
                        $transactionStatus = false;
                        break;
                    }
                }
                if($transactionStatus) {
                    $transaction->commit();
                    echo json_encode(array('status'=>true, 'msg'=>'Su pedido fue enviado!'));
                    die;
                } else {
                    $transaction->rollback();
                    echo json_encode(array('status'=>false, 'msg'=>'No se pudo realizar el pedido', $pedidosHasProductos->getErrors()));
                    die;
                }
            }
            else
            {
                echo json_encode(array('status'=>false, 'msg'=>'No se pudo realizar el pedido'));
                die;
            }
        }

        public function actionCategoria($idCategoria=null)
        {
                        Yii::app()->setTheme('nativeDroid2');
            $this->layout= '//layouts/main';
                if(isset($_GET['categoria']))
                {
                    $categoria = Categorias::model()->findByPk(intval($_GET['categoria']));
                    if($this->aplicacion_url) 
                        $appId = $this->aplicacion->id;
                    else
                        $appId = Yii::app()->user->aplicacion->id;
                    $productos = Productos::model()->with(array('categorias','productosImagenes'))->findAll(
                            array(
                                'condition'=>'categorias.id = '.$categoria->id.' AND t.aplicacion_id = '.$appId
                                )
                            );
                    $this->render('categoria',array('productos'=>$productos, 'categoria'=>$categoria));
                }
                else
                    throw new Exception ('Petición incorrecta', 400);
        }
        
        public function actionMisPedidos() {
            Yii::app()->setTheme('nativeDroid2');
            $this->layout= '//layouts/main';
            $ped = new Pedidos();
            $crit = $ped->getDbCriteria();
            $crit->addColumnCondition(array('hash'=>Yii::app()->user->usuario->id));
            $crit->order = 'id DESC';
            $ped->setDbCriteria($crit);
            /*var_dump('<pre>',$ped->findAll());die;
            $pedidos = Pedidos::model()->findAllByAttributes(array(
                'hash'=>  Yii::app()->user->usuario->id
            ));*/
            $this->render('mispedidos',array('pedidos'=>$ped->findAll()));
        }

        public function actionProducto($idProducto=null)
        {            
            Yii::app()->setTheme('nativeDroid2');
            $this->layout= '//layouts/main';
                if(isset($_REQUEST['producto']) || $idProducto)
                {
                    $idProducto = isset($_REQUEST['producto']) ? intval($_REQUEST['producto']) : $idProducto;
                    $producto = Productos::model()->with(array('categorias','productosImagenes'))->findByPk($idProducto);
                    if(isset($_REQUEST['categoria']))
                        $idCategoria = intval($_REQUEST['categoria']);
                    else
                        $idCategoria = $producto->categorias[0]->id;
                    
                    $categoriaFrom = Categorias::model()->findByPk($idCategoria);
                    $pedidosHasProductos = new PedidosHasProductos();
                    $this->render(
                            'producto',array(
                                'producto'=>$producto,
                                'categoriaFrom'=>$categoriaFrom,
                                'pedidosHasProductos'=>$pedidosHasProductos,
                                'pedido'=>new Pedidos()
                            ));
                    die;
                }
                else
                    throw new Exception ('Petición incorrecta', 400);
        }

        // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
