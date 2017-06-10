<?php
$this->breadcrumbs=array(
	'Tikets'=>array('/pedidos/admin'),
	$model->mesas->nro_mesa=>array('view','id'=>$model->id),
	'Editar',
);
?>
<div class="page-header">
        <h1>
                Edición de tiket
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Los tikets son unicos por cada grupo de comensales que se sienta en la mesa. No es conveniente realizar modificaciones sobre uno ya creado
                </small>
        </h1>
</div><!-- /.page-header -->
<?php $this->renderPartial('_form', array('model'=>$model)); ?>