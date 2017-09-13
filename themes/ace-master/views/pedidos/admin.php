<?php
$this->breadcrumbs=array(
	'Pedidos'=>array('admin'),
	'Administrar',
);
?>
<div class="page-header">
        <h1>
                Administrar pedidos
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Los pedidos son identificadores únicos de un grupo de comensales por mesa. Se deberá entregar un nuevo pedido a los nuevos comensales de la mesa
                </small>
        </h1>
</div><!-- /.page-header -->

<div class="row">
    <button class="btn btn-purple" id="bootbox-options" style="float: right;margin: 0 12px;">
        <i class="ace-icon fa fa-list align-top bigger-125"></i>
        Generar pedidos
    </button>
    <button class="btn btn-info" onclick="js: imprimirSeleccionados()" id="bootbox-options" style="float: right;margin: 0 12px;">
        <i class="ace-icon glyphicon glyphicon-print align-top bigger-125"></i>
        Imprimir tarjetas para pedidos seleccionados
    </button>
    <div class="col-xs-12">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'pedidos-grid',
                    'ajaxUpdate' => true,
                    'dataProvider'=>$model->search(),
                    'itemsCssClass'=>'table table-striped table-bordered table-hover',
                    'htmlOptions'=>array(),
                    'pagerCssClass'=>'dataTables_paginate paging_simple_numbers',
                    'columns'=>array(
                            array(
                                'id' => 'selectedIds',
                                'value' => '$data->id',
                                'class' => 'CCheckBoxColumn',
                                'selectableRows' => '100',
                            ),
                            'id',
                            array(
                                'name'=>'mesas.nro_mesa',
                                'value'=>'$data->mesas->nro_mesa ? $data->mesas->nro_mesa : "Sin mesa"',
                            ),
                            array(            // display 'create_time' using an expression
                                'name'=>'usuario.nombre',
                                'value'=>'$data->usuario->nombre',
                            ),                        
                            /*array(            // display 'create_time' using an expression
                                'name'=>'mesas.aplicacion.nombre',
                                'value'=>'$data->mesas->aplicacion->nombre',
                            ),*/
                            array(
                                'name'=>'pedidosEstados.estado',
                                'htmlOptions'=>array('style'=>'font-weight: bold','class'=>'text-info'),
                                'value'=>'$data->pedidosEstados->estado',
                            ),
                            array(
                                'name'=>'total',
                                'htmlOptions'=>array('style'=>'font-weight: bold'),
                                'value'=>'"$ ".$data->getTotal()',
                            ),
                            /*array(            // display 'create_time' using an expression
                                'name'=>'QR',
                                'type'=>'html', 
                                'value'=>'CHtml::image(DIRECTORY_SEPARATOR.$data->qr_image,"",array("style"=>"width:20px;"))',
                            ),*/
                            array(
                                    'class'=>'CButtonColumn',
                                    'headerHtmlOptions'=>array(),
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                    'template'=>'{det}{pay}{activate}{cerrar}',
                                    'buttons'=>array
                                    (
                                        'det'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',
                                                'url'=>'Yii::app()->createUrl("pedidos/view",array("id"=>$data->id))',  //Image URL of the button.
                                                'options'=>array('class'=>'det tooltip-warning toolt btn btn-xs btn-warning glyphicon glyphicon-search', 'style'=>'display:inline;', 'data-rel'=>'tooltip','title'=>'Ver detalle'),
                                        ),
                                        'pay'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'tooltip-success toolt pay btn btn-xs btn-success glyphicon glyphicon-ok', 'style'=>'display:inline;', 'data-rel'=>'tooltip','title'=>'Marcar como pagado'),
                                                'url'=>'Yii::app()->controller->createUrl("pay",array("id"=>$data->id))',
                                                'visible'=>'$data->pedidos_estados_id==PedidosEstados::ACTIVO'
                                        ),
                                        'activate'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'tooltip-info toolt act btn btn-xs btn-info glyphicon glyphicon-repeat', 'style'=>'display:inline;', 'data-rel'=>'tooltip','title'=>'Activar pedido'),
                                                'url'=>'Yii::app()->controller->createUrl("open",array("id"=>$data->id))',
                                                'visible'=>'$data->pedidos_estados_id==PedidosEstados::DISPONIBLE || $data->pedidos_estados_id==PedidosEstados::CANCELADO || $data->pedidos_estados_id==PedidosEstados::PAGADO'
                                        ),
                                        'cerrar'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'tooltip-error toolt btn cerrar btn-xs btn-danger glyphicon glyphicon-remove', 'style'=>'display:inline;', 'data-rel'=>'tooltip','title'=>'Cancelar pedido'),
                                                'url'=>'Yii::app()->controller->createUrl("close",array("id"=>$data->id))',
                                                'visible'=>'$data->pedidos_estados_id==PedidosEstados::DISPONIBLE || $data->pedidos_estados_id==PedidosEstados::ACTIVO'
                                        ),
                                    )
                            ),
                    ),
            ));?>
    </div>
