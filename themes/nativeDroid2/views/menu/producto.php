<div data-role="navbar" data-grid="d">
    <ul>        
        <li style="min-width: 20%; width: auto;"><a href="<?php echo Yii::app()->createUrl('menu/categoria',array('categoria'=>$categoriaFrom->id));?>"><?php echo $categoriaFrom->nombre.' >';?></a></li>
        <li style="min-width: 20%; width: auto;"><a href="#" class="ui-btn-active"><?php echo $producto->nombre;?></a></li>
    </ul>
</div>

<div class="nd2-card">

	<div class="card-media">
                <div class="swiper-container" style="width:100%">
                    <div class="swiper-wrapper">
                        <?php
                        if($producto->productosImagenes) {
                            foreach ($producto->productosImagenes as $image)
                                echo '<div class="swiper-slide"><img style="max-width:auto; max-height:100%" src="/images/productos/'.$image->nombre.'"/></div>';                            
                        }
                        else
                            echo '<div class="swiper-slide"><img src="/images/noimage.jpg"/></div>';
                        ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
	</div>
        <div class='card-supporting-text has-action'>

                <div class="card-title has-supporting-text">
                        <h3 class="card-primary-title"><?php echo $producto->nombre;?></h3>
                        <h5 class="card-subtitle"><?php echo $producto->descripcion;?></h5>
                        <span class="card-primary-title" style="float:right;font-size: 1.5em;"><?php echo '$ '.$producto->precio;?></span>
                </div>
                
                <?php if(isset(Yii::app()->user->usuario)) { ?>
                <div class="card-action">
                        <div class="row between-xs">
                                <div class="col-xs-12">
                                        <div class="box">
                                                <a href="#popupPedir" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" data-transition="pop"><i class='lIcon fa fa-external-link'></i> Pedir</a>
                                        </div>
                                </div>
                        </div>
                </div>
                <?php } ?>
        </div>
</div>


<div data-role='popup' id='popupPedir'>
    <div data-role='header'>
        <h1>Solicitud de producto</h1>
    </div>
    <div data-role='content'>
        <p class="msgPopup">Usted esta por solicitar este producto. Recuerde que para cancelar la solicitud debera solicitarlo al personal.</p>
        <p class="popResponse"><p>
        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'pedido-form'
        )); ?>
        <?php if(Yii::app()->user->checkAccess('comensal1') || Yii::app()->user->checkAccess('comensal') || Yii::app()->user->checkAccess('camarero')) { ?>
            <div class="ui-grid-a" style="text-align: center;">
                <ul data-role="listview" data-inset="true">            
                    <?php
                    if(Yii::app()->user->checkAccess('camarero'))
                    {                
                        echo '<li data-role="fieldcontain">';
                        echo $form->dropDownList(
                                $pedido,
                                'mesas_id',
                                CHtml::listData(Mesas::model()->findAllByAttributes(array('aplicacion_id'=>Yii::app()->user->aplicacion->id),'id != 1'), 'id', 'nro_mesa'),
                                array('empty'=>'Seleccione la mesa')
                                );
                        echo '</li>';
                    }
                    foreach ($producto->productosOpciones as $opcion)
                    {
                        echo '<li data-role="fieldcontain">';
                        echo $form->dropDownList(
                                $pedidosHasProductos,
                                'selected_option[]',
                                CHtml::listData($opcion->productos, 'id', 'nombre'),
                                array('empty'=>$opcion->nombre)
                                );
                        echo '</li>';
                    }
                    ?>
                    <li data-role="fieldcontain">
                        <?php echo $form->textArea($pedidosHasProductos, 'observaciones',array('size'=>200,'maxlength'=>200,'placeholder'=>'Observaciones...'))?>
                        <?php echo $form->hiddenField($pedidosHasProductos,'productos_id',array('value'=>$producto->id)); ?>
                    </li>
                    <li data-role="fieldcontain">
                        <legend>Cantidad</legend>
                        <select name="cantidad">
                            <?php
                            for($i=1; $i<=10; $i++) {
                                echo "<option value='{$i}'>{$i}</option>";
                            }
                            ?>
                        </select>
                    </li>
                </ul>
            </div>
        <?php }?>
        <?php $this->endWidget(); ?>
        <button id="pedirBtn" data-role="button" data-inline="true" onclick="menu.producto.realizarPedido();" class="ui-btn ui-btn-primary">Aceptar</button>
        <a href="#" data-rel="back" data-role="button" data-inline="true" class="ui-btn ui-btn-primary">Cancelar</a>
    </div>
</div>
    <!-- Demo styles -->
    <style>
    body {
        background: #eee;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color:#000;
        margin: 0;
        padding: 0;
    }
    .swiper-container {
        width: 500px;
        height: 300px;
        margin: 20px auto;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    </style>