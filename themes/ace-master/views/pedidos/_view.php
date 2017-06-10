<?php
/* @var $this PedidosController */
/* @var $data Pedidos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('mesas_id')); ?>:</b>
	<?php echo CHtml::encode($data->mesas_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pedidosEstados.estado')); ?>:</b>
	<?php echo CHtml::encode($data->pedidosEstados->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hash')); ?>:</b>
	<?php echo CHtml::encode($data->hash); ?>
	<br />


</div>