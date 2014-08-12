<?php

/**
 * This is the model class for table "seguimiento_percepcion_general".
 *
 * The followings are the available columns in table 'seguimiento_percepcion_general':
 * @property integer $id
 * @property integer $cliente_id
 * @property integer $per_cliente
 * @property integer $per_sm
 * @property integer $fecha
 *
 * The followings are the available model relations:
 * @property Cliente $cliente
 */
class SeguimientoPercepcionGeneral extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seguimiento_percepcion_general';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cliente_id', 'required'),
			array('cliente_id, per_cliente, per_sm, fecha', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cliente_id, per_cliente, per_sm, fecha', 'safe', 'on'=>'search'),
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
			'cliente' => array(self::BELONGS_TO, 'Cliente', 'cliente_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cliente_id' => 'Cliente',
			'per_cliente' => 'Per Cliente',
			'per_sm' => 'Per Sm',
			'fecha' => 'Fecha',
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
		$criteria->compare('cliente_id',$this->cliente_id);
		$criteria->compare('per_cliente',$this->per_cliente);
		$criteria->compare('per_sm',$this->per_sm);
		$criteria->compare('fecha',$this->fecha);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeguimientoPercepcionGeneral the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
