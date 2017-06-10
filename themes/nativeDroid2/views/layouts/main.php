<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
                
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/jquery.mobile.1.4.5.min.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/vendor/waves/waves.min.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/vendor/wow/animate.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/nativedroid2.css" />
                <link rel="stylesheet" href="/plugins/Swiper-master/dist/css/swiper.min.css" />

		<meta name="mobile-web-app-capable" content="yes">
	 	<meta name="apple-mobile-web-app-capable" content="yes" />
                <meta name="apple-mobile-web-app-status-bar-style" content="black" />

	</head>
	<body>
		<div data-role="page">

			<!-- panel left -->
			<div data-role="panel" id="leftpanel" data-display="overlay" data-position-fixed="true" >
                                <?php if(isset(Yii::app()->user->usuario)){?>
				<div class='nd2-sidepanel-profile wow fadeInDown'>
					<img class='profile-background' src="<?php echo Yii::app()->theme->baseUrl;?>/img/profile.png" />
					<div class="row">
						<div class='col-xs-4 center-xs'>
							<div class='box'>
								<img class="profile-thumbnail" src="/images/noimage.jpg" />
							</div>
						</div>
						<div class='col-xs-8'>
							<div class='box profile-text'>
								<strong><?php echo Yii::app()->user->usuario->nombre; ?></strong>
								<span class='subline'></span>
							</div>
						</div>
					</div>
				</div>
                                <?php }?>

				<ul data-role="listview" data-inset="false">
					<li data-role="list-divider">Categorias</li>
				</ul>
                            
                                <ul data-role="listview" data-inset="false" data-icon="false">
                                        <?php
                                        if($this->categorias)
                                            foreach ($this->categorias as $categoria)
                                                echo '<li><a data-ajax="false" data-icon="false" href="'.Yii::app()->createUrl('menu/categoria',array('categoria'=>$categoria->id)).'">'.$categoria->nombre.'</a></li>';
                                        else
                                            echo '<li><a href="#" data-ajax="false" data-icon="false">No hay categorias disponibles</a></li>';
                                        ?>
                                </ul>

				<hr class="inset">
				<ul data-role="listview" data-inset="false">
					<li data-role="list-divider">Informacion</li>
				</ul>
				<div data-role="collapsible" data-inset="false" data-collapsed-icon="carat-d" data-expanded-icon="carat-d" data-iconpos="right">
					<h3>Consultas</h3>
					<ul data-role="listview" data-icon="false">
						<li><a href="/info/colors_and_styles.html" data-ajax='false'>Colors &amp; Styles</a></li>
						<li><a href="/info/credits.html" data-ajax='false'>Credits &amp; License</a></li>
					</ul>
				</div>
			</div>
			<!-- /panel left -->

			<div data-role="panel" id="bottomsheet" data-animate="false" data-position='bottom' data-display="overlay">
                            <div class='row around-xs'>
                                    <?php if(!isset(Yii::app()->user->usuario)) {?>
                                    <div class='col-xs-auto'>
                                            <a href='#popupDialog' data-rel="popup" data-position-to="window" data-role="button" data-inline="true" data-transition="pop" class='ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button waves-effect waves-button'><i class='zmdi zmdi-account-o zmd-2x'></i><strong>Comenzar</strong></a>
                                    </div>
                                    <?php } else  {?>
                                    <div class='col-xs-auto'>
                                            <a href='<?php echo Yii::app()->createUrl('/menu/mispedidos')?>' class='ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button waves-effect waves-button' data-ajax='false'><i class='fa fa-list-alt fa-2x'></i><strong>Mis pedidos</strong></a>
                                    </div>
                                    <?php } ?>
                                    <div class='col-xs-auto'>
                                            <a href='#' class='ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button waves-effect waves-button' data-ajax='false'><i class='fa fa-facebook-official fa-2x'></i><strong>Compartir</strong></a>
                                    </div>
                                    <div class='col-xs-auto'>
                                            <a href='<?php echo Yii::app()->createUrl('/menu')?>' class='ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button waves-effect waves-button' data-ajax='false'><i class='fa fa-home fa-2x'></i><strong>Inicio</strong></a>
                                    </div>
                            </div>
			</div>

			<div data-role="header" data-position="fixed" class="wow fadeInDown" data-wow-delay="0.2s">
				<a href="#bottomsheet" class="ui-btn ui-btn-right wow fadeIn" data-wow-delay='1.2s'><i class="zmdi zmdi-more-vert"></i></a>
				<a href="#leftpanel" class="ui-btn ui-btn-left wow fadeIn" data-wow-delay='0.8s'><i class="zmdi zmdi-menu"></i></a>
                                <h1 class="wow fadeIn" data-wow-delay='0.4s'><a href="/menu" style="color: white; text-decoration: blink;"><?php echo CHtml::encode(Yii::app()->user->aplicacion->nombre);?></a></h1>
			</div>

			<div role="main" class="ui-content" data-inset="false">
				<?php echo $content; ?>
                                <div data-role="popup" id="popupDialog">
                                        <div data-role="header">
                                                <h1 class='nd-title'>Bienvenido!</h1>
                                        </div>

                                        <div data-role="content">
                                            <form id="registro-form">
                                                <label for="name2b">Ingresá tu nombre para comenzar a pedir</label>
                                                <input type="text" name="nombre" id="nombre" value="" data-clear-btn="true" placeholder="Nombre">
                                                <span class="clr-red" id="error-msg"></span>
                                                <button data-rel="back" id="registrar" data-role="button" data-inline="true" class="ui-btn ui-btn-primary"><i class='zmdi zmdi-check'></i> Comenzar</button>
                                                <button data-rel="back" data-role="button" data-inline="true" class="ui-btn ui-btn-primary"><i class='zmdi zmdi-cancel'></i> Cancelar</button>
                                            </form>
                                        </div>
                                </div>
                            
                                <?php Yii::app()->clientScript->registerScript('registrarComensal', "
                                    $('#registrar').click(function() {
                                    $.ajax({
                                        method: 'POST',
                                        url: '".Yii::app()->createUrl('usuarios/createComensal')."',
                                        data: $('#registro-form').serialize()
                                    })
                                    .done(function( rta ) {
                                        var obj = jQuery.parseJSON( rta );
                                        if(obj.success)
                                            location.reload();
                                        else {
                                            $('#error-msg').html('');
                                            $.each(obj.err, function(key,val){
                                                $('#error-msg').append(val);
                                            });
                                        }
                                    });
                                    return false;
                                });
                                ",  CClientScript::POS_LOAD);
                                Yii::app()->clientScript->registerScript('pageLoaded', "
                                    $(document).on('pagebeforecreate', '[data-role=\"page\"]', function(){     
                                        var interval = setInterval(function(){
                                            $.mobile.loading('show');
                                            clearInterval(interval);
                                        },1);    
                                    });

                                    $(document).on('pageshow', '[data-role=\"page\"]', function(){  
                                        var interval = setInterval(function(){
                                            $.mobile.loading('hide');
                                            clearInterval(interval);
                                        },300);      
                                    });
                                ",  CClientScript::POS_LOAD);
                                Yii::app()->clientScript->registerScript('ppp', "
                                    $( '#popupDialog' ).bind({
                                        popupbeforeposition: function(event, ui) {
                                            $( '#bottomsheet' ).panel( 'close' );
                                        }
                                    });
                                ",  CClientScript::POS_LOAD);
                                ?>
			</div>

		</div>

		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.2.1.4.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery-ui.1.11.4.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.mobile.1.4.5.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/vendor/waves/waves.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/vendor/wow/wow.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/nativedroid2.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl;?>/nd2settings.js"></script>
                <script src="/plugins/Swiper-master/dist/js/swiper.min.js"></script>
	</body>
</html>
