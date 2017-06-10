<?php
/* @var $this CategoriasController */
/* @var $model Categorias */

$this->breadcrumbs=array(
	'Categorías'=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Listar Categorías', 'url'=>array('index')),
	array('label'=>'Crear Categoría', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#categorias-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Categorías</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'categorias-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'htmlOptions'=>array('class'=>'table table-striped table-bordered table-hover'),    
	'columns'=>array(
		'nombre',
		'descripcion',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
