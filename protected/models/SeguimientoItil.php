<?php

/**
 * This is the model class for table "seguimiento_itil".
 *
 * The followings are the available columns in table 'seguimiento_itil':
 * @property integer $id
 * @property integer $cliente_id
 * @property integer $felicitaciones
 * @property integer $reclamos
 * @property integer $problemas
 * @property integer $cambios
 * @property integer $estado_cmdb
 * @property integer $incidentes
 * @property integer $requerimientos
 * @property integer $backlog
 * @property integer $indisponibilidad
 * @property integer $sip
 * @property integer $reuniones
 * @property integer $minutas
 * @property integer $reunion_servicio
 * @property integer $informe
 * @property integer $facturado
 * @property integer $facturacion_extra
 * @property integer $multas
 * @property integer $fecha
 * @property string $comentario
 * @property integer $tipo_seguimiento

 *
 * The followings are the available model relations:
 * @property Cliente $cliente
 */
class SeguimientoItil extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seguimiento_itil';
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
			array('cliente_id, felicitaciones, reclamos, problemas, cambios, estado_cmdb, incidentes, requerimientos, backlog, indisponibilidad, sip, reuniones, minutas, reunion_servicio, informe, facturado, facturacion_extra, multas, fecha, tipo_seguimiento,', 'numerical', 'integerOnly'=>true),
			array('comentario', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cliente_id, felicitaciones, reclamos, problemas, cambios, estado_cmdb, incidentes, requerimientos, backlog, indisponibilidad, sip, reuniones, minutas, reunion_servicio, informe, facturado, facturacion_extra, multas, fecha, comentario, tipo_seguimiento', 'safe', 'on'=>'search'),
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
			'felicitaciones' => 'Felicitaciones',
			'reclamos' => 'Reclamos',
			'problemas' => 'Problemas',
			'cambios' => 'Cambios',
			'estado_cmdb' => 'Estado CMDB',
			'incidentes' => 'Incidentes',
			'requerimientos' => 'Requerimientos',
			'backlog' => 'Backlog',
			'indisponibilidad' => 'Indisponibilidad',
			'sip' => 'SIP',
			'reuniones' => 'Reuniones',
			'minutas' => 'Minutas',
			'reunion_servicio' => 'Reunión Servicio',
			'informe' => 'Informe',
			'facturado' => 'Facturado',
			'facturacion_extra' => 'Facturación Extra',
			'multas' => 'Multas',
			'comentario' => 'Comentario',
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
		$criteria->compare('felicitaciones',$this->felicitaciones);
		$criteria->compare('reclamos',$this->reclamos);
		$criteria->compare('problemas',$this->problemas);
		$criteria->compare('cambios',$this->cambios);
		$criteria->compare('estado_cmdb',$this->estado_cmdb);
		$criteria->compare('incidentes',$this->incidentes);
		$criteria->compare('requerimientos',$this->requerimientos);
		$criteria->compare('backlog',$this->backlog);
		$criteria->compare('indisponibilidad',$this->indisponibilidad);
		$criteria->compare('sip',$this->sip);
		$criteria->compare('reuniones',$this->reuniones);
		$criteria->compare('minutas',$this->minutas);
		$criteria->compare('reunion_servicio',$this->reunion_servicio);
		$criteria->compare('informe',$this->informe);
		$criteria->compare('facturado',$this->facturado);
		$criteria->compare('facturacion_extra',$this->facturacion_extra);
		$criteria->compare('multas',$this->multas);
		$criteria->compare('fecha',$this->fecha);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('tipo_seguimiento',$this->tipo_seguimiento);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeguimientoItil the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
