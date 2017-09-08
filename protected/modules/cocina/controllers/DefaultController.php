<?php

class DefaultController extends Controller
{

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
                'actions'=>array('index'),
                'users'=>array('@'),
                'roles'=>array('cocina'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

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
        $cond .= ' AND pedidos_has_productos_estados_id = '.PedidosHasProductosEstados::COCINA;
        if($mesasArray)
            $cond .= ' AND pedidos.mesas_id IN ('.implode(",",$mesasArray).')';
        else
            $cond .= ' AND pedidos.mesas_id IN (0)';
        $criteria = new CActiveDataProvider($model,
            [
                'criteria'=>[
                    'with'=>['pedidos'],
                    'condition'=>$cond,
                    'order'=>'t.id DESC'
                ],
                'sort' => [
                    'attributes' => [
                        'pedidos.id' => [
                            'asc' => 'pedidos.id',
                            'desc' => 'pedidos.id desc',
                        ],
                        'nro_mesa_search' => [
                            'asc' => 'mesa.nro_mesa',
                            'desc' => 'mesa.nro_mesa desc',
                        ]
                    ],
                ]
            ]
        );
        $model->setDbCriteria($criteria->getCriteria());
        if(isset($_GET['PedidosHasProductos']))
            $model->attributes=$_GET['PedidosHasProductos'];

        $this->render('index',array(
            'pedidos'=>$model,
        ));
	}
}