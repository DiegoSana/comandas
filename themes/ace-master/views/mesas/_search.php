<?php
/* @var $this MesasController */
/* @var $model Mesas */
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
		<?php echo $form->label($model,'nro_mesa'); ?>
		<?php echo $form->textField($model,'nro_mesa'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aplicacion_id'); ?>
		<?php echo $form->textField($model,'aplicacion_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->