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
                <table id="simple-table" class="table  table-bordered table-hover">
                    <tbody>
                        <?php
                        if($model->pedidosHasProductos){
                            foreach ($model->pedidosHasProductos as $p) {
                                    if($p->pedidos_has_productos_id) {
                        ?>
                                        <tr>                                        
                                            <td><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;'.$p->productos->nombre;?></td>
                                            <td></td>
                                            <td><?php echo $p->productos->precio;?></td>
                                        </tr>
                        <?php
                                    } else {
                        ?>
                                        <tr>
                                            <td><?php echo $p->productos->nombre; echo $p->observaciones ? ' ('.$p->observaciones.')' : '';?></td>
                                            <td><?php echo $p->pedidosHasProductosEstados->estado;?></td>
                                            <td><?php echo '$ '.$p->productos->precio;?></td>
                                        </tr>
                        <?php
                                    }
                            }
                        }
                        ?>
                    </tbody>
                </table>
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