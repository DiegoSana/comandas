<?php

/**
 * This is the model class for table "aplicacion".
 *
 * The followings are the available columns in table 'aplicacion':
 * @property integer $id
 * @property string $nombre
 * @property integer $empresa_id
 * @property string $subdominio
 *
 * The followings are the available model relations:
 * @property Empresa $empresa
 * @property Usuarios[] $usuarios
 * @property Mesas[] $mesas
 * @property Productos[] $productos
 * 
 */
class Aplicacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'aplicacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, empresa_id', 'required'),
			array('empresa_id', 'numerical', 'integerOnly'=>true),
			array('nombre, subdominio', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, empresa_id, subdominio, mesa_default_id', 'safe', 'on'=>'search'),
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
			'empresa' => array(self::BELONGS_TO, 'Empresa', 'empresa_id'),
                        'mesas' => array(self::HAS_MANY, 'Mesas', 'aplicacion_id'),
                        'productos' => array(self::HAS_MANY, 'Productos', 'aplicacion_id'),
			'usuarios' => array(self::MANY_MANY, 'Usuarios', 'usuarios_aplicacion(aplicacion_id, usuarios_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Aplicacion',
			'empresa_id' => 'Empresa',
                        'subdominio' => 'Subdominio',
                        'mesa_default_id' => 'Mesa default'
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
		$criteria->compare('empresa_id',$this->empresa_id);
                $criteria->compare('subdominio',$this->subdominio,true);
                $criteria->compare('mesa_default_id',$this->mesa_default_id,true);
                if(Yii::app()->user->checkAccess('superadmin'))
                    $criteria->addCondition('id IS NOT NULL');
                else
                    $criteria->addCondition('id = '.Yii::app()->user->aplicacion->id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getAll() {
                if(Yii::app()->user->checkAccess('superadmin',Yii::app()->user->id))
                    $cond = 'id IS NOT NULL';
                elseif(count(Yii::app()->user->aplicaciones)>1) {
                    $arrApps = array();
                    foreach (Yii::app()->user->aplicaciones as $app)
                        array_push ($arrApps, $app->id);
                    $cond = 'id IN ('.implode(',', $arrApps).')';
                } else
                    $cond = 'id = '.Yii::app()->user->aplicacion->id;
                $apps = Aplicacion::model()->findAllByAttributes(array(),$cond);
                return $apps;
        }

        /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Aplicacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
