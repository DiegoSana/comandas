<?php
$this->breadcrumbs=array(
	'Productos'=>array('/productos/admin'),
	'Creaar',
);
?>
<div class="page-header">
        <h1>
                Nuevo producto
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <!--Luego de crearlo, podrá asignarle un role en la sección de Roles por Usuario-->
                </small>
        </h1>
</div><!-- /.page-header -->
<?php $this->renderPartial('_form', array(
    'productos'=>$productos,  
    )); ?>