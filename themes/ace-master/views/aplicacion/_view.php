<?php
/* @var $this AplicacionController */
/* @var $data Aplicacion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('subdominio')); ?>:</b>
	<?php echo CHtml::encode($data->subdominio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empresa.nombre')); ?>:</b>
	<?php echo CHtml::encode($data->empresa->nombre); ?>
	<br />


</div>