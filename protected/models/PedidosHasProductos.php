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
class PedidosHasProductos extends CActiveRecord
{
        
        public $selected_option;
        
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
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pedidos_id, productos_id, observaciones, pedidos_has_productos_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'N° Pedido',
			'pedidos_id' => 'Pedidos',
			'productos_id' => 'Productos',
			'observaciones' => 'Observaciones',
			'pedidos_has_productos_id' => 'Pedidos Has Productos',
                        'selected_option'=>'Opción seleccionada',
                        'hora_pedido'=>'Hora del pedido',
                        'pedidos_has_productos_estados_id'=>'Estado',
		);
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('pedidos_id',$this->pedidos_id);
		$criteria->compare('productos_id',$this->productos_id);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('pedidos_has_productos_id',$this->pedidos_has_productos_id,true);

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
