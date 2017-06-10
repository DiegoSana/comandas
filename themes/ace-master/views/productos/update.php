<?php
$this->breadcrumbs=array(
	'Productos'=>array('/productos/admin'),
	$producto->nombre=>array('/productos/view/'.$producto->id),
	'Editar',
);
?>
<div class="page-header">
        <h1>
                Editar <?php echo $producto->nombre; ?>
        </h1>
</div><!-- /.page-header -->
<?php $this->renderPartial('_form', array(
    'productos'=>$producto,
    )); ?>