</div>


<?php
Yii::app()->clientScript->registerScript('actions', "
$('#pedidos-grid a.det').click(function() {        
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
$('#pedidos-grid a.pay').click(function() {        
    var url = $(this).attr('href');
    bootbox.confirm({
            message: 'Si marca el pedido como pagado, todas las ordenes dentro del pedido pasarán a la grilla de ordenes para comenzar su preparación.<br>¿Está de acuerdo?',
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
$('#pedidos-grid a.cerrar').click(function() {        
    var url = $(this).attr('href');
    bootbox.confirm({
            message: 'Asegurese de avisar en la cocina que el pedido está cancelado.',
            buttons: {
              confirm: {
                     label: 'Entendido',
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
$formu1 =            '<div class="widget-body">';
$formu1 .=                    '<div class="widget-main no-padding">';
$formu1 .=                            '<form id="tikets-form">';
$formu1 .=                                    '<fieldset>';
$formu1 .=                                            '<label>Número de mesa</label>';
$formu1 .=                                            '<select name="Pedidos[mesas_id]" id="mesas_id" class="form-control" >' ;   
foreach (Aplicacion::model()->getAll() as $app)
    if(isset($app->mesas))
        foreach ($app->mesas as $mesa)
            if($mesa->nro_mesa!=0)
            $formu1 .=                                         '<option value="'.$mesa->id.'">Mesa '.$mesa->nro_mesa.' ('.$app->nombre.')'.'</option>';
$formu1 .=                                            '</select>';
$formu1 .=                                            '<label>Cantidad de tikes a generar</label>';
$formu1 .=                                            '<input id="spinner" class="form-control" name="Pedidos[cantidad]" value="0" type="text" />';
$formu1 .=                                            '<span class="help-block">Cada pedido corresponde a una rotación de mesa</span>';       
$formu1 .=                                    '</fieldset>';
$formu1 .=                            '</form>';
$formu1 .=                    '</div>';
$formu1 .=            '</div>';
?>

<!-- inline scripts related to this page -->
<script type="text/javascript">
jQuery(function($) {   
    $("#bootbox-options").on(ace.click_event, function() {
            bootbox.dialog({
                    size: 'small',
                    title: "Pedidos para las mesas",
                    message: '<?php echo $formu1;?>',
                    buttons: 			
                    {
                            "success" :
                             {
                                    "label" : "<i class='ace-icon fa fa-check'></i> Crear!",
                                    "className" : "btn-sm btn-success",
                                    "callback": function() {
                                        $.ajax({
                                            method: "POST",
                                            url: "<?php echo Yii::app()->createUrl('/pedidos/create');?>",
                                            data: $("#tikets-form").serialize()
                                        })
                                        .done(function( data ) {
                                            if(data=="ok"){                                                
                                                $.gritter.add({title: 'Se crearon '+$("#tikets-form #spinner").val()+' pedidos para la mesa '+$("#tikets-form #mesas_id").val(),class_name: 'gritter-success'});
                                                $("#tikets-form")[0].reset();
                                            }else{
                                                $.gritter.add({title: data,class_name: 'gritter-error'});
                                            }
                                        });
                                    }
                            }
                    }
            });
    });    

});



function imprimirSeleccionados()
{
    var myArray = [];
    $.each($("input[name='selectedIds[]']:checked"),function(k,v){
        myArray.push(v.value);
    });
    if(myArray.length)
    {
        $.ajax({
            method: "POST",
            url: "<?php echo Yii::app()->createUrl('/pedidos/createPdf');?>",
            data: {ids: myArray}
        })
        .done(function( data ) {
            if(data)
                window.open('/tmp/'+data+'.pdf', '_blank');
                //window.location.href = 'createPdf?getFile=1434777951';
        });
    }
    else
        alert('No hay pedidos creados');
}
</script>
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