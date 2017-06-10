<?php
/* @var $this CategoriasController */
/* @var $model Categorias */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'categorias-form',
        'enableAjaxValidation'=>false,
)); ?>
<div class="col-xs-12 col-sm-4"  style="margin: 0 auto; float: none;">
    <div class="widget-box">
        <div class="widget-body">
                <div class="widget-main" style="padding: 30px;">

                        <?php echo $form->errorSummary($model); ?>

                        <div class="form-group">
                                <?php echo $form->labelEx($model,'nombre'); ?>
                                <div class="row"><?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?></div>
                        </div>

                        <div class="form-group">
                                <?php echo $form->labelEx($model,'descripcion'); ?>
                                <div class="row"><?php echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?></div>
                        </div>
                    

                            <div class="form-group">
                                    <?php echo $form->labelEx($model,'aplicacion_id'); ?>
                                    <?php
                                        if(Yii::app()->user->checkAccess('superadmin',Yii::app()->user->id))
                                            $cond = 'id IS NOT NULL';
                                        else
                                            $cond = 'id = '.Yii::app()->user->aplicacion->id;
                                        echo $form->dropDownList(
                                                $model,
                                                'aplicacion_id',
                                                CHtml::listData(Aplicacion::model()->findAllByAttributes(array(),$cond), 'id', 'nombre'),
                                                array('empty'=>'Seleccione una aplicacion...','class'=>'form-control')
                                                );
                                    ?>
                            </div>
                    
                </div>
                <div class="form-actions center" style="margin-bottom: 0;">
                    <button class="btn btn-lg btn-success" type="submit">
                            <i class="ace-icon fa fa-check"></i>
                            <?php echo $model->isNewRecord ? 'Crear' : 'Guardar'; ?>
                    </button>
                </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>