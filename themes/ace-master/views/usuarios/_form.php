<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuarios-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="col-xs-12 col-sm-4"  style="margin: 0 auto; float: none;">
    <div class="widget-box">
        <div class="widget-body">
            <div class="widget-main" style="padding: 30px;">
                <div class="form-group">
                    <?php echo $form->errorSummary(array($model,$usuariosAplicacion,$usuariosRoles)); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'usuario'); ?>
                    <div class="row"><?php echo $form->textField($model,'usuario',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?></div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'nombre'); ?>
                    <div class="row"><?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?></div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'apellido'); ?>
                    <div class="row"><?php echo $form->textField($model,'apellido',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?></div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'email'); ?>
                    <div class="row"><?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?></div>
                </div>
                <?php
                if($model->isNewRecord) {
                ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'pass'); ?>
                        <div class="row"><?php echo $form->passwordField($model,'pass',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?></div>
                    </div>
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'repass'); ?>
                        <div class="row"><?php echo $form->passwordField($model,'repass',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?></div>
                    </div>
                <?php }?>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'empresa_id'); ?>
                    <div class="row"><?php
                        if(Yii::app()->user->checkAccess('superadmin'))
                            $empresas = Empresa::model()->findAll();
                        else
                            $empresas = Empresa::model()->findAllByPk(array('id'=>  Yii::app()->user->usuario->empresa_id));
                        echo $form->dropDownList(
                                $model,
                                'empresa_id',
                                CHtml::listData($empresas, 'id', 'nombre'),
                                array('empty'=>'Seleccione una empresa...','class'=>'form-control')
                                );
                    ?></div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($usuariosRoles,'Rol'); ?>
                    <div class="row"><?php
                        echo $form->dropDownList(
                                $usuariosRoles,
                                'roles_id',
                                CHtml::listData(Roles::model()->findAllByAttributes(array(), 'orden >= '.Yii::app()->user->usuario->roles[0]->orden), 'id', 'rol'),
                                array('empty'=>'Seleccione un rol...','class'=>'form-control')
                                );
                    ?></div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($usuariosAplicacion,'Aplicación'); ?>
                    <div class="row"><?php
                        foreach (Yii::app()->user->usuario->aplicaciones as $ap)
                            $appsUserIds[] = $ap->id;
                        if(isset($appsUserIds))
                            $aps = Aplicacion::model()->findAllByAttributes(array(), 'id in ('.  implode(',', $appsUserIds).')');
                        elseif(Yii::app()->user->checkAccess('superadmin'))
                            $aps = Aplicacion::model()->findAll();
                        echo $form->dropDownList(
                                $usuariosAplicacion,
                                'aplicacion_id',
                                CHtml::listData($aps, 'id', 'nombre'),
                                array('empty'=>'Seleccione una aplicación...','class'=>'form-control')
                                );
                    ?></div>
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