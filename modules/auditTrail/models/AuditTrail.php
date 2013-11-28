<?php

/**
 * This is the model class for table "audit_trail".
 */
class AuditTrail extends EZActiveRecord {
	/**
	 * Log description
	 */
	public function getDescription() {
		$classname = $this->class;
		$model = call_user_func($classname . "::model");
		$obj = $model->findByPk($this->class_id);
		switch ($this->action) {
		case 'CREATE':
			if (get_class($obj) === get_class()) {
				return "Création de l'objet " . $this->class . " <b>" . $this->_intname . "</b>";
			} else {
				$url = Yii::app()->createUrl($this->class . '/update', array('id' => $this->class_id));
				$class = array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl($this->class . "/coda", array("id" => $this->class_id)));
				return "Création de l'objet " . $this->class . " <b>" . CHtml::link(CHtml::encode($this->_intname), $url, $class) . "</b>";
			}
		case 'UPDATE':
			if (get_class($obj) === get_class()) {
				return "Modification de la propriété <b>" . $this->field . "</b> de l'objet " . $this->class . " <b>" . $this->_intname . "</b> (" . $this->old_value . " -> " . $this->new_value . ")";
			} else {
				$url = Yii::app()->createUrl($this->class . '/update', array('id' => $this->class_id));
				$class = array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl($this->class . "/coda", array("id" => $this->class_id)));
				return "Modification de la propriété <b>" . $this->field . "</b> de l'objet " . $this->class . " <b>" . CHtml::link(CHtml::encode($this->_intname), $url, $class) . "</b> (" . $this->old_value . " -> " . $this->new_value . ")";
			}
		case 'DELETE':
			return "Suppression de l'objet " . $this->class . " <b>" . $this->_intname . "</b>";
		case 'IMPORT':
			return "Import de " . $this->_intname . " objets " . $this->class;
		default:
			return "Undefined";
		}
	}

	/**
	 * Distinct list of actions
	 */
	public function getActions() {
		$command = Yii::app()->db->createCommand("SELECT DISTINCT action FROM audit_trail");
		$actions = $command->queryAll(true);
		return $actions;
	}

	/**
	 * Distinct list of classes
	 */
	public function getClasses() {
		$command = Yii::app()->db->createCommand("SELECT DISTINCT class FROM audit_trail");
		$classes = $command->queryAll(true);
		return $classes;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return AuditTrail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'audit_trail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// No rules for input since this is read-only for the user
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stamp, user_id, action, class, class_id, field, _intname, old_value, new_value', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'stamp' => 'Date',
			'user_id' => 'Utilisateur',
			'action' => 'Action',
			'class' => 'Objet',
			'class_id' => 'Class ID',
			'field' => 'Field',
			'_intname' => 'Nom',
			'old_value' => 'Old Value',
			'new_value' => 'New Value',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('stamp',$this->stamp,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('class',$this->class,true);
		$criteria->compare('class_id',$this->class_id,true);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('_intname',$this->_intname,true);
		$criteria->compare('old_value',$this->old_value,true);
		$criteria->compare('new_value',$this->new_value,true);
		$criteria->order = 'stamp DESC';
		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
		));
	}
	
	public function scopes() {
		return array(
			'recently' => array(
				'order' => ' t.stamp DESC ',
			),

		);
	}
}
