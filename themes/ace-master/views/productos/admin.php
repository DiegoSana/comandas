<?php
/* @var $this ProductosController */
/* @var $model Productos */

$this->breadcrumbs=array(
	'Productos'=>array('index'),
	'Admnistrar',
);
?>
<div class="page-header">
        <h1>
                Administrador de productos
        </h1>
</div><!-- /.page-header -->

<div class="row">
    <a href="<?php echo Yii::app()->createUrl('/productos/create');?>" class="btn btn-primary" style="float: right; margin: 1em 24px;">
        <i class="ace-icon fa fa-cutlery align-top bigger-125"></i>
        Nuevo producto
    </a>
    <div class="col-xs-12">
        <div class="col-xs-12">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'productos-grid',
                    'dataProvider'=>$model->search(),
                    'itemsCssClass'=>'table table-striped table-bordered table-hover',
                    'pagerCssClass'=>'dataTables_paginate paging_simple_numbers',
                    //'filter'=>$model,
                    'columns'=>array(
                            'nombre',
                            array(
                                'name'=>'descripcion',
                                'value'=>'$data->descripcion',
                                'htmlOptions'=>array('class'=>'hidden-320'),
                                'headerHtmlOptions'=>array('class'=>'hidden-320'),
                            ),
                            array(
                                'name'=>'precio',
                                'value'=>'"$ ".$data->precio'
                            ),
                            array(
                                'name'=>'preparacion_cocina',
                                'value'=>'$data->preparacion_cocina ? "Si" : "No"'
                            ),
                            array(
                                'name'=>'mostrable',
                                'value'=>'$data->mostrable ? "Si" : "No"'
                            ),
                            array(
                                'name'=>'Opciones',
                                'value'=>'formatOpciones($data->productosOpciones);',
                                'htmlOptions'=>array('class'=>'hidden-480'),
                                'headerHtmlOptions'=>array('class'=>'hidden-480'),
                            ),
                            array(
                                'name'=>'categorias',
                                'value'=>'formatCategorias($data->categorias)',
                                'htmlOptions'=>array('class'=>'hidden-480'),
                                'headerHtmlOptions'=>array('class'=>'hidden-480'),
                            ),
                            array(
                                     'class'=>'CButtonColumn',
                                     'htmlOptions'=>array('style'=>'display:inline-flex;'),
                                     'buttons'=>array
                                     (
                                         'delete'=>array(
                                                 'label'=>'',
                                                 'imageUrl'=>'',  //Image URL of the button.
                                                 'options'=>array('class'=>'toolt tooltip-error btn btn-xs btn-danger ace-icon fa fa-trash-o bigger-120','title'=>'Dar de baja'), //HTML options for the button tag.
                                         ),
                                         'update'=>array(
                                                 'label'=>'',
                                                 'imageUrl'=>'',  //Image URL of the button.
                                                 'options'=>array('class'=>'toolt tooltip-info btn btn-xs btn-info ace-icon fa fa-pencil bigger-120','title'=>'Editar'), //HTML options for the button tag.
                                         ),
                                         'view'=>array(
                                                 'label'=>'',
                                                 'imageUrl'=>'',  //Image URL of the button.
                                                 'options'=>array('class'=>'toolt tooltip-warning btn btn-xs btn-warning ace-icon fa fa-info-circle bigger-120','title'=>'Ver'), //HTML options for the button tag.
                                         )
                                     )
                             ),
                    ),
            )); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(function($) {
    <?php foreach(Yii::app()->user->getFlashes() as $key => $message) {?>
                $.gritter.add({
                        title: '<?php echo $message;?>',
                        text: '',
                        class_name: 'gritter-<?php echo $key;?>'
                });
                return false;
    <?php }?>
});
</script>

<?php
function formatCategorias($categorias){
    
    foreach ($categorias as $key => $categoria)
    {        
        echo( '<a class="toolt" title="Ir a la categoría" href="'.Yii::app()->createAbsoluteUrl('/categorias/view',array('id' => $categoria->id)).'">'.$categoria->nombre.'</a>');
        $arrKeys = array_keys($categorias);
        if(end($arrKeys) != $key)
            echo ' - ';
    }
}

function formatOpciones($productosOpciones) {
    
    if($productosOpciones){
        $row = '';
        foreach($productosOpciones as $k => $opcion){
            $row .= $opcion->nombre.': ';
            foreach($opcion->productos as $key => $prod){
                $row .= $prod->nombre;
                if((count($opcion->productos)-1) != $key)
                    $row .= ' - ';
            }
            if((count($productosOpciones)-1) != $k)
                $row .= '<br>';
        }
        echo $row;
    }
}
?>