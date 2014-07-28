<?php

/**
 * This is the model class for table "cliente".
 *
 * The followings are the available columns in table 'cliente':
 * @property integer $id
 * @property integer $usuario_id
 * @property string $industria
 * @property integer $empleados
 * @property integer $facturacion
 * @property integer $categoria
 * @property string $nombre
 * @property string $rut
 * @property string $hq
 * @property string $jp
 * @property string $kam
 * @property string $arquitecto
 * @property string $competidor
 *
 * The followings are the available model relations:
 * @property Usuario $usuario
 * @property Competidores[] $competidores
 * @property Contrato[] $contratos
 * @property Ejecutivos[] $ejecutivoses
 * @property Issue[] $issues
 */
class Cliente extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cliente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario_id', 'required'),
			array('usuario_id, empleados, facturacion, categoria', 'numerical', 'integerOnly'=>true),
			array('industria, nombre, hq, competidor', 'length', 'max'=>255),
			array('rut, jp, kam, arquitecto', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario_id, industria, empleados, facturacion, categoria, nombre, rut, hq, jp, kam, arquitecto, competidor', 'safe', 'on'=>'search'),
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
			'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
			'competidores' => array(self::HAS_MANY, 'Competidores', 'cliente_id'),
			'contratos' => array(self::HAS_MANY, 'Contrato', 'cliente_id'),
			'ejecutivoses' => array(self::HAS_MANY, 'Ejecutivos', 'cliente_id'),
			'seguimientoitil' => array(self::HAS_MANY, 'SeguimientoItil', 'cliente_id'),
			'issues' => array(self::HAS_MANY, 'Issue', 'cliente_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario_id' => 'Usuario',
			'industria' => 'Industria',
			'empleados' => 'Empleados',
			'facturacion' => 'Facturacion',
			'categoria' => 'Categoria',
			'nombre' => 'Nombre',
			'rut' => 'Rut',
			'hq' => 'Hq',
			'jp' => 'Jp',
			'kam' => 'Kam',
			'arquitecto' => 'Arquitecto',
			'competidor' => 'Competidor',
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
		$criteria->compare('usuario_id',$this->usuario_id);
		$criteria->compare('industria',$this->industria,true);
		$criteria->compare('empleados',$this->empleados);
		$criteria->compare('facturacion',$this->facturacion);
		$criteria->compare('categoria',$this->categoria);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('rut',$this->rut,true);
		$criteria->compare('hq',$this->hq,true);
		$criteria->compare('jp',$this->jp,true);
		$criteria->compare('kam',$this->kam,true);
		$criteria->compare('arquitecto',$this->arquitecto,true);
		$criteria->compare('competidor',$this->competidor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cliente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
