<?php

class MesasController extends Controller
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
				'actions'=>array('index','view','create','update','admin','delete','savePosition'),
				'users'=>array('@'),
                                'roles'=>array('encargado'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

        protected function checkMesasPermiso($idMesa)
        {
            $mesa = Mesas::model()->findByPk($idMesa);
            $this->checkAplicacion($mesa->aplicacion_id);
        }

        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                $this->checkMesasPermiso($id);
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
		$model=new Mesas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Mesas']))
		{
			$model->attributes=$_POST['Mesas'];
                        $this->checkAplicacion($model->aplicacion_id);
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                $this->checkMesasPermiso($id);
		$model=$this->loadModel($id);
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Mesas']))
		{
			$model->attributes=$_POST['Mesas'];
                        $this->checkAplicacion($model->aplicacion_id);
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

        public function actionSavePosition()
        {
            $idMesa = intval($_POST['idm']);
            $this->checkMesasPermiso($idMesa);
            $position = json_encode(array('top'=>intval($_POST['top']),'left'=>intval($_POST['left'])));
            
            $mesa=$this->loadModel($idMesa);
            $mesa->posicion = $position;
            if($mesa->save())
                echo true;
        }

        /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
                $this->checkMesasPermiso($id);
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{               
                $dataProvider=new CActiveDataProvider(
                        'Mesas',
                        array('criteria'=>array('condition'=>'aplicacion_id='.Yii::app()->user->aplicacion->id))
                );
                    
		$this->render('index',array(
                        'aplicacion'=>Yii::app()->user->aplicacion,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Mesas('search');
                $criteria = $model->getDbCriteria();
                $criteria->addColumnCondition(array('t.aplicacion_id'=>  Yii::app()->user->aplicacion->id));
                $model->setDbCriteria($criteria);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Mesas']))
			$model->attributes=$_GET['Mesas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Mesas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Mesas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Mesas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mesas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
