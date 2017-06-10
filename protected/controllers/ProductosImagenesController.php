<?php

class ProductosImagenesController extends Controller
{
        public $layout='//layouts/column2';        

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','upload','delete'),
				'users'=>array('@'),
                                'roles'=>array('encargado'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

        public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
        
        public function actionIndex($id)
	{
            $producto=  Productos::model()->findByPk($id);
            if( !$producotsImagenes =  ProductosImagenes::model()->findAllByAttributes(array('productos_id'=>$producto->id)) )
                    $producotsImagenes = array();
            
            if($_POST)
            {
                
            }
            
            $this->render('index', array('producto'=>$producto,'producotsImagenes'=>$producotsImagenes));
	}
        
        public function actionUpload()
        {
            $ref = explode('/', $_SERVER['HTTP_REFERER']);
            $idp = end($ref);
            //var_dump($idp);die;
            //Сheck that we have a file
            if((!empty($_FILES["file"])) && ($_FILES['file']['error'] == 0)) {
              //Check if the file is JPEG image and it's size is less than 350Kb
              $filename = basename($_FILES['file']['name']);
              $ext = substr($filename, strrpos($filename, '.') + 1);
              if (($ext == "jpg" || $ext == "jpeg") && ($_FILES["file"]["type"] == "image/jpeg") && 
                ($_FILES["file"]["size"] < 35000000000)) {
                
                  $producto = Productos::model()->findByPk($idp);
                  $storeFileName = 'app'.$producto->aplicacion_id.'/'.mktime().'.'.$ext;
                  $newname = 'images/productos/'.$storeFileName;
                  //Check if the file with the same name is already exists on the server
                  if (!file_exists($newname)) {
                    //Attempt to move the uploaded file to it's new place
                    //var_dump($_FILES['file']['tmp_name']);die;
                    if ((move_uploaded_file($_FILES['file']['tmp_name'],$newname))) {
                        $productosImagenes = new ProductosImagenes();
                        $productosImagenes->nombre = $storeFileName;
                        $productosImagenes->productos_id = $producto->id;
                        $productosImagenes->producto_id = $producto->id;
                        if($productosImagenes->save())
                            echo "OK";
                        else
                            var_dump($productosImagenes->getErrors());
                    } else {
                       echo "Error: A problem occurred during file upload!";
                    }
                  } else {
                     echo "Error: File ".$_FILES["file"]["name"]." already exists";
                  }
              } else {
                 echo "Error: Only .jpg images under 350Kb are accepted for upload";
              }
            } else {
             echo "Error: No file uploaded";
            }
            
        }
        
        public function actionDelete($id) {
            //var_dump(intval($id));die;
            $imagen = ProductosImagenes::model()->findByPk($id);
            $nombre = $imagen->nombre;
            if($imagen->delete()) {
                unlink('/images/productos/'.$nombre);
                echo 'true';
            }
            else
                echo 'false';
        }
}