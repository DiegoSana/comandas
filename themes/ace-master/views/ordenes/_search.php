<?php
/* @var $this OrdenesController */
/* @var $model Pedidos */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mesas_id'); ?>
		<?php echo $form->textField($model,'mesas_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hash'); ?>
		<?php echo $form->textField($model,'hash',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pedidos_estados_id'); ?>
		<?php echo $form->textField($model,'pedidos_estados_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qr_image'); ?>
		<?php echo $form->textField($model,'qr_image',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->