<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo CHtml::encode(Yii::app()->name); ?></title>

<!-- Bootstrap core CSS -->
<link href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/bootstrap.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/main.css" rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/animate-custom.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/modernizr.custom.js"></script>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body data-spy="scroll" data-offset="0" data-target="#navbar-main">
<div id="navbar-main"> 
  <!-- Fixed navbar -->
  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a class="navbar-brand" href="#home"><i class="fa fa-leaf"></i> <?php echo CHtml::encode(Yii::app()->name); ?></a> </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#home" class="smoothScroll">Inicio</a></li>
          <li> <a href="#about" class="smoothScroll">Nosotros</a></li>
          <li> <a href="#services" class="smoothScroll">Servicios</a></li>
          <li> <a href="#team" class="smoothScroll">Equipo</a></li>
          <li> <a href="#contact" class="smoothScroll">Contacto</a></li>
          <li> <a data-toggle="modal" href="#loginModal">Login</a></li>          
        </ul>
      </div>
      <!--/.nav-collapse --> 
    </div>
  </div>
</div>

<!-- ==== HEADERWRAP ==== -->
<div id="headerwrap" name="home">
    <header class="clearfix">
        <h1>Legá a tus comensales de una manera nueva con el menú digital de comandas.</h1>
        <p>Facilitamos la llegada del menú a tus comensales, además de agilizar y otimizar el camino del pedido desde al comensal hasta la cocina.</p>
        <!--<a href="#portfolio" class="smoothScroll btn btn-lg">See Our Works</a>-->
    </header>
</div>
<!-- /headerwrap --> 

<!-- ==== ABOUT ==== -->
<div id="about" name="about">
  <div class="container">
    <div class="row white">
      <div class="col-md-6"> <img class="img-responsive" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/img/about/about1.jpg" align=""> </div>
      <div class="col-md-6">
        <h3>Nosotros</h3>
        <p>Apasionados tanto por el mundo web como por el universo gastronómico, desarrollamos soluciones para los actores ya establecidos de la gastronomía, como para los emergentes.</p>
        <h3>¿Por qué elegirnos?</h3>
        <p>Nuestra política de trabajo es de mejoras continuas y creamos soluciones a medida evaluando la problemática de cada establecimiento en particular.</p>
      </div>
    </div>
    <!-- row --> 
  </div>
</div>
<!-- container --> 

<!-- ==== SERVICES ==== -->
<div id="services" name="services">
  <div class="container">
    <div class="row">
      <h2 class="centered">Nuestros servicios</h2>
      <hr>
      <div class="col-lg-8 col-lg-offset-2">
        <p class="large">En Comandas.com.ar tenemos diferentes soluciones para cada tipo de establecimiento gastronómico. Desde foodtrucks y take away's, hasta grandes restaurantes.</p>
      </div>
      <div class="col-lg-3 callout"> <i class="fa fa-exchange fa-3x"></i>
        <h3>Take away o fast food</h3>
        <p>Este servicio está pensado para establecimientos cuyo flujo del pedido sea primero el pedido, luego el pago y por último la entrega del producto.</p>
      </div>
      <div class="col-lg-3 callout"> <i class="fa fa-cutlery  fa-3x"></i>
        <h3>Restaurantes</h3>
        <p>Este servicio está pensado para restaurantes cuyo flujo de pedidos sea primero el pedido, luego lo recibe y por último el pago.</p>
      </div>
      <div class="col-lg-3 callout"> <i class="fa fa-gears fa-3x"></i>
        <h3>Integración con otros sistemas</h3>
        <p>El desarrollo a medida se manifiesta con la posibilidad de adaptarnos y trabajar en conjunto junto a otros sistemas de gestion o facturación.</p>
      </div>
      <div class="col-lg-3 callout"> <i class="fa fa-dot-circle-o fa-3x"></i>
        <h3>Redes sociales</h3>
        <p>Hoy en dia las redes sociales son de gran ayuda en nuestros negocios. Esto lo sabemos y es por eso que en comandas.com.ar les ofrecemos a los comensales la posibilidad de compartir su experiencia con su entorno social</p>
      </div>
                
    </div>
    <!-- row --> 
  </div>
</div>
<!-- container --> 


<!-- ==== TEAM MEMBERS ==== -->
<div id="team" name="team">
  <div class="container">
    <div class="row centered">
      <h2 class="centered">Nuestro equipo</h2>
      <hr>
      <div class="col-lg-6 centered"> <img class="img img-circle" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/img/team/team02.jpg" height="120px" width="120px" alt="">
        <h4>Diego Sanabria</h4>
        <p>Fundador y responsable tecnico.</p>
        <a href="#"><i class="fa fa-linkedin"></i></a> </div>
      <div class="col-lg-6 centered"> <img class="img img-circle" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/img/team/team01.jpg" height="120px" width="120px" alt="">
        <h4>María Pia Sanabria</h4>
        <p>Responsable del area de arte e imágen</p>
        <a href="#"><i class="fa fa-linkedin"></i></a> </div>
      <!--<div class="col-lg-3 centered"> <img class="img img-circle" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/img/team/team03.jpg" height="120px" width="120px" alt="">
        <h4>Michele Doe</h4>
        <p>Albucius consectetuer eu nam. Saepe legendos vulputate eu quo, id mea comprehensam signifer.</p>
        <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-linkedin"></i></a> </div>
      <div class="col-lg-3 centered"> <img class="img img-circle" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/img/team/team04.jpg" height="120px" width="120px" alt="">
        <h4>Larry Evans</h4>
        <p>Albucius consectetuer eu nam. Saepe legendos vulputate eu quo, id mea comprehensam signifer.</p>
        <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-linkedin"></i></a> </div>      
      <div class="col-lg-8 col-lg-offset-2 centered">
        <p class="large">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
      </div>
      -->
    </div>
  </div>
  <!-- row --> 
