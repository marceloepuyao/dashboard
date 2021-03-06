<?php

/**
 * This is the model class for table "issue".
 *
 * The followings are the available columns in table 'issue':
 * @property integer $id
 * @property integer $linea_servicio_id
 * @property integer $cliente_id
 * @property string $descripcion
 * @property string $fecha
 * @property integer $solucionado
 * @property integer $criticidad
 *
 * The followings are the available model relations:
 * @property Cliente $cliente
 */
class Issue extends CActiveRecord
{
	public $lineaservicios;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'issue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cliente_id, lineaservicios', 'required'),
			array('cliente_id, solucionado, criticidad', 'numerical', 'integerOnly'=>true),
			array('descripcion, fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cliente_id, lineaservicios, descripcion, fecha, solucionado, criticidad, fecha_solucionado', 'safe', 'on'=>'search'),
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
			'lineaServicios' => array(self::MANY_MANY, 'LineaServicio', 'issue_linea_servicio(issue_id, linea_servicio_id)'),
					
		);
	}
	
	public function beforeDelete(){
		IssueLineaServicio::model()->deleteAll("issue_id = $this->id");
		return parent::beforeDelete();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cliente_id' => 'Cliente',
			'descripcion' => 'Descripción',
			'fecha' => 'Fecha Creación',
			'solucionado' => 'Solucionado',
			'criticidad' => 'Criticidad',
			'lineaservicios'=> 'Líneas de Servicio',
			'fecha_solucionado'=> 'Fecha Solucionado',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('solucionado',$this->solucionado);
		$criteria->compare('criticidad',$this->criticidad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Issue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
