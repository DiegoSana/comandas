<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="row">
    
    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
            <div class="widget-box">
                    <div class="widget-header">
                            <h4 class="widget-title">Configuraciones</h4>

                            <span class="widget-toolbar">
                                    <a href="#" data-action="settings"><i class="ace-icon fa fa-cog"></i></a>
                            </span>
                    </div>

                    <div class="widget-body">
                            <div class="widget-main">
                                <?php $form=$this->beginWidget('CActiveForm', array(
                                        'id'=>'settings-form',
                                        'method'=>'POST',
                                        'action'=>'/site/settings',
                                        'htmlOptions'=>array('class'=>''),
                                        'enableAjaxValidation'=>false,
                                )); ?>
                                    <div>
                                            <?php echo $form->labelEx($aplicacion,'nombre'); ?>
                                            <?php
                                                echo $form->dropDownList(
                                                        $aplicacion,
                                                        'id',
                                                        CHtml::listData($aplicaciones, 'id', 'nombre'),
                                                        array(
                                                            'empty'=>'Seleccione una aplicacion...',
                                                            'class'=>'form-control',
                                                            'onchange'=>'this.form.submit()'
                                                            )
                                                        );
                                            ?>
                                    </div>
                                <?php $this->endWidget(); ?>
                            </div>
                    </div>
            </div>
    </div>
    
</div>