<?php

/**
 * This is the model class for table "productos".
 *
 * The followings are the available columns in table 'productos':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property double $precio
 * @property integer $aplicacion_id
 * @property integer $mostrable
 *
 * The followings are the available model relations:
 * @property Aplicacion $aplicacion
 * @property Categorias[] $categorias
 * @property ProductosOpciones[] $productosOpciones
 * @property ProductosImagenes[] $productosImagenes
 */
class Productos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'productos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, aplicacion_id', 'required'),
			array('aplicacion_id, mostrable, preparacion_cocina', 'numerical', 'integerOnly'=>true),
			array('precio', 'numerical'),
			array('nombre', 'length', 'max'=>45),
			array('descripcion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, preparacion_cocina, precio, aplicacion_id, mostrable', 'safe', 'on'=>'search'),
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
			'aplicacion' => array(self::BELONGS_TO, 'Aplicacion', 'aplicacion_id'),
			'categorias' => array(self::MANY_MANY, 'Categorias', 'productos_has_categorias(productos_id, categorias_id)'),
			'productosOpciones' => array(self::MANY_MANY, 'ProductosOpciones', 'productos_has_productos_opciones(productos_id, productos_opciones_id)'),
			'productosImagenes' => array(self::HAS_MANY, 'ProductosImagenes', 'productos_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Producto',
			'descripcion' => 'Descripcion',
			'precio' => 'Precio',
			'aplicacion_id' => 'Aplicacion',
			'mostrable' => 'Mostrable',
                        'preparacion_cocina'=>'Preparación en cocina'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('precio',$this->precio);
		$criteria->compare('aplicacion_id',$this->aplicacion_id);
		$criteria->compare('mostrable',$this->mostrable);
                $criteria->compare('preparacion_cocina',$this->preparacion_cocina);
                $criteria->with[] = 'categorias';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Productos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
