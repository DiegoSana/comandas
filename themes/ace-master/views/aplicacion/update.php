<?php
$this->breadcrumbs=array(
	'Aplicaciones'=>array('admin'),
	$model->nombre=>array('view','id'=>$model->id),
	'Editar',
);
?>
<div class="page-header">
        <h1>
                Editar <?php echo $model->nombre;?>
        </h1>
</div><!-- /.page-header -->
<?php $this->renderPartial('_form', array('model'=>$model)); ?>