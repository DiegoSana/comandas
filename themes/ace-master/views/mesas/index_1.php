<style>
    .drag { width: 50px; height: 50px; padding: 0.5em; display: inline-block; }
</style>
<script>
$.cookie.json = true;
$(function() {
    $( ".drag" ).draggable({
        cursor: "move",
        containment: $("#dragZone"),
        stop: function( event, ui ) {
            $.ajax({
                method: "POST",
                url: "<?php echo Yii::app()->createUrl('mesas/savePosition');?>",
                data: { idm: this.id, top: ui.position.top, left: ui.position.left }
            }).done(function( msg ) {
                return true;
                //console.log(msg);
            });
            /*$.cookie(this.id+'-top',ui.offset.top);
            $.cookie(this.id+'-left',ui.offset.left);*/
        }
    });
});
$( "#tikets-dialog" ).dialog({
  close: function( event, ui ) {alert('333');}
});
</script>
<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'mesas-form',
	'enableAjaxValidation'=>false,
));
/* @var $this MesasController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	'Mesas',
);

$this->menu=array(
	array('label'=>'Crear Mesas', 'url'=>array('create')),
	array('label'=>'Administrar Mesas', 'url'=>array('admin')),
);

echo '<h1>Mesas</h1>';
echo $form->dropDownList(
            $aplicacion,
            'id',
            CHtml::listData(Aplicacion::model()->search()->getData(), 'id', 'nombre'),
            array('empty'=>'Seleccione una aplicacion...','onchange'=>'this.form.submit()')
        );
echo CHtml::button('Crear tikets', array('onclick'=>'$("#tikets-dialog").dialog("open"); return false;'));
?>
<?php
$maxTop=50;
foreach ($dataProvider->data as $mesa) {    
    if($mesa->posicion) {
        $pos = json_decode($mesa->posicion,true);
        if($maxTop<($pos['top']+50)) $maxTop = $pos['top']+50;
    }
}
$maxTop .= 'px';
?>
<div id="dragZone" style="min-height:500px;" class="flash-success">
    <?php
        foreach ($dataProvider->data as $mesa) {
            $posStyle='';
            if($mesa->posicion) {
                $pos = json_decode($mesa->posicion,true);
                $posStyle = 'left:'.$pos['left'].'px;top:'.$pos['top'].'px;';
        }
        ?>
            <div id="<?php echo $mesa->id;?>" class="flash-notice drag" style="<?php echo $posStyle;?>">
                <p><?php echo CHtml::encode('Mesa '.$mesa->nro_mesa); ?></p>
                <?php echo CHtml::encode($mesa->aplicacion->nombre); ?>
            </div>
        <?php
    }
    ?>
</div>
<?php $this->endWidget(); ?>









<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'tikets-dialog',
    //'theme'=>'redmond',
    //'themeUrl'=>Yii::app()->request->baseUrl.'/css/ui',
    'options'=>array(
        'title'=>'Generador de tikets',
        'autoOpen'=>false,
        'modal'=>true,
        //'width'=>350,
        //'close' => 'js:function(){ $("#tikets-form").reset();$("#rta").fadeOut(); }'
    ),
));
echo '<div class="form">';
        $form=$this->beginWidget('CActiveForm', array(
                'id'=>'tikets-form',
                'enableAjaxValidation'=>false,
        ));
        $pedido = new Pedidos();
        echo '<div id="rta" style="display:none;"></div>';
        echo '<div class="row">';
            echo $form->dropDownList(
                    $pedido,
                    'mesas_id',
                    CHtml::listData(Mesas::model()->findAllByAttributes(array('aplicacion_id'=>$aplicacion->id)), 'id', 'nro_mesa'),
                    array('empty'=>'Seleccione una mesa...')
                    );
        echo '</div>';
        echo '<div class="row">';
            $this->widget('zii.widgets.jui.CJuiSliderInput',array(
                                'name' => 'cantidad', 
                                'model'=>$pedido,
                                'attribute'=>"cantidad",
                                'event'=>'change',
                                'value'=>'0',
                              'options'=>array(
                                  'min'=>0,
                                  'max'=>40,
                                  'animate' => true,
                                  'slide'=>'js:function(event,ui){$("#cant").html(ui.value);}',
                              ),
            ));
        echo '</div>';
        echo '<div class="row"><span id="cant">0</span> tikets</div>';
        echo '<div class="row">';
            echo CHtml::ajaxButton(
                    'Generar',
                    Yii::app()->createUrl('pedidos/create'),
                    array(
                        'method'=>'POST',
                        'data'=>'js:$("#tikets-form").serialize()',
                        'success'=>'function(data){if(data=="ok"){ $("#rta").html("Creadas con exito").addClass("flash-success").fadeIn(); }else{ $("#rta").html("Se produjo un error").addClass("flash-error").fadeIn();}}'
                        )
                    );
            echo CHtml::button('Cerrar', array('onclick'=>'js:$("#tikets-form")[0].reset();$("#rta").fadeOut();$("#tikets-dialog").dialog("close");'));
        echo '</div>';
        $this->endWidget();
echo '</div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
