<?php
/* @var $this OrdenesController */
/* @var $model Pedidos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pedidos-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'mesas_id'); ?>
		<?php echo $form->textField($model,'mesas_id'); ?>
		<?php echo $form->error($model,'mesas_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hash'); ?>
		<?php echo $form->textField($model,'hash',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'hash'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pedidos_estados_id'); ?>
		<?php echo $form->textField($model,'pedidos_estados_id'); ?>
		<?php echo $form->error($model,'pedidos_estados_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qr_image'); ?>
		<?php echo $form->textField($model,'qr_image',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'qr_image'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->