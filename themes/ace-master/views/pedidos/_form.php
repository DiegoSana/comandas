<?php
/* @var $this PedidosController */
/* @var $model Pedidos */
/* @var $form CActiveForm */
?>
<div class="col-xs-12 col-sm-4"  style="margin: 0 auto; float: none;">
    <div class="widget-box">
        <div class="widget-body">
                <div class="widget-main" style="padding: 30px;">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'pedidos-form',
                            'htmlOptions'=>array('class'=>'form-horizontal'),
                            'enableAjaxValidation'=>false,
                    )); ?>

                            <?php echo $form->errorSummary($model); ?>

                            <div class="form-group">
                                    <b class="text-primary">Mesa número <?php echo $model->mesas->nro_mesa; ?></b>
                            </div>
                    
                            <div class="form-group">
                                    <?php echo $form->labelEx($model,'pedidos_estados_id'); ?>
                                    <div class="row"><?php echo $form->textField($model,'pedidos_estados_id',array('class'=>'form-control')); ?></div>
                            </div>
                    
                            <div class="form-group">
                                    <?php echo $form->labelEx($model,'aplicacion_id'); ?>
                                    <div class="row"><?php echo $form->textField($model,'aplicacion_id',array('class'=>'form-control')); ?></div>
                                    <?php
                                        echo $form->dropDownList(
                                                $model,
                                                'aplicacion_id',
                                                CHtml::listData(Aplicacion::model()->getAll(), 'id', 'nombre'),
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