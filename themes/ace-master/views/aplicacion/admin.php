<?php
$this->breadcrumbs=array(
	'Aplicaciones'=>array('index'),
	'Administrar',
);
?>
<div class="page-header">
        <h1>
                Administrar aplicaciones
        </h1>
</div><!-- /.page-header -->

<div class="row">
    <a href="<?php echo Yii::app()->createUrl('/aplicacion/create')?>" class="btn btn-primary btn-yellow" style="float: right;margin: 0 12px;">
        <i class="ace-icon fa fa-coffee align-top bigger-125"></i>
        Nueva aplicación
    </a>
    <div class="col-xs-12 col-md-8 col-md-offset-2">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'aplicacion-grid',
                    'dataProvider'=>$model->search(),
                    'itemsCssClass'=>'table table-striped table-bordered table-hover',
                    'columns'=>array(
                            'nombre',
                            'subdominio',
                            'empresa.nombre',
                            array(
                                    'class'=>'CButtonColumn',
                                    'buttons'=>array
                                    (
                                        'delete'=>array(
                                                'visible'=>'false',
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-120', 'style'=>'display:inline-flex;'), //HTML options for the button tag.
                                        ),
                                        'update'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'btn btn-xs btn-info ace-icon fa fa-pencil bigger-120', 'style'=>'display:inline-flex;'), //HTML options for the button tag.
                                        ),
                                        'view'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'btn btn-xs btn-warning ace-icon fa fa-info-circle bigger-120', 'style'=>'display:inline-flex;'), //HTML options for the button tag.
                                        )
                                    )
                            ),
                    ),
            )); ?>
        </div>
    </div>
</div>
