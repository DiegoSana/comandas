<?php
$numPedido = count($pedidos);
foreach ($pedidos as $k=>$pedido) {
    $collapse = ($k===0) ? 'false' : 'true';
?>
<div data-role="collapsible" data-collapsed="<?= $collapse?>" data-inset="false">
    <h4>Pedido número <?php echo $numPedido; ?><span style="float: right;">$ <?php echo $pedido->getTotal()?></span></h4>
    <ul data-role="listview"  data-icon="false" class="ui-listview">
          <?php foreach ($pedido->productos as $pedProds){
                    if(!$pedProds->pedidos_has_productos_id){
              ?>
          <li>
              <a href="#"  class="ui-btn waves-effect waves-button waves-effect waves-button" style="padding-left: 1em;">
                    <?php echo $pedProds->productos->nombre;?>
                    <?php if($pedProds->pedidosHasProductoses) {
                            $ops = formatOpciones($pedProds->productos->productosOpciones,$pedProds->pedidosHasProductoses);
                            foreach ($ops as $op){
                                echo '<p>'.$op.$pedProds->pedidosHasProductos->productos->precio.'</p>';
                            }
                    }?>
                    <p><?php echo $pedProds->observaciones;?></p>
                    <p class="ui-li-aside ui-li-desc" style="right: 1em;"><strong><?php echo '$'.$pedProds->productos->precio;?></strong></p>
              </a>
          </li>
          <?php }}?>
    </ul>
    <button class="ui-btn waves-effect waves-button waves-effect waves-button"><i class="fa fa-info-circle ui-pull-left"></i> ver estado</button>
    <i style="color: red;">Por cualquier modificación en el pedido, comuniquese con el personal</i>    
</div>
<?php
    $numPedido--;
}
?>


<?php
function formatOpciones($opciones, $selecciones)
{
    $res = array();
    foreach ($opciones as $k => $opcion)
    {
        if(isset($selecciones[$k])){
            $res[] = $opcion->nombre.' - '.$selecciones[$k]->productos->nombre.' (+ $'.$selecciones[$k]->productos->precio.')';
        }
    }
    return $res;
}
?>