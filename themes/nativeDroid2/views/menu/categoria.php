			<ul data-role="listview" data-icon="false">
				<li data-role="list-divider">
					<?php echo $categoria->nombre.' >';?>
				</li>
                                <?php
                                foreach ($productos as $producto)
                                {
                                ?>
                                    <li>
                                        <a style="padding-right: 2em; padding-left: 5em;" href="<?php echo Yii::app()->createUrl('menu/producto',array('producto'=>$producto->id, 'categoria'=>$categoria->id));?>">
                                            <img style="left: 0em;" class="ui-thumbnail ui-thumbnail-circular" src="<?php echo ($producto->productosImagenes) ? '/images/productos/'.$producto->productosImagenes[0]->nombre : '/images/noimage.jpg';?>">
                                            <h2><?php echo $producto->nombre;?></h2>
                                            <p><?php echo $producto->descripcion;?></p>                                            
                                        </a>
                                        <p class="ui-li-aside" style="font-size: 1.1em; right:0.333em;"><strong><?php echo '$ '.$producto->precio;?></strong></p>
                                    </li>
                                <?php
                                }
                                ?>
                        </ul>