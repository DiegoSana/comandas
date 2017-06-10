<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	'Roles'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Roles', 'url'=>array('admin')),
);
?>

<h1>Crear Rol</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>