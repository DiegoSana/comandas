<?php
$this->breadcrumbs=array(
	'Categorías'=>array('/categorias/admin'),
	$model->nombre,
);
?>

<div class="page-header">
        <h1>
                Edición de categoría
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Cree tantas categorías como tenga su menú
                </small>
        </h1>
</div><!-- /.page-header -->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>