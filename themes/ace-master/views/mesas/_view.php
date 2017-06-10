<?php
/* @var $this MesasController */
/* @var $data Mesas */
var_dump(Yii::app()->clientScript);die;
?>
  <style>
  #draggable { width: 150px; height: 150px; padding: 0.5em; }
  </style>
  <script>
  $(function() {
    $( ".drag" ).draggable({containment: $(".items")});
  });
  </script>
  
<div id="draggable" class="flash-notice drag">
<p><?php echo CHtml::encode('Mesa '.$data->nro_mesa); ?></p>
<?php echo CHtml::encode($data->aplicacion->nombre); ?>
</div>