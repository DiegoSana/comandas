<?php
/* @var $this AplicacionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Aplicaciones',
);

$this->menu=array(
	array('label'=>'Crear Aplicacion', 'url'=>array('create')),
	array('label'=>'Administrar Aplicaciones', 'url'=>array('admin')),
);
?>

<h1>Aplicaciones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
