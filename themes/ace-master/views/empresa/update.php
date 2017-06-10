<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->breadcrumbs=array(
	'Empresas'=>array('admin'),
	$model->nombre=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>'Crear Empresa', 'url'=>array('create')),
	array('label'=>'Ver Empresa', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Empresa', 'url'=>array('admin')),
);
?>

<h1>Editar <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>