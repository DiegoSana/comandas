<?php

/**
 * This is the model class for table "pedidos".
 *
 * The followings are the available columns in table 'pedidos':
 * @property integer $id
 * @property integer $mesas_id
 * @property string $hash
 * @property integer $pedidos_estados_id
 * @property string $qr_image
 *
 * The followings are the available model relations:
 * @property Mesas $mesas
 * @property PedidosEstados $pedidosEstados
 * @property Productos[] $productoses
 */
class Pedidos extends CActiveRecord
{
        const ACTIVO = 1; // Esta siendo utilizado
        const CERRADO = 2; // Ya se uso
        const PENDIENTE = 3; //Todavia no fue usado
        
        public $cantidad; // Es la cantidad de tikets a generar
        public $total;

        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pedidos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mesas_id, hash, pedidos_estados_id', 'required'),
			array('mesas_id, pedidos_estados_id,aplicacion_id', 'numerical', 'integerOnly'=>true),
			array('hash', 'length', 'max'=>32),
			array('qr_image', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mesas_id, aplicacion_id, hash, pedidos_estados_id, qr_image', 'safe', 'on'=>'search'),
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
			'mesas' => array(self::BELONGS_TO, 'Mesas', 'mesas_id'),
			'pedidosEstados' => array(self::BELONGS_TO, 'PedidosEstados', 'pedidos_estados_id'),
			'productoses' => array(self::MANY_MANY, 'Productos', 'pedidos_has_productos(pedidos_id, productos_id)'),
                        'productos' => array(self::HAS_MANY, 'PedidosHasProductos', 'pedidos_id'),
                        'usuario' => array(self::BELONGS_TO, 'Usuarios', 'hash'),
                        'pedidosHasProductos' => array(self::HAS_MANY, 'PedidosHasProductos', 'pedidos_id'),
                        'aplicacion' =>array(self::BELONGS_TO, 'Aplicacion', 'aplicacion_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'N° Pedido',
			'mesas_id' => 'Mesas',
			'hash' => 'Hash',
			'pedidos_estados_id' => 'Pedidos Estados',
			'qr_image' => 'Qr Image',
                        'total'=>'Total',
                        'aplicacion_id' => 'N° Aplicación'
		);
	}

        public function setTotal() {
            $total = 0;
            foreach ($this->productos as $producto) {
                $total = $total + $producto->productos->precio;
            }
            $this->total = $total;
        }
        
        public function getTotal() {
            $this->setTotal();
            return $this->total;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('mesas_id',$this->mesas_id);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('pedidos_estados_id',$this->pedidos_estados_id);
		$criteria->compare('qr_image',$this->qr_image,true);
                $criteria->with[] = 'usuario';
                $criteria->with[] = 'aplicacion';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pedidos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
