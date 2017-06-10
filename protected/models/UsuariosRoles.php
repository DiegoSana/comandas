<?php

/**
 * This is the model class for table "usuarios_roles".
 *
 * The followings are the available columns in table 'usuarios_roles':
 * @property integer $usuarios_id
 * @property integer $roles_id
 */
class UsuariosRoles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuarios_id, roles_id', 'required'),
                        array('usuarios_id, roles_id', 'validarPk'),
			array('usuarios_id, roles_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('usuarios_id, roles_id', 'safe', 'on'=>'search'),
		);
	}


        public function validarPk($attribute,$params)
        {
            if($this->usuarios_id && $this->roles_id)
                if (UsuariosRoles::model()->findByPk(array("usuarios_id"=>$this->usuarios_id, "roles_id"=>$this->roles_id)))
                    $this->addError($attribute, 'El usuario ya se encuentra asociado al rol seleccionado');
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
                    'roles' => array(self::BELONGS_TO, 'Roles', 'roles_id'),                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'usuarios_id' => 'Usuarios',
			'roles_id' => 'Roles',
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
		$criteria->compare('roles_id',$this->roles_id);
                if(!Yii::app()->user->checkAccess('superadmin',Yii::app()->user->id))
                {
                    $usuariosXAplicacion = Usuarios::model()->search()->getData();
                    $arr = array();
                    foreach ($usuariosXAplicacion as $usuario)
                        $arr[] = $usuario->id;                    
                    if ($arr)
                        $condition = 'usuarios_id IN ('.implode(',', $arr).')';
                    else
                        $condition = '';
                    if(!Yii::app()->user->checkAccess('admin',Yii::app()->user->id))
                        $condition1 = 'roles.id != 1 OR roles.id IS NULL'; // no mostrar roles 'admin;
                    else
                        $condition1 = '';
                }
                else
                    $condition = $condition1 = '';
                $criteria->with = array(
                    'usuarios'=>array(
                        'condition'=>$condition,
                    ),
                    'roles'=>array(
                        'condition'=>$condition1,
                    )
                );
                $criteria->together = true;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuariosRoles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
