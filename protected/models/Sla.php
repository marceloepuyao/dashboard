<?php

/**
 * This is the model class for table "sla".
 *
 * The followings are the available columns in table 'sla':
 * @property integer $id
 * @property integer $contrato_id
 * @property string $nombre
 * @property integer $objetivo
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property SeguimientoSla[] $seguimientoSlas
 */
class Sla extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sla';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, objetivo', 'required'),
			array('contrato_id', 'numerical', 'integerOnly'=>true),
			array('objetivo', 'type', 'type'=>'float'), // 'message'=>'{attribute} debe ser un número.'
			array('nombre', 'length', 'max'=>45),
			array('descripcion', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, objetivo, descripcion', 'safe', 'on'=>'search'),
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
			'contrato' => array(self::BELONGS_TO, 'Contrato', 'contrato_id'),
			'seguimientoSlas' => array(self::HAS_MANY, 'SeguimientoSla', 'sla_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contrato_id' => 'Contrato',
			'nombre' => 'Nombre',
			'objetivo' => 'Objetivo (%)',
			'descripcion' => 'Descripción',
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
		$criteria->compare('contrato_id',$this->contrato_id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('objetivo',$this->objetivo);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeDelete(){
		foreach($this->seguimientoSlas as $c)
			$c->delete();
		return parent::beforeDelete();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sla the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
