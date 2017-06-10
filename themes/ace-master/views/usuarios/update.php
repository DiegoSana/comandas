<?php
$this->breadcrumbs=array(
	'Usuarios'=>array('/usuarios/admin'),
	$model->nombre.' '.$model->apellido=>array('/usuarios/view','id'=>$model->id),
	'Editar',
);
?>
<div class="page-header">
        <h1>
                Editar usuario
        </h1>
</div><!-- /.page-header -->
<?php $this->renderPartial('_form', array('model'=>$model,'usuariosRoles'=>$usuariosRoles,'usuariosAplicacion'=>$usuariosAplicacion)); ?>