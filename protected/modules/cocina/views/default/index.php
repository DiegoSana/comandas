<?php $this->breadcrumbs=array(
    'Tareas de cocina',
);?>


<div class="page-header">
    <h1>Tareas de cocina</h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <div class="col-xs-12">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'cocina-grid',
                'dataProvider'=>$pedidos->search(),
                'itemsCssClass'=>'table table-striped table-bordered table-hover',
                'columns'=>array(
                    array(
                        'name'=>'productos.imagenes.nombre',
                        'value'=>'"<img style=\"max-width: 6em;max-height: 6em;\" src=\""."/images/productos/".$data->productos->productosImagenes[0]->nombre."\" />"',
                        'type'=>'raw',
                    ),
                    array(
                        'name'=>'productos_nombre_search',
                        'value'=>'$data->productos->nombre',
                        'htmlOptions' => array('style' => 'font-size: 23px; font-weight: bold;'),
                    ),
                    array(
                        'name'=>'productos.productos_opciones.nombre',
                        'header' => 'Adicionales',
                        'value'=>'formatOpciones($data->productos->productosOpciones, $data->pedidosHasProductoses)',
                        'htmlOptions' => array('style' => 'font-size: 23px; font-weight: bold;'),
                    ),
                    array(
                        'name' => 'obsrvaciones',
                        'htmlOptions' => array('style' => 'font-size: 23px; font-weight: bold;'),
                    ),
                    array(
                        'name'=>'hora_pedido',
                        'filter'=>false,
                        'value'=>'date("d/m H:i:s", strtotime($data->hora_pedido))',
                    ),
                    array(
                        'name'=>'hora_pedido',
                        'header' => 'Tiempo tarnscurrido',
                        'filter'=>false,
                        'value'=>'getTimer($data)',
                        'type'=>'raw'
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template'=>'{update}{delete}',
                        'template'=>'{confirmado}{cocina}{entregado}{cancelado}',
                        'buttons'=>array
                        (
                            'confirmado'=>array(
                                'url'=>'Yii::app()->createUrl("ordenes/confirmar",array("id"=>$data->id))',
                                'label'=>'',
                                'imageUrl'=>'',  //Image URL of the button.
                                'options'=>array('class'=>'conf tooltip-info toolt btn btn-xs btn-info ace-icon glyphicon glyphicon-ok', 'style'=>'display:inline;', 'data-rel'=>'tooltip','title'=>'Confirmar orden'), //HTML options for the button tag.
                                'visible'=>'$data->pedidos_has_productos_estados_id==PedidosHasProductosEstados::SELECCIONADO || $data->pedidos_has_productos_estados_id==PedidosHasProductosEstados::CANCELADO'
                            ),
                            'cocina'=>array(
                                'url'=>'Yii::app()->createUrl("ordenes/cocina",array("id"=>$data->id))',
                                'label'=>'',
                                'imageUrl'=>'',  //Image URL of the button.
                                'options'=>array('class'=>'coock tooltip-warning toolt btn btn-xs btn-warning ace-icon glyphicon glyphicon-cutlery', 'style'=>'display:inline;', 'data-rel'=>'tooltip','title'=>'Enviar a cocina'), //HTML options for the button tag.
                                'visible'=>'$data->pedidos_has_productos_estados_id==PedidosHasProductosEstados::CONFIRMADO'
                            ),
                            'entregado'=>array(
                                'url'=>'Yii::app()->createUrl("ordenes/entregar",array("id"=>$data->id))',
                                'label'=>'',
                                'imageUrl'=>'',  //Image URL of the button.
                                'options'=>array('class'=>'ok tooltip-success toolt btn btn-xs btn-success ace-icon glyphicon glyphicon-check', 'style'=>'display:inline;', 'data-rel'=>'tooltip','title'=>'Entregado'), //HTML options for the button tag.
                                'visible'=>'$data->pedidos_has_productos_estados_id==PedidosHasProductosEstados::COCINA || $data->pedidos_has_productos_estados_id==PedidosHasProductosEstados::CANCELADO || $data->pedidos_has_productos_estados_id==PedidosHasProductosEstados::CONFIRMADO'
                            ),
                            'cancelado'=>array(
                                'url'=>'Yii::app()->createUrl("ordenes/cancelar",array("id"=>$data->id))',
                                'label'=>'',
                                'imageUrl'=>'',  //Image URL of the button.
                                'options'=>array('class'=>'cancel tooltip-error toolt btn btn-xs btn-danger ace-icon glyphicon glyphicon-remove', 'style'=>'display:inline;', 'data-rel'=>'tooltip','title'=>'Cancelar orden'), //HTML options for the button tag.
                                'visible'=>'$data->pedidos_has_productos_estados_id!=PedidosHasProductosEstados::CANCELADO'
                            )
                        )
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>


<?php
Yii::app()->clientScript->registerScript('actions', "
$('#ordenes-grid a.det').click(function() {        
        var url = $(this).attr('href');
        //  do your post request here
        $.post(url,function(res){
            bootbox.dialog({
                    title: 'Detalles del pedido',
                    message: res,
                    buttons: 			
                    {
                            'click' :
                            {
                                    'label' : 'Cerrar',
                                    'className' : 'btn-sm btn-primary'
                            }
                    }
            });
         });
        return false;
});
$('#ordenes-grid a.conf').click(function() {        
    var url = $(this).attr('href');
    bootbox.confirm({
            message: 'La orden quedará confirmada',
            buttons: {
              confirm: {
                     label: 'Estoy de acuerdo',
                     className: 'btn-primary btn-sm',
              },
              cancel: {
                     label: 'Cancelar',
                     className: 'btn-sm',
              }
            },
            callback: function(result) {
                if(result) window.location.href = url;
            }
      }
    );
    return false;
});
$('#ordenes-grid a.coock').click(function() {        
    var url = $(this).attr('href');
    bootbox.confirm({
            message: 'La orden se enviara a la cocina y comenzarán a prepararla',
            buttons: {
              confirm: {
                     label: 'Estoy de acuerdo',
                     className: 'btn-primary btn-sm',
              },
              cancel: {
                     label: 'Cancelar',
                     className: 'btn-sm',
              }
            },
            callback: function(result) {
                if(result) window.location.href = url;
            }
      }
    );
    return false;
});
$('#ordenes-grid a.ok').click(function() {        
    var url = $(this).attr('href');
    bootbox.confirm({
            message: 'La orden se marcará como entregada',
            buttons: {
              confirm: {
                     label: 'Estoy de acuerdo',
                     className: 'btn-primary btn-sm',
              },
              cancel: {
                     label: 'Cancelar',
                     className: 'btn-sm',
              }
            },
            callback: function(result) {
                if(result) window.location.href = url;
            }
      }
    );
    return false;
});
$('#ordenes-grid a.cancel').click(function() {        
    var url = $(this).attr('href');
    bootbox.confirm({
            message: 'La orden se cancelará. Asegurese de que lo sepan en la cocina.',
            buttons: {
              confirm: {
                     label: 'Estoy de acuerdo',
                     className: 'btn-primary btn-sm',
              },
              cancel: {
                     label: 'Cancelar',
                     className: 'btn-sm',
              }
            },
            callback: function(result) {
                if(result) window.location.href = url;
            }
      }
    );
    return false;
});
");
?>


<?php
function formatOpciones($opciones, $selecciones)
{
    foreach ($opciones as $k => $opcion)
    {
        if(isset($selecciones[$k])){
            echo $opcion->nombre.' - '.$selecciones[$k]->productos->nombre;
            if(($k+1)!=count($selecciones))
                echo '<br>';
        }
    }
}

function precioTotal($producto, $selecciones)
{
    $precioAdic=0;
    foreach ($selecciones as $k => $selec)
        $precioAdic = $precioAdic + $selec->productos->precio;

    return $producto->precio+$precioAdic;
}

function getTimer($data) {

    $timeFirst  = strtotime($data->hora_pedido);
    $timeSecond = strtotime(date('Y-m-d H:i:s'));
    $differenceInSeconds = $timeSecond - $timeFirst;
    if($data->pedidos_has_productos_estados_id == PedidosHasProductosEstados::ENTREGADO && $data->hora_pedido_entregado) {
        $timeEnd = strtotime($data->hora_pedido_entregado);
        echo gmdate("H:i:s", $timeEnd - $timeFirst);
    } elseif($differenceInSeconds > 60*60) {
        echo '+1 hs.';
    }else{
        echo '<label id="minutes' . $data->id . '">00</label>:<label id="seconds' . $data->id . '">00</label>';
        Yii::app()->clientScript->registerScript(
            $data->id,
            'jQuery(function($) {
                var interval'.$data->id.' = setInterval(
                    function () {
                        seconds = Math.ceil(new Date().getTime() / 1000);
                        differenceInSeconds = seconds - '.$timeFirst.';
                        document.getElementById("seconds' . $data->id . '").innerHTML = pad((differenceInSeconds)%60);
                        document.getElementById("minutes' . $data->id . '").innerHTML = pad(parseInt((differenceInSeconds)/60));
                        if(document.getElementById("minutes' . $data->id . '").innerHTML > 59) {
                            document.getElementById("minutes' . $data->id . '").parentElement.innerHTML = "+1 hs.";
                            clearInterval(interval'.$data->id.');
                        }else if(document.getElementById("minutes' . $data->id . '").innerHTML > 14) {
                            document.getElementById("minutes' . $data->id . '").className = "red bolder";
                            document.getElementById("seconds' . $data->id . '").className = "red bolder";
                        } else{
                            document.getElementById("minutes' . $data->id . '").className = "green bolder";
                            document.getElementById("seconds' . $data->id . '").className = "green bolder";                        
                        }
                    },
                    1000
                );
            })',
            CClientScript::POS_END);
    }
}

Yii::app()->clientScript->registerScript('timerScript','
    function pad(val)
    {    
        var valString = val + "";
        if(valString.length < 2)
        {
            return "0" + valString;
        }
        else
        {
            return valString;
        }
    }
',CClientScript::POS_BEGIN);
?>
<script type="text/javascript">
    jQuery(function($) {
        <?php foreach(Yii::app()->user->getFlashes() as $key => $message) {?>
        $.gritter.add({
            title: '<?php echo $message;?>',
            text: '',
            class_name: 'gritter-<?php echo $key;?>'
        });
        return false;
        <?php }?>
    });
</script>