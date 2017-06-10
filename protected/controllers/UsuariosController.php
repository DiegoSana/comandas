<?php

class UsuariosController extends Controller
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
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('createComensal'),
				'users'=>array('*')
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('@'),
                                'roles'=>array('encargado'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
        protected function puedeEditar($idu)
        {
            $usuarioAevaluar = Usuarios::model()->findByAttributes(array('id'=>intval($idu),'estado'=>1));
            $usuarioLogueado = Yii::app()->user->usuario;
            if(Yii::app()->user->checkAccess('superadmin'))
                return TRUE;
            elseif($usuarioAevaluar->empresa_id==$usuarioLogueado->empresa_id)
            {
                if($usuarioAevaluar->aplicaciones)
                {
                    $flagAp = FALSE;
                    foreach ($usuarioLogueado->aplicaciones as $app)
                    {
                        foreach ($usuarioAevaluar->aplicaciones as $ap)
                            if($ap->id==$app->id)
                                $flagAp = TRUE;
                    }
                }
                else
                    $flagAp = TRUE;
                if($usuarioAevaluar->roles)
                {
                    $flagRol = ($usuarioAevaluar->roles[0]->orden>=$usuarioLogueado->roles[0]->orden);
                }
                else
                    $flagRol = TRUE;
                return ($flagAp && $flagRol);
            }
            return FALSE;
        }

        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            if($this->puedeEditar($id))
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
            else
                throw new CHttpException(403,'No tiene permisos.');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Usuarios;
                $usuariosRoles=new UsuariosRoles;
                $usuariosAplicacion = new UsuariosAplicacion;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Usuarios']) && $_POST['UsuariosRoles'] && $_POST['UsuariosAplicacion']['aplicacion_id'])
		{
                    $transaction = Yii::app()->db->beginTransaction();
			$model->attributes=$_POST['Usuarios'];                         
			if($model->save()) {
                            $usuariosRoles->usuarios_id = $model->id;
                            $usuariosRoles->roles_id = intval($_POST['UsuariosRoles']['roles_id']);
                            if($usuariosRoles->roles_id>0)
                                $save = $usuariosRoles->save();
                            if(!isset($save) || $save) {
                                $usuariosAplicacion->usuarios_id = $model->id;
                                $usuariosAplicacion->aplicacion_id = intval($_POST['UsuariosAplicacion']['aplicacion_id']);
                                if($usuariosAplicacion->aplicacion_id>0)
                                    $save1 = $usuariosAplicacion->save();
                                if(!isset($save1) || $save1) {
                                    $transaction->commit();
                                    Yii::app()->user->setFlash('success', "El usuario \"".$model->usuario."\" se ha creado correctamente!");
                                    $this->redirect(array('view','id'=>$model->id));
                                }else
                                    $transaction->rollback();
                            }else
                                $transaction->rollback();
                        }else
                            $transaction->rollback();
		}

		$this->render('create',array(
			'model'=>$model,
                        'usuariosRoles'=>$usuariosRoles,
                        'usuariosAplicacion'=>$usuariosAplicacion,
		));
	}
        
        public function actionCreateComensal()
	{
		$usuario=new Usuarios;
                $usuariosRoles=new UsuariosRoles;
                $usuariosAplicacion = new UsuariosAplicacion;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($usuario);

		if(isset($_POST['nombre']))
		{
                    $transaction = Yii::app()->db->beginTransaction();
                    $usuario->nombre = $_POST['nombre'];
                    $usuario->apellido = $_POST['nombre'];
                    $usuario->usuario = time().'.'.$usuario->nombre;
                    $usuario->pass = $usuario->usuario;
                    $usuario->repass = $usuario->usuario;
                    $usuario->empresa_id = Yii::app()->user->aplicacion->empresa_id;
                    if($usuario->save()) {
                        $usuariosRoles->usuarios_id = $usuario->id;
                        $usuariosRoles->roles_id = Roles::COMENSAL1;
                        if($usuariosRoles->roles_id > 0)
                            $save = $usuariosRoles->save();
                        if(!isset($save) || $save) {
                            $usuariosAplicacion->usuarios_id = $usuario->id;
                            $usuariosAplicacion->aplicacion_id = Yii::app()->user->aplicacion->id;
                            if($usuariosAplicacion->aplicacion_id > 0)
                                $save1 = $usuariosAplicacion->save();
                            if(!isset($save1) || $save1) {
                                $transaction->commit();
                                $login=new LoginForm;
                                $login->password = $usuario->usuario;
                                $login->username = $usuario->usuario;
                                $login->login();
                                echo json_encode(array('success'=>true, 'msg'=>"Usuario creado!"));
                                exit;
                            }else
                                $transaction->rollback();
                        }else
                            $transaction->rollback();
                    }else
                        $transaction->rollback();

                    echo json_encode(array('success'=>false, 'msg'=>"No se pudo crear el usuario", 'err'=>array('Debe ingresar el nombre',$usuario->getErrors(),$usuariosRoles->getErrors(),$usuariosAplicacion->getErrors())));
		} else {
                    echo json_encode(array('success'=>false, 'msg'=>"No se pudo crear el usuario", 'err'=>array('Debe ingresar el nombre')));
                }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
            if($this->puedeEditar($id))
            {
		$model=$this->loadModel($id);
                if(isset($model->roles[0]->id))
                    $usuariosRoles=  UsuariosRoles::model()->findByPk(array('usuarios_id'=>$id,'roles_id'=>$model->roles[0]->id));
                else
                    $usuariosRoles= new UsuariosRoles;
                if(isset($model->aplicaciones[0]->id))
                    $usuariosAplicacion = UsuariosAplicacion::model()->findByPk(array('usuarios_id'=>$id,'aplicacion_id'=>$model->aplicaciones[0]->id));
                else
                    $usuariosAplicacion = new UsuariosAplicacion;
                
		if(isset($_POST['Usuarios']) && $_POST['UsuariosRoles'] && $_POST['UsuariosAplicacion']['aplicacion_id'])
		{
                    $transaction = Yii::app()->db->beginTransaction();
			$model->attributes=$_POST['Usuarios'];                         
			if($model->save()) {
                            UsuariosRoles::model()->deleteAll('usuarios_id = '.$model->id);
                            $usuariosRoles= new UsuariosRoles;
                            $usuariosRoles->usuarios_id = $model->id;
                            $usuariosRoles->roles_id = intval($_POST['UsuariosRoles']['roles_id']);
                            if($usuariosRoles->roles_id>0)
                                $save = $usuariosRoles->save();
                            if(!isset($save) || $save) {
                                UsuariosAplicacion::model()->deleteAll('usuarios_id = '.$model->id);
                                $usuariosAplicacion = new UsuariosAplicacion;                                
                                $usuariosAplicacion->usuarios_id = $model->id;
                                $usuariosAplicacion->aplicacion_id = intval($_POST['UsuariosAplicacion']['aplicacion_id']);
                                if($usuariosAplicacion->aplicacion_id>0)
                                    $save1 = $usuariosAplicacion->save();
                                if(!isset($save1) || $save1) {
                                    $transaction->commit();
                                    Yii::app()->user->setFlash('success', "El usuario \"".$model->usuario."\" se ha actualizado correctamente!");
                                    $this->redirect(array('/usuarios/view','id'=>$model->id));
                                }else
                                    $transaction->rollback();
                            }else
                                $transaction->rollback();
                        }else
                            $transaction->rollback();
		}

		$this->render('update',array(
			'model'=>$model,
                        'usuariosRoles'=>$usuariosRoles,
                        'usuariosAplicacion'=>$usuariosAplicacion
		));
            }
            else
                throw new CHttpException(403,'No tiene permisos.');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
            if($this->puedeEditar($id))
            {                
		$usu = $this->loadModel($id);
                $usu->estado = 0;
                $usu->save();
                Yii::app()->user->setFlash('success', "El usuario \"".$usu->usuario."\" fue dado de baja correctamente!");
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/usuarios/admin'));
            }
            else
                throw new CHttpException(403,'No tiene permisos.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
                $this->redirect('/usuarios/admin');
	}

        protected function getRolesArray($roles)
        {
            $array = array();
            foreach ($roles as $rol)
                $array[] = $rol->rol;
            return $array;
        }
        /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Usuarios('search');
                $criteria = new CDbCriteria();
                $criteria->addCondition('roles.id NOT IN ('.Roles::COMENSAL1.','.Roles::COMENSAL.')');
                $criteria->addCondition('roles.orden >= '.Yii::app()->user->usuario->roles[0]->orden.' OR roles.id IS NULL');
                if(!Yii::app()->user->checkAccess('superadmin'))
                {
                    foreach (Yii::app()->user->usuario->aplicaciones as $ap)
                        $appsUserIds[] = $ap->id;
                    $criteria->addCondition('aplicaciones.id IN ('.  implode(',', $appsUserIds).') OR aplicaciones.id IS NULL');
                }
                $model->setDbCriteria($criteria);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuarios']))
			$model->attributes=$_GET['Usuarios'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Usuarios the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Usuarios::model()->with(array('roles','aplicaciones'))->findByAttributes(array('id'=>$id,'estado'=>1));
		if($model===null)
			throw new CHttpException(404,'Página no encontrada.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Usuarios $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
