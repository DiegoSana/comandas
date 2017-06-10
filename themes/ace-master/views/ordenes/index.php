<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/plugins/stopwatch-timer/src/timer.jquery.js',CClientScript::POS_END);
?>

<?php $this->breadcrumbs=array(
	'Estado de pedidos',
);?>


<div class="page-header">
        <h1>Estado de ordenes</h1>
</div><!-- /.page-header -->

<div class="row">
    <!--<a href="<?php //echo Yii::app()->createUrl('/mesas/create')?>" class="btn btn-primary btn-yellow" style="float: right;margin: 0 24px;">
        <i class="ace-icon fa fa-tags align-top bigger-125"></i>
        Nueva mesa
    </a>-->
    <div class="col-xs-12">
        <div class="col-xs-12">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'ordenes-grid',
                    'dataProvider'=>$pedidos->search(),
                    'itemsCssClass'=>'table table-striped table-bordered table-hover',
                    //'filter'=>$pedidos,
                    'columns'=>array(                            
                            array(
                                'name'=>'N° de orden',
                                'value'=>'$data->id'
                            ),
                            array(
                                'name'=>'Imagen',
                                'value'=>'"<img style=\"max-width: 6em;max-height: 6em;\" src=\""."/images/productos/".$data->productos->productosImagenes[0]->nombre."\" />"',
                                'type'=>'raw'
                            ),                            
                            array(
                                'name'=>'N° de orden',
                                'value'=>'$data->id'
                            ),
                            array(
                                'name'=>'pedidos.id',
                                'value'=>'"<a class=\"det\" href=\"".Yii::app()->createUrl(\'pedidos/view\',array(\'id\'=>$data->pedidos->id))."\"><i class=\"glyphicon glyphicon-info-sign\"></i>&nbsp;&nbsp;&nbsp;".$data->pedidos->id."</a>"',
                                'type'=>'raw'
                            ),
                            array(
                                'name'=>'pedidos.mesas.nro_mesa',
                                'value'=>'$data->pedidos->mesas->nro_mesa ? $data->pedidos->mesas->nro_mesa : "Sin mesa"'
                            ),
                            array(
                                'name'=>'Solicitado por',
                                'value'=>'$data->pedidos->usuario->nombre'
                            ),
                            'productos.nombre',
                            array(
                                'name'=>'opciones',
                                'value'=>'formatOpciones($data->productos->productosOpciones, $data->pedidosHasProductoses)',
                            ),
                            'observaciones',
                            array(
                                'name'=>'hora_pedido',
                                'value'=>'date("d/m H:i:s", strtotime($data->hora_pedido))',
                            ),
                            array(
                                'name'=>'tiempo transcurrido',
                                'value'=>'formatHoraPedido($data->hora_pedido)',
                                'type'=>'raw'
                            ),
                            /*array(
                                'name'=>'precio',
                                'value'=>'precioTotal($data->productos, $data->pedidosHasProductoses)',
                            ),*/
                            'pedidosHasProductosEstados.estado',
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
                                                'visible'=>'$data->pedidos_has_productos_estados_id==PedidosHasProductosEstados::COCINA || $data->pedidos_has_productos_estados_id==PedidosHasProductosEstados::CANCELADO'
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

function formatHoraPedido($time)
{
    //echo date('Y-m-d H:i:s');
    $timeFirst  = strtotime($time);
    //$timeFirst  = strtotime('2015-09-20 18:20:15');
    $timeSecond = strtotime(date('Y-m-d H:i:s'));
    $differenceInSeconds = $timeSecond - $timeFirst;
    
    if($differenceInSeconds<3600)
    {
    echo 
    '
	<script type="text/javascript">            
            $(document).ready(function() {
                
                $("#'.$timeFirst.'").timer({
                    seconds: '.$differenceInSeconds.',
                    duration: "5s",
                    callback: function(a) {
                        if($("#'.$timeFirst.'").data("seconds")>1200)
                            $("#'.$timeFirst.'").addClass("text-warning");
                        if($("#'.$timeFirst.'").data("seconds")>1800)
                            $("#'.$timeFirst.'").addClass("text-danger");
                    },
                    repeat: true
                });
                $("#'.$timeFirst.'").timer();
            });
	</script>
    ';
    }
    else
    {
    echo 
    '
	<script type="text/javascript">            
            $(document).ready(function() {
                $("#'.$timeFirst.'").html("tiempo excedido");
            });
	</script>
    ';    
    }
    return '<b id="'.$timeFirst.'"></b>';
}
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