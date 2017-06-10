<?php

/**
 * This is the model class for table "usuarios_aplicacion".
 *
 * The followings are the available columns in table 'usuarios_aplicacion':
 * @property integer $usuarios_id
 * @property integer $aplicacion_id
 */
class UsuariosAplicacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios_aplicacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuarios_id, aplicacion_id', 'required'),
                        array('usuarios_id, aplicacion_id', 'validarPk'),
			array('usuarios_id, aplicacion_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('usuarios_id, aplicacion_id', 'safe', 'on'=>'search'),
		);
	}

        public function validarPk($attribute,$params)
        {
            if($this->usuarios_id && $this->aplicacion_id)
            {
                if (UsuariosAplicacion::model()->findByPk(array("usuarios_id"=>$this->usuarios_id, "aplicacion_id"=>$this->aplicacion_id)))
                    $this->addError($attribute, 'El usuario ya se encuentra asociado a la aplicacion');
            }
        }

        /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'usuarios' => array(self::BELONGS_TO, 'Usuarios', 'usuarios_id'),
                    'aplicacion' => array(self::BELONGS_TO, 'Aplicacion', 'aplicacion_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'usuarios_id' => 'Usuarios',
			'aplicacion_id' => 'Aplicacion',
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

		$criteria->compare('usuarios_id',$this->usuarios_id);
		$criteria->compare('aplicacion_id',$this->aplicacion_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuariosAplicacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
