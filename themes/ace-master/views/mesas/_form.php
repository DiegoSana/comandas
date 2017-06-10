<?php
/* @var $this MesasController */
/* @var $model Mesas */
/* @var $form CActiveForm */
?>

<div class="col-xs-12 col-sm-4"  style="margin: 0 auto; float: none;">
    <div class="widget-box">
        <div class="widget-body">
                <div class="widget-main" style="padding: 30px;">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'mesas-form',
                            'htmlOptions'=>array('class'=>'form-horizontal'),
                            'enableAjaxValidation'=>false,
                    )); ?>

                            <?php echo $form->errorSummary($model); ?>

                            <div class="form-group">
                                    <?php echo $form->labelEx($model,'nro_mesa'); ?>
                                    <?php echo $form->textField($model,'nro_mesa',array('class'=>'form-control')); ?>
                            </div>

                            <div class="form-group">
                                    <?php echo $form->labelEx($model,'aplicacion_id'); ?>
                                    <?php
                                        echo $form->dropDownList(
                                                $model,
                                                'aplicacion_id',
                                                CHtml::listData(array(Yii::app()->user->aplicacion), 'id', 'nombre'),
                                                array('empty'=>'Seleccione una aplicacion...','class'=>'form-control')
                                                );
                                    ?>
                            </div>

                            <div class="form-group buttons">
                                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'btn btn-info')); ?>
                            </div>
                    <?php $this->endWidget(); ?>
                </div>
        </div>
    </div>
</div>
