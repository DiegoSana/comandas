<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'aplicacion-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="col-xs-12 col-sm-4"  style="margin: 0 auto; float: none;">
    <div class="widget-box">
        <div class="widget-body">
            <div class="widget-main" style="padding: 30px;">
                <div class="form-group">
                    <?php echo $form->errorSummary($model); ?>
                </div>
                    
                <div class="form-group">
                        <?php echo $form->labelEx($model,'nombre'); ?>
                        <?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
                </div>

                <div class="form-group">
                        <?php echo $form->labelEx($model,'subdominio'); ?>
                        <?php echo $form->textField($model,'subdominio',array('size'=>45,'maxlength'=>45)); ?>
                </div>

                <div class="form-group">
                        <?php echo $form->labelEx($model,'empresa_id'); ?>
                        <?php
                            echo $form->dropDownList(
                                    $model,
                                    'empresa_id',
                                    CHtml::listData(Empresa::model()->findAll(), 'id', 'nombre'),
                                    array('empty'=>'Seleccione una empresa...')
                                    );
                        ?>
                </div>

                <div class="form-group">
                    <button class="btn btn-lg btn-success" type="submit">
                            <i class="ace-icon fa fa-check"></i>
                            <?php echo $model->isNewRecord ? 'Crear' : 'Guardar'; ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>