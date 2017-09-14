<?php

/**
 * This is the model class for table "pedidos_has_productos".
 *
 * The followings are the available columns in table 'pedidos_has_productos':
 * @property string $id
 * @property integer $pedidos_id
 * @property integer $productos_id
 * @property string $observaciones
 * @property string $pedidos_has_productos_id
 * @property integer $pedidos_has_productos_estados_id
 *
 * The followings are the available model relations:
 * @property PedidosHasProductos $pedidosHasProductos
 * @property PedidosHasProductos[] $pedidosHasProductoses
 * @property Pedidos $pedidos
 * @property Productos $productos
 */
class   PedidosHasProductos extends CActiveRecord
{
        
        public $selected_option;
        public $nro_mesa_search;
        public $usuario_nombre_search;
        public $productos_nombre_search;
        public $estado_search;
        public $nro_pedido_search;

        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pedidos_has_productos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pedidos_id, productos_id, pedidos_has_productos_estados_id', 'required'),
			array('pedidos_id, productos_id', 'numerical', 'integerOnly'=>true),
			array('id, pedidos_has_productos_id', 'length', 'max'=>45),
			array('observaciones', 'length', 'max'=>100),
            //array('hora_pedido, hora_pedido_entregado', 'date'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pedidos_id, productos_id, observaciones, pedidos_has_productos_id, nro_mesa_search, usuario_nombre_search, productos_nombre_search,estado_search,nro_pedido_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'pedidosHasProductos' => array(self::BELONGS_TO, 'PedidosHasProductos', 'pedidos_has_productos_id'),
			'pedidosHasProductoses' => array(self::HAS_MANY, 'PedidosHasProductos', 'pedidos_has_productos_id'),
            'pedidosHasProductosEstados' => array(self::BELONGS_TO, 'PedidosHasProductosEstados', 'pedidos_has_productos_estados_id'),
			'pedidos' => array(self::BELONGS_TO, 'Pedidos', 'pedidos_id'),
			'productos' => array(self::BELONGS_TO, 'Productos', 'productos_id'),
            'mesa' => array(self::HAS_ONE, 'Mesas', 'mesas_id', 'through' => 'pedidos'),
            'usuario' => array(self::HAS_ONE, 'Usuarios', 'hash', 'through' => 'pedidos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'N° Orden',
			'pedidos_id' => 'Pedidos',
			'productos_id' => 'Productos',
			'observaciones' => 'Observaciones',
			'pedidos_has_productos_id' => 'Pedidos Has Productos',
            'selected_option'=>'Opción seleccionada',
            'hora_pedido'=>'Hora del pedido',
            'pedidos_has_productos_estados_id'=>'Estado',
            'nro_mesa_search' => 'Mesa',
            'usuario_nombre_search' => 'Pedido por',
            'productos_nombre_search' => 'Producto',
            'estado_search' => 'Estado',
            'nro_pedido_search' => 'N° Pedido',
		);
	}

	public function isAdicional() {
	    if($this->pedidos_has_productos_id) return false;
	    if(PedidosHasProductos::model()->findByAttributes(['pedidos_has_productos_id' => $this->id])) return true;
	    return false;
    }

    protected function formatAdicionales() {
	    $arr = [];
        foreach ($this->pedidosHasProductoses as $pedidosHasProducto) {
            $arr[] = $pedidosHasProducto->productos->nombre;
	    }
	    return implode(', ',$arr);
    }

    protected function getPrecioConAdicionales() {
        $price = $this->productos->precio;
        foreach ($this->pedidosHasProductoses as $pedidosHasProducto) {
            $price += $pedidosHasProducto->productos->precio;
        }
        return $price;
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = ['mesa','usuario','productos','pedidosHasProductosEstados','pedidos'];

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('pedidos_id',$this->pedidos_id);
		$criteria->compare('productos_id',$this->productos_id);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('pedidos_has_productos_id',$this->pedidos_has_productos_id,true);
		if(strtolower($this->nro_mesa_search) == 'sin mesa') {
            $criteria->compare('mesa.nro_mesa',0,true);
        } else {
            $criteria->compare('mesa.nro_mesa',$this->nro_mesa_search,true);
        }
        $criteria->compare('usuario.nombre',$this->usuario_nombre_search,true);
        $criteria->compare('productos.nombre',$this->productos_nombre_search,true);
        $criteria->compare('pedidosHasProductosEstados.estado', $this->estado_search,true);
        $criteria->compare('pedidos.id',$this->nro_pedido_search,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PedidosHasProductos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
