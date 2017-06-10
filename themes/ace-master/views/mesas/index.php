<?php $this->breadcrumbs=array(
	'Vista de Mesas',
);?>
<div class="main-content-inner">

        <div class="page-content">

                <div class="row">
                        <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <div class="row">
                                    <div id="dialog-message" class="hide"> 
                                                <?php $form1=$this->beginWidget('CActiveForm', array(
                                                        'id'=>'tikets-form',
                                                        'enableAjaxValidation'=>false,
                                                ));
                                                $pedido = new Pedidos();?>
                                                <div id="rta" style="display:none;"></div>
                                                <?php echo $form1->dropDownList(
                                                        $pedido,
                                                        'mesas_id',
                                                        CHtml::listData(Mesas::model()->findAllByAttributes(array('aplicacion_id'=>$aplicacion->id)), 'id', 'nro_mesa'),
                                                        array('empty'=>'Seleccione una mesa...', 'class'=>'form-control')
                                                        );?>
                                                <div class="row">
                                                    <?php $this->widget('zii.widgets.jui.CJuiSliderInput',array(
                                                                        'name' => 'cantidad', 
                                                                        'model'=>$pedido,
                                                                        'attribute'=>"cantidad",
                                                                        'event'=>'change',
                                                                        'value'=>'0',
                                                                      'options'=>array(
                                                                          'min'=>0,
                                                                          'max'=>40,
                                                                          'animate' => true,
                                                                          'slide'=>'js:function(event,ui){$("#cant").html(ui.value);}',
                                                                      ),
                                                    ));?>
                                                </div>
                                                <input id="spinner" name="value" type="text" />
                                                <?php $this->endWidget();?>
                                    </div><!-- #dialog-message -->
                                    <div class="widget-box">
                                            <div class="widget-header">
                                                    <h5 class="widget-title"><?php echo $aplicacion->nombre;?></h5>
                                            </div>

                                            <div class="widget-body">
                                                    <div class="widget-main">
                                                        <div id="dragZone" style="min-height:500px;" class="flash-success">
                                                            <?php
                                                                foreach ($dataProvider->data as $mesa) {
                                                                    $posStyle='';
                                                                    if($mesa->posicion) {
                                                                        $pos = json_decode($mesa->posicion,true);
                                                                        $posStyle = 'left:'.$pos['left'].'px;top:'.$pos['top'].'px;';
                                                                }
                                                                ?>
                                                                <div class="infobox infobox-green drag" id="<?php echo $mesa->id;?>" style="<?php echo $posStyle;?>">
                                                                    <div class="infobox-icon">
                                                                            <i class="ace-icon fa fa-users"></i>
                                                                    </div>

                                                                    <div class="infobox-data">
                                                                            <span class="infobox-data-number"><?php echo CHtml::encode('Nro '.$mesa->nro_mesa); ?></span>
                                                                            <div class="infobox-content">4 personas</div>
                                                                    </div>
                                                                    <span class="label label-danger arrowed-in" style="position: absolute;right: 0;top:0;">15:30 min</span>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                            </div>
                                    </div>

                                </div><!-- /.row -->
                                <!-- PAGE CONTENT ENDS -->
                        </div><!-- /.col -->
                </div><!-- /.row -->
        </div><!-- /.page-content -->
</div>

<!-- inline scripts related to this page -->
<script type="text/javascript">
        jQuery(function($) {
                //override dialog's title function to allow for HTML titles
                $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
                        _title: function(title) {
                                var $title = this.options.title || '&nbsp;'
                                if( ("title_html" in this.options) && this.options.title_html == true )
                                        title.html($title);
                                else title.text($title);
                        }
                }));

                $( "#id-btn-dialog1" ).on('click', function(e) {
                        e.preventDefault();

                        var dialog = $( "#dialog-message" ).removeClass('hide').dialog({
                                modal: true,
                                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='ace-icon fa fa-list-alt'></i> Generacion de tikets</h4></div>",
                                title_html: true,
                                buttons: [ 
                                        {
                                                text: "Cancelar",
                                                "class" : "btn btn-minier",
                                                click: function() {
                                                    $("#tikets-form")[0].reset();
                                                    $("#rta").fadeOut();
                                                    $( this ).dialog( "close" ); 
                                                } 
                                        },
                                        {
                                                text: "Generar",
                                                "class" : "btn btn-primary btn-minier",
                                                click: function() {
                                                    $.ajax({
                                                      method: "POST",
                                                      url: "<?php echo Yii::app()->createUrl('/pedidos/create');?>",
                                                      data: $("#tikets-form").serialize()
                                                    })
                                                    .done(function( data ) {
                                                        if(data=="ok"){
                                                            $("#tikets-form")[0].reset();
                                                            $("#rta").html("Creadas con exito").addClass("text-success").fadeIn();
                                                        }else{
                                                            $("#rta").html("Se produjo un error").addClass("text-danger").fadeIn();
                                                        }
                                                    });
                                                } 
                                        }
                                ]
                        });

                        /**
                        dialog.data( "uiDialog" )._title = function(title) {
                                title.html( this.options.title );
                        };
                        **/
                });
                //tooltips
                $( "#show-option" ).tooltip({
                        show: {
                                effect: "slideUp",
                                delay: 250
                        }
                });

                $( "#hide-option" ).tooltip({
                        hide: {
                                effect: "explode",
                                delay: 250
                        }
                });

                /*$( "#open-event" ).tooltip({
                        show: null,
                        position: {
                                my: "left top",
                                at: "left bottom"
                        },
                        open: function( event, ui ) {
                                ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
                        }
                });*/

                $('[data-rel=tooltip]').tooltip({container:'body'});
                
                //Menu
                $( "#menu" ).menu();


                //spinner
                var spinner = $( "#spinner" ).spinner({
                        create: function( event, ui ) {
                                //add custom classes and icons
                                $(this)
                                .next().addClass('btn btn-success').html('<i class="ace-icon fa fa-plus"></i>')
                                .next().addClass('btn btn-danger').html('<i class="ace-icon fa fa-minus"></i>')

                                //larger buttons on touch devices
                                if('touchstart' in document.documentElement) 
                                        $(this).closest('.ui-spinner').addClass('ui-spinner-touch');
                        }
                });

                //slider example
                $( "#slider" ).slider({
                        range: true,
                        min: 0,
                        max: 500,
                        values: [ 75, 300 ]
                });					
        });
</script>
<script>
$.cookie.json = true;
$(function() {
    $( ".drag" ).draggable({
        cursor: "move",
        containment: $("#dragZone"),
        stop: function( event, ui ) {
            $.ajax({
                method: "POST",
                url: "<?php echo Yii::app()->createUrl('mesas/savePosition');?>",
                data: { idm: this.id, top: ui.position.top, left: ui.position.left }
            }).done(function( msg ) {
                return true;
                //console.log(msg);
            });
            /*$.cookie(this.id+'-top',ui.offset.top);
            $.cookie(this.id+'-left',ui.offset.left);*/
        }
    });
});
$( "#tikets-dialog" ).dialog({
  close: function( event, ui ) {alert('333');}
});
</script>