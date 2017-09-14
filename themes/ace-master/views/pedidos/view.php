<?php
$this->breadcrumbs=array(
	'Pedidos'=>array('/pedidos/admin'),
	$model->id,
);
?>

<div class="page-header">
    <h1>
            Pedido número <?php echo $model->id;?>
    </h1>
</div>

<div class="profile-user-info profile-user-info-striped">
    <div class="profile-info-row">
            <div class="profile-info-name"> Mesa </div>

            <div class="profile-info-value">
                    <span class="editable editable-click"><?php echo $model->mesas->nro_mesa ? $model->mesas->nro_mesa : 'sin mesa';?></span>
            </div>
    </div>
    
    <div class="profile-info-row">
            <div class="profile-info-name"> Solicitado por </div>

            <div class="profile-info-value">
                    <span><?php echo $model->usuario->nombre;?></span>
            </div>
    </div>

    <div class="profile-info-row">
            <div class="profile-info-name"> Estado </div>

            <div class="profile-info-value">
                    <span class="editable editable-click"><?php echo $model->pedidosEstados->estado;?></span>
            </div>
    </div>
    
    <div class="profile-info-row">
            <div class="profile-info-name"> Ordenes </div>

            <div class="profile-info-value">
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id'=>'pedidos-grid',
                        'ajaxUpdate' => true,
                        'summaryText' => FALSE,
                        'itemsCssClass'=>'table table-striped table-bordered table-hover',
                        'rowCssClassExpression'=>'$data->pedidos_has_productos_id?"row-closed":"row-open"',
                        'dataProvider' => $a,
                        'columns' => array(
                            [
                                'name' => 'productos.nombre',
                                'value' => '$data->observaciones ? $data->productos->nombre." (".$data->observaciones.")" : $data->productos->nombre',
                            ],
                            [
                                'name' => 'adicionales',
                                'value' => '$data->formatAdicionales()',
                            ],
                            [
                                'name' => 'pedidosHasProductosEstados.estado',
                            ],
                            [
                                'name' => 'productos.precio',
                                'value' => '$data->getPrecioConAdicionales()',
                            ],
                            [
                                'class'=>'CButtonColumn',
                                'headerHtmlOptions'=>[],
                                'htmlOptions'=>['style'=>'text-align:left;'],
                                'template'=>'{borrar}',
                                'buttons'=>[
                                    'borrar'=>array(
                                        'label'=>'',
                                        'imageUrl'=>'',  //Image URL of the button.
                                        'options'=>array('class'=>'tooltip-error toolt btn cerrar btn-xs btn-danger glyphicon glyphicon-remove', 'style'=>'display:inline;', 'data-rel'=>'tooltip','title'=>'Eliminar'),
                                        'url'=>'Yii::app()->controller->createUrl("close",array("id"=>$data->id))',
                                    ),
                                ]
                            ]
                        ),
                    ));
                    ?>
            </div>
    </div>

    <div class="profile-info-row">
            <div class="profile-info-name"> Total </div>

            <div class="profile-info-value text-right">
                <h4 class="padd"><?php if($model) echo '$ '.$model->getTotal();?></h4>
            </div>
    </div>
    
</div>
<!--<button class="btn btn-success" id="gritter-without-image">Without Image</button>-->


<style>
    .row-closed {
        display: none;}
</style>

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