</div>
<!-- container --> 

<!-- ==== CONTACT ==== -->
<div id="contact" name="contact">
  <div class="container">
    <div class="row">
      <h2 class="centered">Contactanos</h2>
      <hr>
      <div class="col-md-4 centered"> <i class="fa fa-map-marker fa-2x"></i>
        <p>Amenabar 3136<br>
          Buenos Aires, CABA</p>
      </div>
      <div class="col-md-4"> <i class="fa fa-envelope-o fa-2x"></i>
        <p>info.comandas@gmail.com</p>
      </div>
      <div class="col-md-4"> <i class="fa fa-phone fa-2x"></i>
        <p> +54 911 6105 6636</p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 centered">
        <p>Dejanos tus dudas o comentarios y nos pondremos en contacto con tigo.</p>
        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'contact-form',
                'action'=>'/site/home#contact',
                'enableClientValidation'=>false,
                'clientOptions'=>array(
                        'validateOnSubmit'=>false,
                ),
                'htmlOptions'=>array(
                    'class'=>'form'
                )
        )); ?>
                <?php if(Yii::app()->user->hasFlash('contact')){?>
                <div class="row">
                    <div class="col-xs-12 form-group text-success alert alert-success">
                        <?php echo Yii::app()->user->getFlash('contact');?>
                    </div>
                </div>
                <?php }?>
                <div class="row">
                    <div class="col-xs-6 col-md-6 form-group">
                        <?php echo $form->textField($contact,'name',array('class'=>'form-control','placeholder'=>'Nombre *')); ?>
                        <?php echo $form->error($contact,'name',array('style'=>'color:red;')); ?>
                    </div>
                    <div class="col-xs-6 col-md-6 form-group">
                        <?php echo $form->textField($contact,'email',array('class'=>'form-control','placeholder'=>'Email *')); ?>
                        <?php echo $form->error($contact,'email',array('style'=>'color:red;')); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        <?php echo $form->textField($contact,'subject',array('size'=>60,'maxlength'=>128,'class'=>'form-control','placeholder'=>'Asunto *')); ?>
                        <?php echo $form->error($contact,'subject',array('style'=>'color:red;')); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        <?php echo $form->textArea($contact,'body',array('rows'=>6, 'cols'=>50,'class'=>'form-control','placeholder'=>'Mensaje *')); ?>
                        <?php echo $form->error($contact,'body',array('style'=>'color:red;')); ?>
                    </div>
                </div>

                <?php if(CCaptcha::checkRequirements()): ?>
                <div class="row">
                        <?php echo $form->labelEx($contact,'verifyCode'); ?>
                        <div>
                        <?php $this->widget('CCaptcha'); ?>
                        <?php echo $form->textField($contact,'verifyCode'); ?>
                        </div>
                        <div class="hint">Please enter the letters as they are shown in the image above.
                        <br/>Letters are not case-sensitive.</div>
                        <?php echo $form->error($contact,'verifyCode'); ?>
                </div>
                <?php endif; ?>

                <div class="row buttons">
                    <div class="col-xs-12 col-md-12">
                        <?php echo CHtml::submitButton('Enviar',array('class'=>'btn btn-lg')); ?>
                    </div>		
                </div>

        <?php $this->endWidget(); ?>
        <!-- form --> 
      </div>
    </div>
    <!-- row --> 
        
  </div>
</div>
<!-- container -->

<div id="footerwrap">
  <div class="container">
    <div class="row">
      <div class="col-md-8"> <!--<span  class="copyright">Copyright &copy; 2015 Ascend. Design by <a href="http://www.templategarden.com" rel="nofollow">TemplateGarden</a></span>--> </div>
      <div class="col-md-4">
        <ul class="list-inline social-buttons">
          <li><a href="#"><i class="fa fa-twitter"></i></a> </li>
          <li><a href="#"><i class="fa fa-facebook"></i></a> </li>
          <li><a href="#"><i class="fa fa-linkedin"></i></a> </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/retina.js"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.easing.1.3.js"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/smoothscroll.js"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery-func.js"></script>
</body>
</html>

    
<?php Yii::app()->clientScript->registerScript('login', "
    $('#loguear').click(function() {
    $.ajax({
        method: 'POST',
        url: '".Yii::app()->createUrl('site/login')."',
        data: $('#login-form').serialize()
    })
    .done(function( rta ) {
        var obj = jQuery.parseJSON( rta );
        if(obj.success)
            window.location = '".Yii::app()->createUrl('site/index')."'
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
