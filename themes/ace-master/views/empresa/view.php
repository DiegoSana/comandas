<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->breadcrumbs=array(
	'Empresas'=>array('admin'),
	$model->nombre,
);

$this->menu=array(
	array('label'=>'Crear Empresa', 'url'=>array('create')),
	array('label'=>'Editar Empresa', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Empresa', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar Empresas', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
	),
)); ?>
