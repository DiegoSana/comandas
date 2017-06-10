<?php

class SiteController extends Controller
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
                        array('allow',
                            'actions'=>array('settings'),
                            'users'=>array('@'),
                            'roles'=>array('admin')
                        ),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('login','error','logout','home','contact'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            foreach (Yii::app()->user->usuario->roles as $rol) {
                if($rol->id==Roles::CAMARERO ||$rol->id==Roles::COMENSAL1 || $rol->id==Roles::COMENSAL) {
                    $this->redirect ('/menu');
                    break;
                }
            }            
            $this->render('index');
	}

        public function actionHome() {
                $this->layout='//layouts/mainhb';
                Yii::app()->setTheme('ascend');
		$model=new LoginForm;
                $contact=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$contact->attributes=$_POST['ContactForm'];
			if($contact->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($contact->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($contact->subject).'?=';
				$headers="From: $name <{$contact->email}>\r\n".
					"Reply-To: {$contact->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$contact->body,$headers);
				Yii::app()->user->setFlash('contact','Gracias por contactarse con nosotros. Nos pondremos en contacto a la brevedad.');
				$this->refresh();
			}
		}
                $this->render('index',array('model'=>$model,'contact'=>$contact));
        }
        
        public function actionSettings() {
            
            $aplicaciones = Yii::app()->user->aplicaciones;
            $newAppId = intval($_POST['Aplicacion']['id']);
            
            if(isset($newAppId)) {
                foreach ($aplicaciones as $app) {
                    if($app->id == intval($newAppId)) {
                        Yii::app()->user->setState('aplicacion', $app);
                        break;
                    }
                }
            }
            
            $this->render('settings',array(
                'aplicaciones'=>  $aplicaciones,
                'aplicacion'=>  Yii::app()->user->aplicacion,
                )
            );
        }

        /**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
                $this->layout='//layouts/mainhb';
                Yii::app()->setTheme('ascend');
		$contact=new ContactForm;
                $model=new LoginForm;
		if(isset($_POST['ContactForm']))
		{
			$contact->attributes=$_POST['ContactForm'];
			if($contact->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($contact->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($contact->subject).'?=';
				$headers="From: $name <{$contact->email}>\r\n".
					"Reply-To: {$contact->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$contact->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
                $this->redirect('/site/home#contact');die;
		$this->render('index',array('model'=>$model,'contact'=>$contact));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
                
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];			
			// validate user input and redirect to the previous page if valid			
			if($model->validate() && $model->login())
                            echo json_encode (array('success'=>true));
                        else
                            echo json_encode (array('success'=>false, 'err'=>$model->getErrors ()));
                        die;
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('home'));
	}
}