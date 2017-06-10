<?php
/* @var $this MesasController */
/* @var $model Mesas */

$this->breadcrumbs=array(
	'Mesas'=>array('index'),
	'Mesa '.$model->nro_mesa,
);

$this->menu=array(
	array('label'=>'Vista de Mesas', 'url'=>array('index')),
	array('label'=>'Crear Mesas', 'url'=>array('create')),
	array('label'=>'Editar Mesa', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Mesa', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar Mesas', 'url'=>array('admin')),
);
?>

<h1>Mesa número <?php echo $model->nro_mesa; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nro_mesa',
		'aplicacion.nombre',
	),
)); ?>
