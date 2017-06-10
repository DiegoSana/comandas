<?php

class ProductosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
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
				'actions'=>array('view','create','update','index','admin','getCategoriasXAplicacion'),
				'users'=>array('@'),
                                'roles'=>array('encargado'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	protected function checkProductoPermiso($idprod)
	{
		$prod = Productos::model()->findByPk($idprod);
                $this->checkAplicacion($prod->aplicacion_id);
	}

        protected function getCategoriasArray($categorias)
        {
            $array = array();
            foreach ($categorias as $cat)
                $array[] = $cat->nombre;
            return $array;
        }
        
        public function actionGetCategoriasXAplicacion()
        {
            if(isset($_POST['appid']))
            {
                $appId = intval($_POST['appid']);
                foreach(Yii::app()->user->usuario->aplicaciones as $apps){
                    if ($apps->id == $appId)
                    {
                        $categorias = Categorias::model()->findAllByAttributes(array('aplicacion_id'=>$apps->id));
                        if($categorias)
                        {
                            $ret = '';
                            foreach ($categorias as $categoria){
                                $ret .= '<option value="'.$categoria->id.'">'.$categoria->nombre.'</option>';
                            }
                        }
                        else
                            $ret = '<option value="">Esta aplicación no tiene categorias</option>';
                        echo json_encode(array('status'=>'1', 'msg'=>$ret));
                        return true;
                    }
                }
                throw new CHttpException(500,'Acceso denegado');
            }
            else
                throw new CHttpException(500,'Acceso denegado');
        }

        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                $this->checkProductoPermiso($id);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$productos=new Productos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Productos']))
		{
                        try
                        {
                            $transaction = Yii::app()->db->beginTransaction();
                            $productos->attributes=$_POST['Productos'];  
                            $this->checkAplicacion($productos->aplicacion_id);
                            if(!$productos->save())
                                throw new Exception;
                            if (isset($_POST['ProductosOpciones']))
                            {                                
                                foreach ($_POST['ProductosOpciones'] as $key => $opcion)
                                {                                    
                                    $productosOpciones = new ProductosOpciones;
                                    $productosOpciones->nombre = $opcion['nombre'];
                                    if(!$productosOpciones->save())
                                    {
                                        $productos->addError('id', 'No se pudo crear la opcion');
                                        throw new Exception;
                                    }
                                    if(isset($_POST['ProductosOpcionesHasProductos'][$key]))
                                    {
                                        foreach ($_POST['ProductosOpcionesHasProductos'][$key]['productos_id'] as $idProd)
                                        {
                                            $productosOpcionesHasProductos = new ProductosOpcionesHasProductos;
                                            $productosOpcionesHasProductos->productos_id = intval($idProd);
                                            $productosOpcionesHasProductos->productos_opciones_id = $productosOpciones->id;
                                            if(!$productosOpcionesHasProductos->save())
                                            {
                                                $productos->addError('id', 'Se produjo un error inesperado. Comuniquese con el administrador del sistema');
                                                throw new Exception;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $productos->addError('id', 'Debe seleccionarl las opciones del producto');
                                        throw new Exception;
                                    }
                                    $productosHasProductosOpciones = new ProductosHasProductosOpciones();
                                    $productosHasProductosOpciones->productos_id = $productos->id;
                                    $productosHasProductosOpciones->productos_opciones_id = $productosOpciones->id;
                                    if(!$productosHasProductosOpciones->save())
                                    {
                                        $productos->addError('id', 'Se produjo un error inesperado. Comuniquese con el administrador del sistema');
                                        throw new Exception;
                                    }
                                }
                            }                            
                            if(isset($_POST['ProductosHasCategorias']))
                            {
                                foreach ($_POST['ProductosHasCategorias']['categorias_id'] as $idCat)
                                {
                                    $productosHasCategorias = new ProductosHasCategorias();
                                    $productosHasCategorias->categorias_id=$idCat;
                                    $productosHasCategorias->productos_id = $productos->id;
                                    if(!$productosHasCategorias->save())
                                    {
                                        $productos->addError('id', 'Debe seleccionarl al menos una categoria');
                                        throw new Exception('dddd');
                                    }
                                }
                            }
                            else
                            {
                                $productos->addError('id', 'Debe seleccionarl al menos una categoria');
                                throw new Exception('dddd');
                            }                            
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', "El producto \"".$productos->nombre."\" se ha creado correctamente!");
                            $this->redirect(array('/productos/view','id'=>$productos->id));
                        }
                        catch(Exception $e)
                        {
                           $transaction->rollback();
                        }
		}

		$this->render('create',array(
			'productos'=>$productos,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$producto=$this->loadModel($id);              
                $this->checkProductoPermiso($producto->id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Productos']))
		{                        
                        try
                        {
                            $transaction = Yii::app()->db->beginTransaction();
                            $producto->attributes=$_POST['Productos'];
                            $this->checkAplicacion($producto->aplicacion_id);
                            if(!$producto->save())
                                throw new Exception('bbbb');
                            if(!isset($_POST['ProductosHasCategorias']))
                            {
                                $producto->addError ('id', 'Debe seleccionar al menos una categoría');
                                throw new Exception('eeee');
                            }
                            else
                            {
                                ProductosHasCategorias::model()->deleteAll(array('condition'=>'productos_id = '.$producto->id));
                                foreach ($_POST['ProductosHasCategorias']['categorias_id'] as $idCat)
                                {
                                    $productosHasCategorias = new ProductosHasCategorias();
                                    $productosHasCategorias->categorias_id=$idCat;
                                    $productosHasCategorias->productos_id = $producto->id;
                                    if(!$productosHasCategorias->save())
                                        throw new Exception('dddd');
                                }
                            }
                            if($producto->productosOpciones)
                            {
                                foreach ($producto->productosOpciones as $productosOpciones) {
                                    ProductosHasProductosOpciones::model()->deleteAll(array('condition' => 'productos_opciones_id = '.$productosOpciones->id));
                                    ProductosOpcionesHasProductos::model()->deleteAll(array('condition' => 'productos_opciones_id = '.$productosOpciones->id));
                                    ProductosOpciones::model()->findByPk($productosOpciones->id)->delete();
                                }
                            }
                            if (isset($_POST['ProductosOpciones']))
                            {                                
                                foreach ($_POST['ProductosOpciones'] as $key => $opcion)
                                {                                    
                                    $productosOpciones = new ProductosOpciones;
                                    $productosOpciones->nombre = $opcion['nombre'];
                                    if(!$productosOpciones->save())
                                    {
                                        $producto->addError('id', 'No se pudo crear la opcion');
                                        throw new Exception;
                                    }
                                    if(isset($_POST['ProductosOpcionesHasProductos'][$key]))
                                    {
                                        foreach ($_POST['ProductosOpcionesHasProductos'][$key]['productos_id'] as $idProd)
                                        {
                                            $productosOpcionesHasProductos = new ProductosOpcionesHasProductos;
                                            $productosOpcionesHasProductos->productos_id = intval($idProd);
                                            $productosOpcionesHasProductos->productos_opciones_id = $productosOpciones->id;
                                            if(!$productosOpcionesHasProductos->save())
                                            {
                                                $producto->addError('id', 'Se produjo un error inesperado. Comuniquese con el administrador del sistema');
                                                throw new Exception;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $producto->addError('id', 'Debe seleccionarl las opciones del producto');
                                        throw new Exception;
                                    }
                                    $productosHasProductosOpciones = new ProductosHasProductosOpciones();
                                    $productosHasProductosOpciones->productos_id = $producto->id;
                                    $productosHasProductosOpciones->productos_opciones_id = $productosOpciones->id;
                                    if(!$productosHasProductosOpciones->save())
                                    {
                                        $producto->addError('id', 'Se produjo un error inesperado. Comuniquese con el administrador del sistema');
                                        throw new Exception;
                                    }
                                }
                            }
                            Yii::app()->user->setFlash('success', "El producto \"".$producto->nombre."\" se ha actualizado correctamente!");
                            $transaction->commit();
                            $this->redirect(array('/productos/view','id'=>$producto->id));
                        }
                        catch(Exception $e)
                        {
                           $transaction->rollback();
                        }                        
		}

		$this->render('update',array(
			'producto'=>$producto,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
            var_dump($id);die;
		//$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		/*if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $this->redirect('/productos/admin');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model= new Productos('search');
                $criteria = $model->getDbCriteria();
                $criteria->addColumnCondition(array('t.aplicacion_id'=>Yii::app()->user->aplicacion->id));
                $model->setDbCriteria($criteria);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productos']))
			$model->attributes=$_GET['Productos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Productos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Productos::model()->with('productosOpciones')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Productos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='productos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
