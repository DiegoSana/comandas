<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */

$this->breadcrumbs=array(
	'Usuarios'=>array('/usuarios/admin'),
	'Administrar',
);

?>

<div class="page-header">
        <h1>
                Administrar usuarios
        </h1>
</div><!-- /.page-header -->

<div class="row">
    <a href="<?php echo Yii::app()->createUrl('/usuarios/create');?>" class="btn btn-primary" style="float: right; margin: 1em 24px;">
        <i class="ace-icon fa fa-user align-top bigger-125"></i>
        Nuevo usuario
    </a>
    <div class="col-xs-12">
        <div class="col-xs-12">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'usuarios-grid',
                    'dataProvider'=>$model->search(),
                    'itemsCssClass'=>'table table-striped table-bordered table-hover',
                    'pagerCssClass'=>'dataTables_paginate paging_simple_numbers',
                    'columns'=>array(
                            'usuario',
                            'nombre',
                            'apellido',
                            'email',
                            'empresa.nombre',
                            array(
                                'name'=>'role',
                                'value'=>'formatRoles($data->roles)',
                            ),
                            array(
                                'name'=>'aplicaciones',
                                'value'=>'formatAplicaciones($data->aplicaciones)',
                            ),
                            array(
                                    'class'=>'CButtonColumn',
                                    'htmlOptions'=>array('style'=>'display:inline-flex;'),
                                    'buttons'=>array
                                    (
                                        'delete'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'toolt tooltip-error btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-120','title'=>'Dar de baja'), //HTML options for the button tag.
                                        ),
                                        'update'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'toolt tooltip-info btn btn-xs btn-info ace-icon fa fa-pencil bigger-120','title'=>'Actualizar'), //HTML options for the button tag.
                                        ),
                                        'view'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'toolt tooltip-warning btn btn-xs btn-warning ace-icon fa fa-info-circle bigger-120','title'=>'Ver detalle'), //HTML options for the button tag.
                                        )
                                    )
                            ),
                    ),
            )); ?>
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

<?php 
function formatRoles($roles)
{
    foreach ($roles as $rol)
        echo( $rol->rol);
}
function formatAplicaciones($apps)
{
    foreach ($apps as $app)
        echo($app->nombre.', ');
}
?>
