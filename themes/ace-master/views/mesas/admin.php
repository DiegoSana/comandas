<?php
/* @var $this MesasController */
/* @var $model Mesas */

$this->breadcrumbs=array(
	'Administrador de Mesas',
);
?>
<div class="page-header">
        <h1>
                Administrar mesas
        </h1>
</div><!-- /.page-header -->

<div class="row">
    <a href="<?php echo Yii::app()->createUrl('/mesas/create')?>" class="btn btn-primary btn-yellow" style="float: right;margin: 0 24px;">
        <i class="ace-icon fa fa-tags align-top bigger-125"></i>
        Nueva mesa
    </a>
    <div class="col-xs-12 col-sm-offset-3">
        <div class="col-xs-12 col-sm-6">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'mesas-grid',
                    'dataProvider'=>$model->search(),
                    'itemsCssClass'=>'table table-striped table-bordered table-hover',
                    //'filter'=>$model,
                    'columns'=>array(
                            'nro_mesa',
                            'aplicacion.nombre',
                            array(
                                    'class'=>'CButtonColumn',
                                    'htmlOptions'=>array('style'=>'width: 50%'),
                                    'template'=>'{delete}{update}',
                                    'buttons'=>array
                                    (
                                        'delete'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'tooltip-error toolt btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-120', 'title'=>'Eliminar'), //HTML options for the button tag.
                                        ),
                                        'update'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'tooltip-info toolt btn btn-xs btn-info ace-icon fa fa-pencil bigger-120', 'title'=>'Editar'), //HTML options for the button tag.
                                        )
                                    )
                            ),
                    ),
            )); ?> 
        </div>
    </div>
</div>
