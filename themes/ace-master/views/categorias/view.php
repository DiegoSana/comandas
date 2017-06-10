<?php
$this->breadcrumbs=array(
	'Categorías'=>array('/categorias/admin'),
	$model->nombre,
);
?>

<div class="page-header">
    <h1>
            <?php echo $model->nombre;?>
            <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('categorias/update',array('id'=>$model->id));?>" class="btn">
                        <i class="ace-icon fa fa-pencil align-top bigger-125"></i>Editar
                    </a>
            </small>
    </h1>
</div>

<div class="profile-user-info profile-user-info-striped" style="width: 50%;">
    <div class="profile-info-row">
            <div class="profile-info-name"> Nombre </div>

            <div class="profile-info-value">
                    <span class="editable editable-click"><?php echo $model->nombre;?></span>
            </div>
    </div>
    
    <div class="profile-info-row">
            <div class="profile-info-name"> Descripción </div>

            <div class="profile-info-value">
                    <span><?php echo $model->descripcion;?></span>
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
});
</script>