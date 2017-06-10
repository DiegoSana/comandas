<?php
$this->breadcrumbs=array(
	'Usuarios'=>array('/usuarios/admin'),
	$model->id,
);
?>

<div class="page-header">
    <h1>
            <?php echo $model->nombre.' '.$model->apellido; ?>
            <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('usuarios/update',array('id'=>$model->id));?>" class="btn">
                        <i class="ace-icon fa fa-pencil align-top bigger-125"></i>Editar
                    </a>
            </small>
    </h1>
</div>

<div class="profile-user-info profile-user-info-striped" style="width: 50%;">
    <div class="profile-info-row">
            <div class="profile-info-name"> Usuario </div>

            <div class="profile-info-value">
                    <span class="editable editable-click" id="username"><?php echo $model->usuario;?></span>
            </div>
    </div>

    <div class="profile-info-row">
            <div class="profile-info-name"> Nombre </div>

            <div class="profile-info-value">
                    <span class="editable editable-click" id="country"><?php echo $model->apellido.', '.$model->nombre;?></span>
            </div>
    </div>

    <div class="profile-info-row">
            <div class="profile-info-name"> Mail </div>

            <div class="profile-info-value">
                    <span class="editable editable-click" id="age"><?php echo $model->email;?></span>
            </div>
    </div>

    <div class="profile-info-row">
            <div class="profile-info-name"> Empresa </div>

            <div class="profile-info-value">
                    <span class="editable editable-click" id="signup"><?php echo $model->empresa->nombre;?></span>
            </div>
    </div>

    <div class="profile-info-row">
            <div class="profile-info-name"> Aplicaciones </div>

            <div class="profile-info-value">
                        <?php foreach ($model->aplicaciones as $app)
                                echo '<span class="editable editable-click" id="login">'.$app->nombre.'</span>';?>
            </div>
    </div>

    <div class="profile-info-row">
            <div class="profile-info-name"> Roles </div>

            <div class="profile-info-value">
                        <?php foreach ($model->roles as $rol)
                                echo '<span class="editable editable-click" id="login">'.$rol->rol.'</span>';?>
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