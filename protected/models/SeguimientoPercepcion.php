<?php

/**
 * This is the model class for table "seguimiento_percepcion".
 *
 * The followings are the available columns in table 'seguimiento_percepcion':
 * @property integer $id
 * @property integer $linea_servicio_contrato_id
 * @property integer $per_cliente
 * @property integer $per_sm
 * @property integer $fecha
 * @property integer $tipo_seguimiento
 *
 * The followings are the available model relations:
 * @property LineaServicioContrato $lineaServicioContrato
 */
class SeguimientoPercepcion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seguimiento_percepcion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('linea_servicio_contrato_id', 'required'),
			array('linea_servicio_contrato_id, per_cliente, per_sm, fecha, tipo_seguimiento', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, linea_servicio_contrato_id, per_cliente, per_sm, fecha, tipo_seguimiento', 'safe', 'on'=>'search'),
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
			'lineaServicioContrato' => array(self::BELONGS_TO, 'LineaServicioContrato', 'linea_servicio_contrato_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'linea_servicio_contrato_id' => 'Linea Servicio Contrato',
			'per_cliente' => 'Per Cliente',
			'per_sm' => 'Per Sm',
			'fecha' => 'Fecha',
			'tipo_seguimiento' => 'Tipo Seguimiento',
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
		$criteria->compare('linea_servicio_contrato_id',$this->linea_servicio_contrato_id);
		$criteria->compare('per_cliente',$this->per_cliente);
		$criteria->compare('per_sm',$this->per_sm);
		$criteria->compare('fecha',$this->fecha);
		$criteria->compare('tipo_seguimiento',$this->tipo_seguimiento);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeguimientoPercepcion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
