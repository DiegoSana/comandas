<?php
require_once(Yii::app()->basePath . '/extensions/phpqrcode/qrlib.php');
require_once(Yii::app()->basePath . '/extensions/fpdf/fpdf.php');
require_once(Yii::app()->basePath . '/extensions/fpdi/pdf_parser.php');
require_once(Yii::app()->basePath . '/extensions/fpdi/pdf_context.php');
require_once(Yii::app()->basePath . '/extensions/fpdi/fpdi_pdf_parser.php');
require_once(Yii::app()->basePath . '/extensions/fpdi/fpdi_bridge.php');
require_once(Yii::app()->basePath . '/extensions/fpdi/fpdf_tpl.php');
require_once(Yii::app()->basePath . '/extensions/fpdi/fpdi.php');
//require_once(Yii::app()->basePath . '/extensions/html2pdf/html2pdf.php');
//require_once(Yii::app()->basePath . '/extensions/html_table_pdf/html_table.php');
class PedidosController extends Controller
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
				'actions'=>array('index','view','create','update','admin','delete','close','open','createPdf','pay'),
				'users'=>array('@'),
                                'roles'=>array('encargado'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                $model = Pedidos::model()->with(
                        array('productoses',
                            'usuario',
                            'mesas'=>array(
                                'condition'=>"mesas.aplicacion_id = ".Yii::app()->user->aplicacion->id
                            ))
                        )->findByPk($id);
		$this->renderPartial('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            //Chequear que tenga permisos de encargado
            //Chequear que la mesa pertenezca a la aplicacion del usuario logueado
            //Solo AJAX
		$pedido=new Pedidos;
		if(isset($_POST['Pedidos']))
		{
                    if(isset($_POST['Pedidos']['cantidad']) && $_POST['Pedidos']['cantidad']>0)
                        $cantidad = intval($_POST['Pedidos']['cantidad']);
                    else{
                        echo 'Debe crear al menos un tiket';
                        die;
                    }
                    $mesa = Mesas::model()->findByPk(intval($_POST['Pedidos']['mesas_id']));
                    for($i=0; $cantidad>$i; $i++)
                    {
                        $pedido=new Pedidos;
                        $pedido->mesas_id = $mesa->id;
                        $pedido->pedidos_estados_id = 1;
                        $pedido->hash = md5($i.time());
                        $pedido->aplicacion_id = intval($_POST['Pedidos']['mesas_id']);
                        $pedido->qr_image = $this->createQR($pedido->hash, $mesa->aplicacion->subdominio);
			$pedido->save();                        
                    }
                    //Crear tarjeta QR
                    echo 'ok';
                    die;
		}
                else
                    throw new CHttpException(404,'Página no encontrada');
	}
        
        protected function createQR($hash,$subdominio)
        {
            $tempDir = $_SERVER["DOCUMENT_ROOT"].'/images/qr/';
            $relDir = 'images/qr/';

            $codeContents = 'http://'.$_SERVER["SERVER_NAME"].'/menu/?pid='.$hash;
            $fileName = $hash.'.png';

            $pngAbsoluteFilePath = $tempDir.$fileName;
            $urlRelativeFilePath = $relDir.$fileName;

            QRcode::png($codeContents, $pngAbsoluteFilePath);
            return $urlRelativeFilePath;
        }
        
        public function actionCreatePdf()
        {
            if(isset($_GET['getFile']))
            {
                /*header("Content-type:application/pdf");
                return Yii::app()->getRequest()->sendFile('tikets.pdf', @file_get_contents('tmp/'.$_GET['getFile'].'pdf'), 'application/pdf');*/
            }
            elseif(isset($_POST['ids']))
            {
                // initiate FPDI
                $pdf = new FPDI();
                // add a page
                $pdf->AddPage();
                // set the source file
                $pdf->setSourceFile("images/tmplateTikets.pdf");
                // import page 1
                $tplIdx = $pdf->importPage(1);
                // use the imported page and place it at point 10,10 with a width of 100 mm
                $pdf->useTemplate($tplIdx, 0, 0);

                // now write some text above the imported page
                $pdf->SetFont('Helvetica');
                $pdf->SetTextColor(255, 0, 0);
                $x = 10; $y = 10;
                $i = 1;
                foreach ($_POST['ids'] as $id){
                    $pedido = Pedidos::model()->findByPk($id);
                    $pdf->SetXY($x, $y);
                    $pdf->Write(0, 'Mesa '.$pedido->mesas->nro_mesa.' ('.$pedido->mesas->aplicacion->nombre.')');
                    $pdf->Image($pedido->qr_image,$x,$y+10,20,20,'PNG');
                    if($i % 3 == 0){
                        $y=$y+41;
                        $x=10;
                    }
                    else
                        $x = $x+65;
                    $i++;
                    if($i==18)
                        break;
                }
                $filemane = time();
                $pdf->Output('tmp/'.$filemane.'.pdf');
                echo $filemane;
            }
        }

        public function actionClose($id){
            $pedido = Pedidos::model()->findByPk($id);
            $pedido->pedidos_estados_id = PedidosEstados::CANCELADO;
            if($pedido->save())
                Yii::app()->user->setFlash('success', "El pedido fue cancelado correctamente!");
            else
                Yii::app()->user->setFlash('danger', "Lo lamentamos pero se produjo un error. Si el error persiste comuniquese con el administrador.");
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        
        public function actionOpen($id){
            $pedido = Pedidos::model()->findByPk($id);
            $pedido->pedidos_estados_id = PedidosEstados::ACTIVO;
            if($pedido->save())
                Yii::app()->user->setFlash('success', "El pedido fue activado correctamente!");
            else
                Yii::app()->user->setFlash('danger', "Lo lamentamos pero se produjo un error. Si el error persiste comuniquese con el administrador.");
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        
        public function actionPay($id){
            $pedido = Pedidos::model()->findByPk($id);
            $pedido->pedidos_estados_id = PedidosEstados::PAGADO;
            if($pedido->save())
                Yii::app()->user->setFlash('success', "El pedido fue marcado como pagado!");
            else
                Yii::app()->user->setFlash('danger', "Lo lamentamos pero se produjo un error. Si el error persiste comuniquese con el administrador.");
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pedidos']))
		{
			$model->attributes=$_POST['Pedidos'];
			if($model->save()) {
                                Yii::app()->user->setFlash('success', "El tiket se ha modificado correctamente!");
				$this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
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
            $this->redirect('/pedidos/admin');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{                
		$model=new Pedidos('search');
                $criteria = $model->getDbCriteria();
                $criteria->order = 't.id DESC';
                $criteria->with[] = 'mesas';
                $criteria->addColumnCondition(array('mesas.aplicacion_id'=>  Yii::app()->user->aplicacion->id));
                $model->setDbCriteria($criteria);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pedidos']))
			$model->attributes=$_GET['Pedidos'];

		$this->render('admin',array(
			'model'=>$model,
		));
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
		$model=Pedidos::model()->findByPk($id);
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
