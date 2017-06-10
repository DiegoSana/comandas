<?php
$this->breadcrumbs=array(
	'Aplicaciones'=>array('admin'),
	'Crear',
);
?>
<div class="page-header">
        <h1>
                Nueva aplicación
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Una aplicación representa a un local o establecimiento. Puede haber mas de una aplicación por empresa.
                </small>
        </h1>
</div><!-- /.page-header -->
<?php $this->renderPartial('_form', array('model'=>$model)); ?>