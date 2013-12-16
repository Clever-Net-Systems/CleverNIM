<?php

class Fait_tagauto extends EZActiveRecord {
	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function checkValue($val) {
		switch (Fait_tagauto::getOperateur_values($this->operateur)) {
			case "=": return $val == $this->valeur;
			case "!=": return $val != $this->valeur;
			case ">": return $val > $this->valeur;
			case "<": return $val < $this->valeur;
			case ">=": return $val >= $this->valeur;
			case "<=": return $val <= $this->valeur;
			case "IN": return in_array($val, explode(',', $this->valeur));
			default: return $val == $this->valeur;
		}
	}

	public static function getOperateur_values($index = null) {
		$t = array(0 => '=', 1 => '!=', 2 => '>', 3 => '<', 4 => '>=', 5 => '<=', 6 => 'IN', );
		return isset($index) ? $t[$index] : $t;
	}
	public static function getOperateur_index($value) {
		$t = array('=' => 0, '!=' => 1, '>' => 2, '<' => 3, '>=' => 4, '<=' => 5, 'IN' => 6, );
		return isset($t[$value]) ? $t[$value] : false;
	}

	public function beforeSave() {
		$this->_intname = "" . $this->fact . " " . $this->getOperateur_values($this->operateur) . " " . $this->valeur . "";
		$this->user_id = Yii::app()->user->id;

		return parent::beforeSave();
	}

	public function beforeDelete() {
		$this->save();

		return parent::beforeDelete();
	}

	public function tableName() {
		return 'fait_tagauto';
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('fact', 'type', 'type' => 'string'),
			array('fact', 'required'),
			array('fact', 'length', 'min' => 1),
			array('fact', 'length', 'max' => 255),
			array('valeur', 'type', 'type' => 'string'),
			array('valeur', 'required'),
			array('valeur', 'length', 'min' => 1),
			array('valeur', 'length', 'max' => 255),
			array('operateur', 'required'),
			array('operateur', 'type', 'type' => 'integer'),
			array('operateur', 'numerical', 'integerOnly' => true),
			array('tag_id', 'required'),
			array('fact', 'safe', 'on' => 'search'),
			array('valeur', 'safe', 'on' => 'search'),
			array('operateur', 'safe', 'on' => 'search'),
			array('tag_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'tag' => array(self::BELONGS_TO, 'Tagauto', 'tag_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'fact' => Yii::t('app', 'Fact'),
			'valeur' => Yii::t('app', 'Valeur'),
			'operateur' => Yii::t('app', 'Operateur'),
			'tag_id' => Yii::t('app', 'Tag'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.fact', $this->fact, true);
		$criteria->compare('t.valeur', $this->valeur, true);
		$criteria->compare('t.operateur', $this->operateur, false);
		$criteria->compare('t.tag_id', $this->tag_id, false);

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}
}
