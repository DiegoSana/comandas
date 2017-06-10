<?php
/* @var $this OrdenesController */
/* @var $model Pedidos */

$this->breadcrumbs=array(
	'Pedidoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pedidos', 'url'=>array('index')),
	array('label'=>'Create Pedidos', 'url'=>array('create')),
	array('label'=>'Update Pedidos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pedidos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pedidos', 'url'=>array('admin')),
);
?>

<h1>View Pedidos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'mesas_id',
		'hash',
		'pedidos_estados_id',
		'qr_image',
	),
)); ?>
