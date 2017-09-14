<h3>¡<?php echo (isset(Yii::app()->user->usuario)) ? 'Hola '.Yii::app()->user->usuario->nombre.'. ' : '';?>Bienvenido al menu digital de <?php echo CHtml::encode(Yii::app()->user->aplicacion->nombre);?>!</h3>
<p>En esta aplicación podrás ordenar tu comida favorita desde tu smartphone o tableta en <b><?php echo (isset(Yii::app()->user->usuario)) ? '3' : '4';?> simples pasos</b>.</p>

<ul>
    <?php if(!isset(Yii::app()->user->usuario)) { ?>
        <li>Ve al menú suprior derecho y luego toca en <b>"Comenzar"</b></li>
    <?php } ?>
    <li><b>Conoce nuestros productos</b> en el panel superior izquierdo y selecciona los que mas te gusten.</li>
    <li>Luego de haber pedido todos los platos y bebidas que quieras, dirigete a la caja para <b>aboar</b>.</li>
    <li><b>Listo!</b> Solo aguarda que tu orden este preparada y te llamaremos para que la retires.</li>
</ul>

<p>
    Disfruta de tu comida, comparte tu experiencia en las redes sociales, agrega comentarios sobre los platos
</p>