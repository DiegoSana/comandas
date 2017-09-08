<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
                <title><?php echo CHtml::encode(Yii::app()->user->aplicacion->nombre).' - '.CHtml::encode(Yii::app()->name); ?></title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/assets/font-awesome/4.2.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->
                <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/jquery-ui.custom.min.css" />
                <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/jquery.gritter.min.css" />
                
		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/assets/fonts/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />                
                
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->
                <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/dropzone.min.css" />
                
		<!-- ace settings handler -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/html5shiv.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/respond.min.js"></script>
		<![endif]-->
                <?php Yii::app()->clientScript->registerCoreScript('jquery.ui');?>
                <?php Yii::app()->clientScript->registerCoreScript('cookie');?>
                <script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.gritter.min.js"></script>
	</head>

	<body class="no-skin">
                <?php $uri = explode('/', $_SERVER['REQUEST_URI']);?>
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>
                        
			<div class="navbar-container" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
                                    <a href="<?php echo Yii::app()->createUrl('/site/index');?>" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							<?php echo CHtml::encode(Yii::app()->user->aplicacion->nombre); ?>
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Hola,</small>
									<?php echo Yii::app()->user->name;?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                                                <li>
                                                                    <a href="<?php echo Yii::app()->createUrl('site/settings')?>">
										<i class="ace-icon fa fa-cog"></i> Configuración
									</a>
								</li>

								<li class="divider"></li>
                                                                
								<li>
									<a href="<?php echo Yii::app()->createUrl('/site/logout');?>">
										<i class="ace-icon fa fa-power-off"></i>
										Cerrar Session
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

                                <div class="sidebar-shortcuts" id="sidebar-shortcuts" style="text-align: left;">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                                            <a href="<?php echo Yii::app()->createUrl('/site/index');?>" class="toolt tooltip-warning btn btn-warning" data-placement="right" title="Inicio">
							<i class="ace-icon fa fa-home"></i>
						</a>
						<a href="<?php echo Yii::app()->createUrl('/menu/index');?>" class="toolt tooltip-success btn btn-success" data-placement="right" title="Ir al menú">
							<i class="ace-icon fa fa-list"></i>
						</a>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->
                                
				<ul class="nav nav-list">
                                    
                                        <?php if(Yii::app()->user->checkAccess('encargado',array(Yii::app()->user->id))) {?>
                                            <li class="<?php echo ($uri[1]=='usuarios') ? 'active' : ''?>">
                                                <a href="<?php echo Yii::app()->createUrl('/usuarios/admin'); ?>">
                                                            <i class="menu-icon fa fa-users"></i>
                                                            <span class="menu-text"> Usuarios </span>
                                                    </a>

                                                    <b class="arrow"></b>
                                            </li>
                                        <?php }?>

                                        <?php if(Yii::app()->user->checkAccess('encargado',array(Yii::app()->user->id))) {?>
                                            <li class="<?php echo ($uri[1]=='productos') ? 'active' : ''?>">
                                                    <a href="<?php echo Yii::app()->createUrl('/productos/admin');?>">
                                                            <i class="menu-icon fa fa-cutlery"></i>
                                                            <span class="menu-text"> Productos </span>
                                                    </a>

                                                    <b class="arrow"></b>
                                            </li>
                                        <?php }?>
                                            
                                        <?php if(Yii::app()->user->checkAccess('encargado',array(Yii::app()->user->id))) {?>
                                            <li class="<?php echo ($uri[1]=='categorias') ? 'active' : ''?>">
                                                    <a href="<?php echo Yii::app()->createUrl('/categorias/admin');?>">
                                                            <i class="menu-icon fa fa-tag"></i>
                                                            <span class="menu-text"> Categorías </span>
                                                    </a>

                                                    <b class="arrow"></b>
                                            </li>
                                        <?php }?>
                                            
                                        <?php if(Yii::app()->user->checkAccess('encargado',array(Yii::app()->user->id))) {?>
                                            <li class="<?php echo ($uri[1]=='mesas') ? 'active' : ''?>">
                                                    <a href="#" class="dropdown-toggle">
                                                            <i class="menu-icon glyphicon glyphicon-stop"></i>
                                                            <span class="menu-text"> Mesas </span>

                                                            <b class="arrow fa fa-angle-down"></b>
                                                    </a>

                                                    <b class="arrow"></b>
                                                    <ul class="submenu">
                                                            <li class="<?php echo ($uri[1]=='mesas' && $uri[2]=='index') ? 'active' : ''?>">
                                                                    <a href="<?php echo Yii::app()->createUrl('/mesas/index');?>">
                                                                            <i class="menu-icon fa fa-caret-right"></i>
                                                                            Vista de Mesas
                                                                    </a>

                                                                    <b class="arrow"></b>
                                                            </li>
                                                            <li class="<?php echo ($uri[1]=='mesas' && ($uri[2]=='admin' || $uri[2]=='create')) ? 'active' : ''?>">
                                                                    <a href="<?php echo Yii::app()->createUrl('/mesas/admin');?>">
                                                                            <i class="menu-icon fa fa-caret-right"></i>
                                                                            Administrador de mesas
                                                                    </a>

                                                                    <b class="arrow"></b>
                                                            </li>
                                                    </ul>
                                            </li>
                                        <?php }?>
                                            
                                        <?php if(Yii::app()->user->checkAccess('encargado',array(Yii::app()->user->id))) {?>
                                            <li class="<?php echo ($uri[1]=='pedidos') ? 'active' : ''?>">
                                                    <a href="<?php echo Yii::app()->createUrl('/pedidos/admin');?>">
                                                            <i class="menu-icon fa fa-list-alt"></i>
                                                            <span class="menu-text"> Pedidos </span>
                                                    </a>

                                                    <b class="arrow"></b>
                                            </li>
                                        <?php }?>
                                            
                                        <?php if(Yii::app()->user->checkAccess('encargado',array(Yii::app()->user->id))) {?>
                                            <li class="<?php echo ($uri[1]=='ordenes') ? 'active' : ''?>">
                                                    <a href="<?php echo Yii::app()->createUrl('ordenes');?>">
                                                            <i class="menu-icon glyphicon glyphicon-pencil"></i>
                                                            <span class="menu-text"> Ordenes </span>
                                                    </a>

                                                    <b class="arrow"></b>
                                            </li>
                                        <?php }?>

                                        <?php if(Yii::app()->user->checkAccess('cocina',array(Yii::app()->user->id))) {?>
                                            <li class="<?php echo ($uri[1]=='cocina') ? 'active' : ''?>">
                                                <a href="<?php echo Yii::app()->createUrl('cocina');?>">
                                                    <i class="menu-icon glyphicon glyphicon-fire"></i>
                                                    <span class="menu-text"> Cocina </span>
                                                </a>

                                                <b class="arrow"></b>
                                            </li>
                                        <?php }?>
                                                                                                                        
                                        <?php if(Yii::app()->user->checkAccess('superadmin',array(Yii::app()->user->id))) {?>
                                            <li class="<?php echo ($uri[1]=='aplicacion') ? 'active' : ''?>">
                                                    <a href="<?php echo Yii::app()->createUrl('/aplicacion/index');?>">
                                                            <i class="menu-icon fa fa-coffee"></i>
                                                            <span class="menu-text"> Aplicaciones </span>
                                                    </a>

                                                    <b class="arrow"></b>
                                            </li>
                                        <?php }?>
                                        <?php if(Yii::app()->user->checkAccess('superadmin',array(Yii::app()->user->id))) {?>
                                            <li class="<?php echo ($uri[1]=='roles') ? 'active' : ''?>">
                                                    <a href="<?php echo Yii::app()->createUrl('/roles/admin');?>">
                                                            <i class="menu-icon fa fa-pencil-square-o"></i>
                                                            <span class="menu-text"> Roles </span>
                                                    </a>

                                                    <b class="arrow"></b>
                                            </li>
                                        <?php }?>
                                             
                                        <?php if(Yii::app()->user->checkAccess('superadmin',array(Yii::app()->user->id))) {?>
                                            <li class="<?php echo ($uri[1]=='empresa') ? 'active' : ''?>">
                                                    <a href="<?php echo Yii::app()->createUrl('/empresa/admin');?>">
                                                            <i class="menu-icon fa fa-folder-open "></i>
                                                            <span class="menu-text"> Empresas </span>
                                                    </a>

                                                    <b class="arrow"></b>
                                            </li>
                                        <?php }?>
                                        
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

                                                <ul class="breadcrumb">
                                                    <li>
                                                        <i class="ace-icon fa fa-home home-icon"></i>
                                                        <a href="<?php echo Yii::app()->createUrl('/site/index')?>">Inicio</a>
                                                    </li>
                                                    <?php if(isset($this->breadcrumbs)):?>
                                                            <?php foreach($this->breadcrumbs as $key => $bread)
                                                            {
                                                                $arrK = array_keys($this->breadcrumbs);
                                                                if(end($arrK)==$bread)
                                                                    $calss = "active";
                                                                else
                                                                    $calss = "";
                                                                if(is_array($bread))
                                                                    echo '<li class="'.$calss.'"><a href="'.$bread[0].'">'.$key.'</a></li>';
                                                                else
                                                                    echo '<li class="'.$calss.'">'.$bread.'</li>';
                                                            }
                                                            ;?><!-- breadcrumbs -->
                                                    <?php endif?>
                                                </ul><!-- /.breadcrumb -->
					</div>

					<div class="page-content">
                                            <?php echo $content; ?>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Comandas</span>
							.com.ar &copy; 2015
						</span>

						&nbsp; &nbsp;
                                                <!--
						<span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span>
                                                -->
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<!--<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.2.1.1.min.js"></script>-->

		<!-- <![endif]-->

		<!--[if IE]>
                <script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.1.11.1.min.js"></script>
                <![endif]-->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
                <script type="text/javascript">
                 window.jQuery || document.write("<script src='<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery1x.min.js'>"+"<"+"/script>");
                </script>
                <![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery-ui.custom.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.easypiechart.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.sparkline.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.flot.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.flot.pie.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.flot.resize.min.js"></script>
                <script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/bootbox.min.js"></script>
                <script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/dropzone.min.js"></script>

		<!-- ace scripts -->
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/ace-elements.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/ace.min.js"></script>
                
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//tooltips
				$( ".toolt" ).tooltip({
					show: {
						effect: "slideDown",
						delay: 250,
                                                position: 'bottom',
					}
				});
                                $('[data-rel=popover]').popover({html:true});                                
			
				//show the dropdowns on top or bottom depending on window height and menu position
				$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
					var offset = $(this).offset();
			
					var $w = $(window)
					if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
						$(this).addClass('dropup');
					else $(this).removeClass('dropup');
				});
			
			})
		</script>
	</body>
</html>
