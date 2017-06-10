<?php
$this->breadcrumbs=array(
	'Productos'=>array('/productos/index'),
	$model->nombre,
);
?>
<div class="page-header">
    <h1>
            <?php echo $model->nombre; ?>
            <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('/productos/update',array('id'=>$model->id));?>" class="btn">
                        <i class="ace-icon fa fa-pencil align-top bigger-125"></i>Editar
                    </a>
            </small>
    </h1>
</div>
<div class="profile-user-info profile-user-info-striped" style="width: 50%;">
    <div class="profile-info-row">
            <div class="profile-info-name"> Producto </div>

            <div class="profile-info-value">
                    <span class="" ><?php echo $model->nombre;?></span>
            </div>
    </div>
    <div class="profile-info-row">
            <div class="profile-info-name"> Mostrable </div>

            <div class="profile-info-value">
                    <span class="" ><?php echo $model->mostrable ? 'Si' : 'No';?></span>
            </div>
    </div>
    <div class="profile-info-row">
            <div class="profile-info-name"> Preparación en cocina </div>

            <div class="profile-info-value">
                    <span class="" ><?php echo $model->preparacion_cocina ? 'Si' : 'No';?></span>
            </div>
    </div>
    <div class="profile-info-row">
            <div class="profile-info-name"> Descripción </div>

            <div class="profile-info-value">
                    <span class="" ><?php echo $model->descripcion;?></span>
            </div>
    </div>
    <div class="profile-info-row">
            <div class="profile-info-name"> Precio </div>

            <div class="profile-info-value">
                    <span class="" ><?php echo $model->precio;?></span>
            </div>
    </div>
    <div class="profile-info-row">
            <div class="profile-info-name"> Aplicación </div>

            <div class="profile-info-value">
                    <span class="" ><?php echo $model->aplicacion->nombre;?></span>
            </div>
    </div>
    <div class="profile-info-row">
            <div class="profile-info-name"> Categorías </div>

            <div class="profile-info-value">
            <?php foreach ($model->categorias as $cat)
                echo '<span title="Ir a la categoría" class="toolt editable editable-click" ><a href="'.Yii::app()->createAbsoluteUrl('/categorias/view',array('id'=>$cat->id)).'">'.$cat->nombre.'</a></span>';?>
            </div>
    </div>
    <div class="profile-info-row">
            <div class="profile-info-name"> Opciones </div>

            <div class="profile-info-value">
            <?php
            if($model->productosOpciones){
                foreach ($model->productosOpciones as $opcion) {
                    $cont = '<span class="bigger-110">La opciones para <b>"'.$opcion->nombre.'"</b> son:</span><br>';
                    $cont .= '<ul class="list-unstyled">';
                    foreach ($opcion->productos as $prod)
                        $cont .= '<li><i class="ace-icon fa fa-caret-right blue"></i>'.$prod->nombre.'</li>';
                    $cont .= '</ul>';
                    echo '<div><div style="display:none;">'.$cont.'</div><span title="Ver detalles" class="opts toolt editable editable-click" >'.$opcion->nombre.'</span></div>';
                }
            }
            else
            {
                echo '<span class="text-muted" >Sin opciones</span>';
            }
            ?>
            </div>
    </div>
</div>


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
    
    
    $(".opts").on(ace.click_event, function() {
            bootbox.dialog({
                    message: $(this).parent().find('div').html(),
                    buttons: 			
                    {
                            "success" :
                             {
                                    "label" : "<i class='ace-icon fa fa-check'></i> Listo!",
                                    "className" : "btn-sm btn-success",
                                    "callback": function() {
                                            //Example.show("great success");
                                    }
                            },
                    }
            });
    });
});
</script>
