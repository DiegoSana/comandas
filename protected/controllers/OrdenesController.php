<?php

class OrdenesController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','admin','confirmar','cocina','entregar','cancelar'),
				'users'=>array('@'),
                                'roles'=>array('encargado'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new PedidosHasProductos('search');
		$model->unsetAttributes();  // clear any default values
                $mesas = Mesas::model()->findAllByAttributes(array('aplicacion_id'=>Yii::app()->user->aplicacion->id));
                $mesasArray = array();
                foreach ($mesas as $mesa){
                    array_push($mesasArray, $mesa->id);
                }
                $cond = 'pedidos_has_productos_id IS null';
                if($mesasArray)
                    $cond .= ' AND pedidos.mesas_id IN ('.implode(",",$mesasArray).')';
                else
                    $cond .= ' AND pedidos.mesas_id IN (0)';
                $criteria = new CActiveDataProvider($model,
                        array(
                            'criteria'=>array(
                                'with'=>array('pedidos'),
                                'condition'=>$cond,
                                'order'=>'t.id DESC'
                            )
                        )
                    );
                $model->setDbCriteria($criteria->getCriteria());
		if(isset($_GET['Pedidos']))
			$model->attributes=$_GET['Pedidos'];

		$this->render('index',array(
			'pedidos'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pedidos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pedidos']))
			$model->attributes=$_GET['Pedidos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

        public function actionConfirmar($id){
            $orden = PedidosHasProductos::model()->findByPk($id);
            $orden->pedidos_has_productos_estados_id = PedidosHasProductosEstados::CONFIRMADO;
            if($orden->save())
                Yii::app()->user->setFlash('success', "La orden fue confirmada correctamente!");
            else
                Yii::app()->user->setFlash('danger', "Lo lamentamos pero se produjo un error. Si el error persiste comuniquese con el administrador.");
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        
        public function actionCocina($id){
            $orden = PedidosHasProductos::model()->findByPk($id);
            $orden->pedidos_has_productos_estados_id = PedidosHasProductosEstados::COCINA;
            if($orden->save())
                Yii::app()->user->setFlash('success', "La orden fue enviada a la cocina para su preparación!");
            else
                Yii::app()->user->setFlash('danger', "Lo lamentamos pero se produjo un error. Si el error persiste comuniquese con el administrador.");
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        
        public function actionEntregar($id){
            $orden = PedidosHasProductos::model()->findByPk($id);
            $orden->pedidos_has_productos_estados_id = PedidosHasProductosEstados::ENTREGADO;
            if($orden->save())
                Yii::app()->user->setFlash('success', "La orden fue marcado como entregado!");
            else
                Yii::app()->user->setFlash('danger', "Lo lamentamos pero se produjo un error. Si el error persiste comuniquese con el administrador.");
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        
        public function actionCancelar($id){
            $orden = PedidosHasProductos::model()->findByPk($id);
            $orden->pedidos_has_productos_estados_id = PedidosHasProductosEstados::CANCELADO;
            if($orden->save())
                Yii::app()->user->setFlash('success', "La orden fue cancelada!");
            else
                Yii::app()->user->setFlash('danger', "Lo lamentamos pero se produjo un error. Si el error persiste comuniquese con el administrador.");
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pedidos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=  PedidosHasProductos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pedidos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pedidos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
