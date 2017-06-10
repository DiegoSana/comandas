<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->        
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
        
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui');?>
        <?php Yii::app()->clientScript->registerCoreScript('cookie');?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->
<?php
$menu
?>
	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
                                array('label'=>'Aplicaciones', 'url'=>array('/aplicacion/index'), 'visible'=>(Yii::app()->user->checkAccess('superadmin',Yii::app()->user->id))?true:false),
                                array('label'=>'Menu', 'url'=>array('/menu/index'), 'visible'=>true),
                                array('label'=>'Usuarios por aplicacion', 'url'=>array('/usuariosAplicacion/admin'), 'visible'=>(Yii::app()->user->checkAccess('superadmin',Yii::app()->user->id))?true:false),
                                array('label'=>'Roles', 'url'=>array('/roles/admin'), 'visible'=>(Yii::app()->user->checkAccess('superadmin',Yii::app()->user->id))?true:false),
                                array('label'=>'Pedidos', 'url'=>array('/pedidos/admin'), 'visible'=>(Yii::app()->user->checkAccess('superadmin',Yii::app()->user->id))?true:false),
                                array('label'=>'Roles por usuarios', 'url'=>array('/usuariosRoles/admin'), 'visible'=>(Yii::app()->user->checkAccess('encargado',Yii::app()->user->id))?true:false),
                                array('label'=>'Empresas', 'url'=>array('/empresa/admin'), 'visible'=>(Yii::app()->user->checkAccess('superadmin',Yii::app()->user->id))?true:false),
                                array('label'=>'Usuarios', 'url'=>array('/usuarios/index'), 'visible'=>(Yii::app()->user->checkAccess('encargado',Yii::app()->user->id))?true:false),
                                array('label'=>'Productos', 'url'=>array('/productos/index'), 'visible'=>(Yii::app()->user->checkAccess('encargado',Yii::app()->user->id))?true:false),
                                array('label'=>'Categorias', 'url'=>array('/categorias/index'), 'visible'=>(Yii::app()->user->checkAccess('encargado',Yii::app()->user->id))?true:false),
                                array('label'=>'Mesas', 'url'=>array('/mesas/index'), 'visible'=>(Yii::app()->user->checkAccess('encargado',Yii::app()->user->id))?true:false),
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		));?><!-- breadcrumbs -->
	<?php endif?>
        <?php //if(isset($this->breadcrumbs)):?>
        <?php
        /*$this->widget(
            'foundation\widgets\Breadcrumbs',
            array(
                'items' => $this->breadcrumbs
            )
        );*/?>
        <?php //endif?>
	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
