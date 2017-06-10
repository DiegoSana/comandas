<?php
/* @var $this ProductosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Productos',
);

$this->menu=array(
	array('label'=>'Crear Producto', 'url'=>array('create')),
	array('label'=>'Administrar Productos', 'url'=>array('admin')),
);
?>

<h1>Productos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
