<?php

/**
 * This is the model class for table "contrato".
 *
 * The followings are the available columns in table 'contrato':
 * @property integer $id
 * @property integer $cliente_id
 * @property integer $facturacion
 * @property string $inicio
 * @property string $fin
 * @property string $codigo_moebius
 * @property string $titulo
 *
 * The followings are the available model relations:
 * @property Cliente $cliente
 * @property LineaServicio[] $lineaServicios
 */
class Contrato extends CActiveRecord
{
	public $lineaservicios;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contrato';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cliente_id, titulo', 'required'),
			array('cliente_id, facturacion', 'numerical', 'integerOnly'=>true),
			array('codigo_moebius', 'length', 'max'=>20),
			array('titulo', 'length', 'max'=>100),
			array('inicio, fin', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cliente_id, facturacion, inicio, fin, codigo_moebius, titulo', 'safe', 'on'=>'search'),
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
			'lineaServicios' => array(self::MANY_MANY, 'LineaServicio', 'linea_servicio_contrato(contrato_id, linea_servicio_id)'),
			'sla' => array(self::HAS_MANY, 'Sla', 'contrato_id'),
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
			'facturacion' => 'Facturación',
			'inicio' => 'Inicio',
			'fin' => 'Fin',
			'codigo_moebius' => 'Código Moebius',
			'titulo' => 'Título',
			'lineaservicios'=>'Servicios Contratados'
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
		$criteria->compare('facturacion',$this->facturacion);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('fin',$this->fin,true);
		$criteria->compare('codigo_moebius',$this->codigo_moebius,true);
		$criteria->compare('titulo',$this->titulo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contrato the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
