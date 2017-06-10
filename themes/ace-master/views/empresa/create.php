<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->breadcrumbs=array(
	'Empresas'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Empresas', 'url'=>array('admin')),
);
?>

<h1>Crear Empresa</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>