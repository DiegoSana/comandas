<?php
$this->breadcrumbs=array(
	'Administrador de Mesas'=>array('/mesas/admin'),
	'Mesa '.$model->nro_mesa=>array('/mesas/view','id'=>$model->id),
	'Editar',
);
?>
<div class="page-header">
        <h1>
                Editar mesa
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Puede acomodar la mesa en la vista de mesas
                </small>
        </h1>
</div><!-- /.page-header -->
<?php $this->renderPartial('_form', array('model'=>$model)); ?>