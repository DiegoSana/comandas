<?php
$this->breadcrumbs=array(
	'Administrador de Mesas'=>array('/mesas/admin'),
	'Nueva',
);
?>
<div class="page-header">
        <h1>
                Nueva mesa
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Luego de crearla, podrá acomodarla en la vista de mesas
                </small>
        </h1>
</div><!-- /.page-header -->
<?php $this->renderPartial('_form', array('model'=>$model)); ?>