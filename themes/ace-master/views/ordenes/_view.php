<?php
/* @var $this OrdenesController */
/* @var $data Pedidos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mesas_id')); ?>:</b>
	<?php echo CHtml::encode($data->mesas_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hash')); ?>:</b>
	<?php echo CHtml::encode($data->hash); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pedidos_estados_id')); ?>:</b>
	<?php echo CHtml::encode($data->pedidos_estados_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qr_image')); ?>:</b>
	<?php echo CHtml::encode($data->qr_image); ?>
	<br />


</div>