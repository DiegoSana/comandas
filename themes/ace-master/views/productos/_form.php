<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productos-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="center" style="float:right;margin: 0 24px 24px;">
                <button class="btn btn-lg btn-success" type="submit">
                        <i class="ace-icon fa fa-check"></i>
                        <?php echo $productos->isNewRecord ? 'Crear' : 'Guardar'; ?>
                </button>
                <?php echo CHtml::link('Cargar imagenes', Yii::app()->createUrl('productosImagenes/index',array('id'=>$productos->id))); ?>
</div>
<div class="col-xs-12"  style="">
<div class="col-lg-6"  style="">
    <div class="widget-box">
        <div class="widget-body">
            <div class="widget-main" style="padding: 30px;">
                <div class="form-group">
                        <?php echo $form->labelEx($productos,'nombre'); ?>
                        <div class="row"><?php echo $form->textField($productos,'nombre',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?></div>
                </div>

                <div class="form-group">
                        <?php echo $form->labelEx($productos,'descripcion'); ?>
                        <div class="row"><?php echo $form->textArea($productos,'descripcion',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?></div>
                </div>

                <div class="form-group">
                        <?php echo $form->labelEx($productos,'precio'); ?>
                        <div class="row"><?php echo $form->textField($productos,'precio',array('class'=>'form-control')); ?></div>
                </div>
                
                <div class="checkbox">
                        <label>
                                <?php echo $form->checkBox($productos,'mostrable',array('class'=>'ace')); ?>
                                <span class="lbl"> Mostrable</span>
                        </label>
                </div>

                <div class="checkbox">
                        <label>
                                <?php echo $form->checkBox($productos,'preparacion_cocina',array('class'=>'ace')); ?>
                                <span class="lbl"> Preparación en cocina</span>
                        </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6"  style="">
    <div class="widget-box">
        <div class="widget-body">
            <div class="widget-main" style="padding: 30px;">
                <div class="form-group">
                    <?php echo $form->errorSummary($productos); ?>
                </div>

                <div class="form-group">
                        <?php echo $form->labelEx($productos,'aplicacion_id'); ?>
                        <div class="row"><?php
                            echo $form->dropDownList(
                                    $productos,
                                    'aplicacion_id',
                                    CHtml::listData(Aplicacion::model()->search()->getData(), 'id', 'nombre'),
                                    array(
                                        'empty'=>'Seleccione una aplicacion...',
                                        'class'=>'form-control',
                                        'ajax'=>array(
                                            'type'=>'POST',
                                            'url'=>  CController::createUrl('productos/getCategoriasXAplicacion'),
                                            'data' => array('appid' => 'js:this.value'),
                                            'success'=> "function(data) {
                                                         obj = JSON.parse(data);
                                                         if(obj.status == 1)
                                                             $('#ProductosHasCategorias_categorias_id').html(obj.msg);
                                                         else
                                                             alert('Se produjo un error');
                                            } ",
                                        )
                                        )
                                    );
                        ?></div>
                </div>

                <div class="form-group" id="last">
                        <?php $categorias = new ProductosHasCategorias;?>
                        <?php echo $form->labelEx($categorias,'categorias_id'); ?>
                        <div class="row"><?php     
                            if($productos->categorias)
                            {
                                $selected   = array();
                                foreach ($productos->categorias as $cat)
                                    $selected[$cat->id] = array('selected' => 'selected');
                                $htmlOptions = array('multiple' => 'multiple','options'=>$selected,'class'=>'form-control');
                                echo $form->ListBox(
                                        $categorias,
                                        'categorias_id',
                                        CHtml::listData(Categorias::model()->findAllByAttributes(array('aplicacion_id'=>$productos->aplicacion_id)), 'id', 'nombre'),
                                        $htmlOptions
                                        ); 
                            }
                            else
                            {
                                echo $form->ListBox(
                                        $categorias,
                                        'categorias_id',
                                        array(''=>'Primero debe seleccionar una aplicación'),
                                        array('multiple' => 'multiple','class'=>'form-control')
                                        );
                            }
                            ?>
                        </div>
                </div>

                <?php
                if($productos->productosOpciones)
                    $opciones = $productos->productosOpciones;
                else
                    $opciones = array();
                    //$opciones[] = new ProductosOpciones;

                foreach ($opciones as $opcion)
                {
                    echo '<div class="widget-box ui-sortable-handle">';
                    echo '<div class="widget-header"><h5 class="widget-title smaller">Nueva Opcion</h5><div class="widget-toolbar"><a href="#" data-action="prpover" aria-describedby="popover37667" data-original-title="Opciones" data-rel="popover" title="" data-content="Las opciones son..."><i class="fa fa-info-circle"></i></a><a href="#" data-action="close"><i class="ace-icon fa fa-times"></i></a></div></div>';
                    echo '<div class="widget-body"><div class="widget-main padding-6"><div class="alert alert-warning">';
                    echo $form->labelEx($opcion,'nombre');
                    echo $form->textField($opcion,'[]nombre',array('class'=>'form-control'));

                    $productosOpcionesHasProductos = new ProductosOpcionesHasProductos;
                    echo $form->labelEx($productosOpcionesHasProductos,'Opciones');
                    $selected   = array();
                    foreach ($opcion->productos as $prod)
                        $selected[$prod->id] = array('selected' => 'selected');
                    $htmlOptions = array('multiple' => 'multiple','options'=>$selected, 'class'=>'form-control');
                    if(Yii::app()->user->checkAccess('superadmin',Yii::app()->user->id))
                        $listProductos = Productos::model ()->findAllByAttributes(array('mostrable'=>false));
                    else
                        $listProductos = Productos::model()->findAllByAttributes(array('aplicacion_id'=>Yii::app()->user->aplicacion->id,'mostrable'=>false));
                    echo $form->ListBox(
                            $productosOpcionesHasProductos,
                            '[]productos_id',
                            CHtml::listData($listProductos, 'id', 'nombre'),
                            $htmlOptions
                            );
                    echo '</div></div></div>';
                    echo '</div>';
                }
                ?>
                <?php echo CHtml::button('Agregar opciones',array('onclick'=>'js:agregarOpcion();','class'=>'btn btn-mini btn-info')); ?>
            </div>
            <!--<div class="form-actions center" style="margin-bottom: 0;">
                <button class="btn btn-lg btn-success" type="submit">
                        <i class="ace-icon fa fa-check"></i>
                        <?php //echo $productos->isNewRecord ? 'Crear' : 'Guardar'; ?>
                </button>
                <?php //echo CHtml::link('Cargar imagenes', Yii::app()->createUrl('productosImagenes/index',array('id'=>$productos->id))); ?>
            </div>-->
        </div>
    </div>
</div>
</div>
<?php $this->endWidget(); ?>
<?php
$productosOpcionesHasProductos = new ProductosOpcionesHasProductos;
$selected   = array();
$htmlOptions = array('multiple' => 'multiple','class'=>'form-control');
$opcion = new ProductosOpciones;
if(Yii::app()->user->checkAccess('superadmin',Yii::app()->user->id))
    $listProductos = Productos::model ()->findAllByAttributes(array('mostrable'=>false));
else
    $listProductos = Productos::model()->findAllByAttributes(array('aplicacion_id'=>Yii::app()->user->aplicacion->id,'mostrable'=>false));
$list = $form->labelEx($opcion,'nombre');
$list .= $form->textField($opcion,'[-k-]nombre',array('class'=>'form-control'));
$list .= $form->labelEx($productosOpcionesHasProductos,'Opciones');
$list .= preg_replace( "/\r|\n/", "",$form->ListBox(
                $productosOpcionesHasProductos,
                '[-k-]productos_id',
                CHtml::listData($listProductos, 'id', 'nombre'),
                $htmlOptions
                ));
?>

<?php Yii::app()->clientScript->registerScript('agregarOpcion','
    window.agregarOpcion = function agregarOpcion()
    {
        var box = \'<div class="widget-box ui-sortable-handle"><div class="widget-header"><h5 class="widget-title smaller">Nueva Opcion</h5><div class="widget-toolbar"><a href="#" data-action="prpover" aria-describedby="popover37667" data-original-title="Opciones" data-rel="popover" title="" data-content="Las opciones son..."><i class="fa fa-info-circle"></i></a><a href="#" data-action="close"><i class="ace-icon fa fa-times"></i></a></div></div><div class="widget-body"><div class="widget-main padding-6"><div class="alert alert-warning"> '.$list.' </div></div></div></div>\';
        box = replaceAll(\'-k-\',Date.now(),box);
        $(box).insertAfter("#last");
    }
        ',  CClientScript::POS_LOAD);?>

<script>
function replaceAll(find, replace,str) { var re = new RegExp(find, 'g'); str = str.replace(re, replace); return str; }
</script>