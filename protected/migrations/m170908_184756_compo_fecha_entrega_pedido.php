<?php

class m170908_184756_compo_fecha_entrega_pedido extends CDbMigration
{
	public function up()
	{
	    $this->addColumn('pedidos_has_productos','hora_pedido_entregado','TIMESTAMP');
	}

	public function down()
	{
		echo "m170908_184756_compo_fecha_entrega_pedido does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}