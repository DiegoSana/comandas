<?php
$this->breadcrumbs=array(
	'Aplicaciones'=>array('admin'),
	$model->nombre,
);
?>

<div class="page-header">
    <h1>
            <?php echo $model->nombre; ?>
            <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('/aplicacion/update',array('id'=>$model->id));?>" class="btn">
                        <i class="ace-icon fa fa-pencil align-top bigger-125"></i>Editar
                    </a>
            </small>
    </h1>
</div>

<div class="profile-user-info profile-user-info-striped" style="width: 50%;">
    <div class="profile-info-row">
            <div class="profile-info-name"> Nombre </div>

            <div class="profile-info-value">
                    <span class="editable editable-click" id="username"><?php echo $model->nombre;?></span>
            </div>
    </div>
    <div class="profile-info-row">
            <div class="profile-info-name"> Url </div>

            <div class="profile-info-value">
                <?php 
                $burl = Yii::app()->getBaseUrl(true);
                $burlnp = explode('//', $burl);
                $burlnp = explode('.', $burlnp[1]);
                $burlnp[0] = $model->subdominio;
                ?>
                <span class="editable editable-click" id="username"><?php echo implode('.', $burlnp);?></span>
            </div>
    </div>
    <div class="profile-info-row">
            <div class="profile-info-name"> Subdominio </div>

            <div class="profile-info-value">
                    <span class="editable editable-click" id="username"><?php echo $model->subdominio;?></span>
            </div>
    </div>
    <div class="profile-info-row">
            <div class="profile-info-name"> Empresa </div>

            <div class="profile-info-value">
                    <span class="editable editable-click" id="username"><?php echo $model->empresa->nombre;?></span>
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