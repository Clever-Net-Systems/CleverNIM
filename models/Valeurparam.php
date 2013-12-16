<?php

class Valeurparam extends EZActiveRecord {
	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function beforeSave() {
		if ($this->parametre->type == 2) {
			$possibles = explode(',', $this->parametre->possibles);
			$this->_intname = "" . ($this->parametre ? $this->parametre->_intname : "N/A") . ": " . $possibles[$this->valeur] . "";
		} else {
			$this->_intname = "" . ($this->parametre ? $this->parametre->_intname : "N/A") . ": " . $this->valeur . "";
		}
		$this->user_id = Yii::app()->user->id;

		return parent::beforeSave();
	}

	public function beforeDelete() {
		$this->save();

		return parent::beforeDelete();
	}

	public function tableName() {
		return 'valeurparam';
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('valeur', 'type', 'type' => 'string'),
			array('valeur', 'required'),
			array('valeur', 'length', 'min' => 1),
			array('valeur', 'length', 'max' => 255),
			array('tag_id', 'required'),
			array('parametre_id', 'required'),
			array('valeur', 'safe', 'on' => 'search'),
			array('tag_id', 'safe', 'on'=>'search'),
			array('parametre_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'tag' => array(self::BELONGS_TO, 'Tag', 'tag_id'),
			'parametre' => array(self::BELONGS_TO, 'Tagparam', 'parametre_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'valeur' => Yii::t('app', 'Valeur'),
			'tag_id' => Yii::t('app', 'Tag'),
			'parametre_id' => Yii::t('app', 'Parametre'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.valeur', $this->valeur, true);
		$criteria->with[] = "tag";
		$criteria->together = true;
		$criteria->compare('tag._intname', $this->tag_id, true);
		$criteria->compare('t.parametre_id', $this->parametre_id, false);

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}
}
