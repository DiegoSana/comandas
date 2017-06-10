<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property integer $id
 * @property string $usuario
 * @property string $nombre
 * @property string $apellido
 * @property string $email
 * @property string $pass
 * @property integer $empresa_id
 *
 * The followings are the available model relations:
 * @property Empresa $empresa
 * @property Aplicacion[] $aplicaciones
 */
class Usuarios extends CActiveRecord
{
        public $repass;
        
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('pass, repass', 'required', 'on'=>'insert'),
                        array('pass, repass', 'length', 'min'=>6, 'max'=>40),
                        array('pass', 'compare', 'compareAttribute'=>'repass', 'on'=>'insert'),
			array('usuario, nombre, apellido, empresa_id', 'required'),
			array('empresa_id', 'numerical', 'integerOnly'=>true),
			array('usuario, nombre, apellido, email', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, nombre, apellido, email, empresa_id', 'safe', 'on'=>'search'),
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
			'aplicaciones' => array(self::MANY_MANY, 'Aplicacion', 'usuarios_aplicacion(usuarios_id, aplicacion_id)','joinType' => 'LEFT OUTER JOIN'),
                        'roles' => array(self::MANY_MANY, 'Roles', 'usuarios_roles(usuarios_id, roles_id)','joinType' => 'LEFT OUTER JOIN'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Usuario',
			'nombre' => 'Nombre',
			'apellido' => 'Apellido',
			'email' => 'Email',
			'pass' => 'Pass',
                        'repass'=>'Repetir contrasena',
			'empresa_id' => 'Empresa',
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
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido',$this->apellido,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('empresa_id',$this->empresa_id);
                $criteria->compare('estado',1);
                
                if(!Yii::app()->user->checkAccess('superadmin'))
                    $criteria->compare('t.empresa_id',Yii::app()->user->usuario->empresa_id);
                
                $criteria->together = true;
                $criteria->with = array('aplicaciones','roles');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function beforeSave() {
            if($this->isNewRecord/* || $this->scenario == 'update'*/)
                $this->pass = sha1 ($this->usuario.$this->pass);
            return parent::beforeSave();
        }

        /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
