<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $email
 * @property string $password
 * @property integer $perfil_id
 *
 * The followings are the available model relations:
 * @property Cliente[] $clientes
 * @property Perfil $perfil
 */
class Usuario extends CActiveRecord
{
	
	public $confirmpassword;
	public $newpassword;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('confirmpassword', 'compare', 'on'=>'update', 'compareAttribute'=>'newpassword'),
			array('confirmpassword', 'compare', 'on'=>'insert', 'compareAttribute'=>'password'),
			array('confirmpassword', 'safe'),
			array('newpassword', 'safe'),
			array('password, confirmpassword', 'required', 'on'=>'insert'),
				
			array('nombre, apellido, email, password, perfil_id', 'required'),
			array('perfil_id', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido, password', 'length', 'max'=>45),
			array('email', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, apellido, email, password, perfil_id', 'safe', 'on'=>'search'),
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
			'clientes' => array(self::HAS_MANY, 'Cliente', 'usuario_id'),
			'perfil' => array(self::BELONGS_TO, 'Perfil', 'perfil_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'apellido' => 'Apellido',
			'email' => 'Email',
			'password' => 'Contraseña',
			'perfil_id' => 'Perfil',
			'confirmpassword' => 'Confirmar Contraseña',
			'newpassword' => 'Nueva Contraseña',
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
		$criteria->compare('apellido',$this->apellido,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('perfil_id',$this->perfil_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
