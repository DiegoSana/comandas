<?php
$this->breadcrumbs=array(
	'Categorías'=>array('index'),
	'Administrar',
);
?>
<div class="page-header">
        <h1>
                Administrar categorías
                <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Categorías del menú
                </small>
        </h1>
</div><!-- /.page-header -->

<div class="row">
    <a href="<?php echo Yii::app()->createUrl('/categorias/create')?>" class="btn btn-primary btn-yellow" style="float: right;margin: 0 12px;">
        <i class="ace-icon fa fa-tag align-top bigger-125"></i>
        Nueva categoría
    </a>
    <div class="col-xs-12 col-lg-10">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'categorias-grid',
                    'dataProvider'=>$model->search(),
                    'itemsCssClass'=>'table table-striped table-bordered table-hover',
                    'pagerCssClass'=>'dataTables_paginate paging_simple_numbers',
                    //'filter'=>$model,
                    'columns'=>array(
                            'nombre',
                            'descripcion',
                            array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{update}{delete}',
                                    'htmlOptions'=>array('style'=>'display:inline-flex;'),                                
                                    'buttons'=>array
                                    (
                                        'delete'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'tooltip-error toolt btn btn-xs btn-danger ace-icon fa fa-trash-o', 'title'=>'Eliminar'), //HTML options for the button tag.
                                        ),
                                        'update'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'tooltip-info toolt btn btn-xs btn-info ace-icon fa fa-pencil', 'title'=>'Editar'), //HTML options for the button tag.
                                        )/*,
                                        'view'=>array(
                                                'label'=>'',
                                                'imageUrl'=>'',  //Image URL of the button.
                                                'options'=>array('class'=>'tooltip-warning toolt btn btn-xs btn-warning ace-icon fa fa-info-circle', 'style'=>'display:inline-block;'), //HTML options for the button tag.
                                        )*/
                                    )
                            ),
                    ),
            )); ?> 
    </div>
</div>